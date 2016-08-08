<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

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
                'pending'  => \Auth::user()->colourisations()->whereNull('colourised')->get(),
                'complete' => \Auth::user()->colourisations()->whereNotNull('colourised')->get(),
            ]
        );
    }
}
