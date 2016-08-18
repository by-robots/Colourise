<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Colourisation;

class ProcessOriginals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'colourise:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find unprocessed images and colourise them.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     *
     * TODO: Check for processing errors
     */
    public function handle()
    {
        $this->info('Let\'s begin.');
        $this->_processImages();

        $this->info('Creating  group archives.');
        $this->_createGroupArchives();

        $this->info('All done. Anyone for coffee?');
    }

    /**
     * Process unprocessed images.
     *
     * @return void
     */
    private function _processImages()
    {
        // Get unprocessed images
        $unprocessed = \App\Models\Colourisation::whereNull('colourised')
            ->orderBy('created_at', 'asc')->get();

        // If we have none we can putour feet up
        if (count($unprocessed) < 1) {
            $this->info('No images to process.');
            return;
        }

        // Let's get this show on the road
        foreach ($unprocessed as $image) {
            $originalPath   = config('colourise.original-path') . '/' . $image->user_id;
            $colourisedPath = config('colourise.colourised-path') . '/' . $image->user_id;

            // Check the image exists or something will complain
            if (!file_exists($originalPath . '/' . $image->unprocessed)) {
                $this->error('Image not found: #' . $image->id . '.');
                break;
            }

            // Make sure the processed directory for the user exists
            if (!file_exists($colourisedPath)) {
                mkdir($colourisedPath, 0755, true);
            }

            // And process it
            shell_exec('cd ' . base_path() . '/lib/colorize && th ./colorize.lua "' . $originalPath . '/' . $image->unprocessed . '" "' . $colourisedPath . '/' . $image->unprocessed . '"');
            $image->colourised = $image->unprocessed;
            $image->save();

            $this->info('Image #' . $image->id . ' processed.');
        }
    }

    /**
     * Process groups and create their archives.
     *
     * @return void
     */
    private function _createGroupArchives()
    {
        // Get groups that haven't had their archives created yet
        $groups = \App\Models\Group::whereNull('archive')->get();
        if (count($groups) < 1) {
            $this->info('No groups to process.');
            return;
        }

        // Loop through, build archives
        foreach ($groups as $group) {
            $zipper = new \Chumper\Zipper\Zipper;

            // Warn if some colourisations have failed
            if ($group->colourisations()->whereNull('colourised')->count() > 0) {
                $this->warning('Group #' . $group->id . ' (' . $group->name . ') has un-colourised images. These will be excluded.');
            }

            // Make the path for the archive
            $path = config('colourise.archive-path') . '/' . $group->id;
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            // Generate a filename
            do {
                $filename = str_random(20) . '.zip';

            } while (file_exists($path . '/' . $filename));

            // Create the archive
            $files     = $group->colourisations()->whereNotNull('colourised')->get();
            $fileArray = [];
            foreach ($files as $file) {
                $fileArray[] = config('colourise.colourised-path') . '/' . $file->user_id . '/' . $file->colourised;
            }

            $zipper->make($path . '/' . $filename)->add($fileArray);

            $group->archive = $filename;
            $group->save();

            $this->info('Archive created for Group #' . $group->id . ' (' . $group->name . ').');
        }
    }
}
