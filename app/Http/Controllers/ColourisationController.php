<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Colourisation;
use Illuminate\Http\Request;

class ColourisationController extends Controller
{
    /**
     * Show the form to create a new colourisation.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('colourisation.create');
    }

    /**
     * Store the colourisation.
     *
     * @param \Illuminate\Http\Request $input
     *
     * @return \Illuminate\Http\Response
     *
     * TODO: Validate $input
     * TODO: Ensure the colouried column is NULL
     * TODO: Success message
     */
    public function store(\Illuminate\Http\Request $input)
    {
        // Add the extras we need to make this work
        $input->merge([
            'user_id' => \Auth::user()->id,
        ]);

        foreach ($input->file('files') as $file) {
            // Save data for each file
            \App\Models\Colourisation::create(
                array_merge(
                    $input->only(['user_id', 'title']),
                    ['unprocessed' => $this->_upload($file)]
                )
            );
        }

        // Away we go
        return redirect(url('/dashboard'));
    }

    /**
     * Download an image.
     *
     * @param string $type    "original" or "colourised"
     * @param int    $imageID
     *
     * @return \Illuminate\Http\Response
     */
    public function download($imageID, $type)
    {
        // Get the record, check the user owns it
        $image = \App\Models\Colourisation::findOrFail($imageID);
        if ($image->user_id != \Auth::user()->id) {
            // TODO: 404
        }

        // Build the path
        switch ($type) {
            case 'original':
                $path = config('colourise.original-path') . '/' . \Auth::user()->id . '/' . $image->unprocessed;
                break;

            case 'colourised':
                $path = config('colourise.colourised-path') . '/' . \Auth::user()->id . '/' . $image->colourised;
                break;

            default:
                // TODO: 404
        }

        // Push the download
        return response()->download($path);
    }

    /**
     * Upload a file.
     *
     * @param \Illuminate\Http\UploadedFile $input
     *
     * @return string Full path to the uploaded file.
     */
    private function _upload(\Illuminate\Http\UploadedFile $file)
    {
        // Make the user's folder if necessary
        $path = config('colourise.original-path') . '/' . \Auth::user()->id;
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        // Get a unique filename
        do {
            $filename = str_random(20) . '.' . $file->guessExtension();

        } while (file_exists($path . '/' . $filename));

        // Put the file where it needs to go
        $file->move($path, $filename);

        // Return the path of the uploaded file
        return $filename;
    }
}
