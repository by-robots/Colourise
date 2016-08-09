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
     */
    public function handle()
    {
        $this->info('Let\'s begin.');

        // Get unprocessed images
        $unprocessed = \App\Models\Colourisation::whereNull('colourised')
            ->orderBy('created_at', 'asc')->get();

        // If we have none we can putour feet up
        if (count($unprocessed) < 1) {
            $this->info('Nothing to do.');
            exit;
        }

        // Let's get this show on the road
        foreach ($unprocessed as $image) {
            // Check the image exists or something will complain
            if (!file_exists($image->original)) {
                $this->error('Image not found: #' . $image->id);
                break;
            }

            // Get the filename of the image
            $filename = explode('/', $image->original);
            $filename = $filename[count($filename) - 1];

            // Make sure the processed directory for the user exists
            if (!file_exists(config('colourise.colourised-path') . '/' . \Auth::user()->id)) {
                mkdir(config('colourise.colourised-path') . '/' . \Auth::user()->id, 0755, true);
            }

            // And process it
            shell_exec('th ' . base_path() . '/lib/colorize/colorize.lua ' . $image->original . ' ' . config('colourise.colourised-path') . '/' . \Auth::user()->id . '/' . $filename);
            $image->colourised = config('colourise.colourised-path') . '/' . \Auth::user()->id . '/' . $filename;
            $image->save();

            $this->info('Image #' . $image->id . 'processed.');
        }
    }
}
