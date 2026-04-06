<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlayerController extends Controller
{
    public function dashboard()
    {
        return view('dashboards.player');
    }

    public function matches()
    {
        return view('player.matches');
    }

    public function statistics()
    {
        return view('player.statistics');
    }

    public function team()
    {
        return view('player.team');
    }

    public function achievements()
    {
        return view('player.achievements');
    }

    public function profile()
    {
        return view('player.profile');
    }
}