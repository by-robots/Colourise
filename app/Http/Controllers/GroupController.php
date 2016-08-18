<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Colourisation;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Download a group.
     *
     * @param int $groupID
     *
     * @return \Illuminate\Http\Response
     */
    public function download($groupID)
    {
        // Get the record, check the user owns it
        $group = \App\Models\Group::findOrFail($groupID);
        if ($group->colourisations()->first()->user_id != \Auth::user()->id) {
            // TODO: 404
        }

        // Build the path
        $path = config('colourise.archive-path') . '/' . $group->id . '/' . $group->archive;

        // Push the download
        return response()->download($path);
    }
}
