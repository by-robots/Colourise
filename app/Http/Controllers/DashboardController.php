<?php namespace App\Http\Controllers;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view(
            'dashboard.show',
            [
                'pendingGroups'   => \Auth::user()->incompleteGroups(),
                'completeGroups'  => \Auth::user()->completeGroups(),
                'pendingSingles'  => \Auth::user()->colourisations()
                    ->whereNull('colourised')->whereNull('group_id')->get(),
                'completeSingles' => \Auth::user()->colourisations()
                    ->whereNotNull('colourised')->whereNull('group_id')->get(),
            ]
        );
    }
}
