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
        $this->info('Let\'s begin...');

        // Get unprocessed images
        $unprocessed = \App\Models\Colourisation::whereNull('colourised')
            ->orderBy('created_at', 'asc')->get();

        // If we have none we can putour feet up
        if (count($unprocessed) < 1) {
            $this->info('...nothing to do.');
            exit;
        }

        // Let's get this show on the road
        foreach ($unprocessed as $image) {
            $originalPath   = config('colourise.original-path') . '/' . $image->user_id;
            $colourisedPath = config('colourise.colourised-path') . '/' . $image->user_id;

            // Check the image exists or something will complain
            if (!file_exists($originalPath . '/' . $image->unprocessed)) {
                $this->error('Image not found: #' . $image->id);
                break;
            }

            // Make sure the processed directory for the user exists
            if (!file_exists($colourisedPath)) {
                mkdir($colourisedPath, 0755, true);
            }

            // And process it
            shell_exec('cd ' . base_path() . '/lib/colorize && th ./colorize.lua ' . $originalPath . '/' . $image->unprocessed . ' ' . $colourisedPath . '/' . $image->unprocessed);
            $image->colourised = $image->unprocessed;
            $image->save();

            $this->info('Image #' . $image->id . ' processed.');
        }

        $this->info('Anyone for coffee?');
    }
}
