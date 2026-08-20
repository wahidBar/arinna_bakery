<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        $teamMembers = TeamMember::active()->get();

        return view('about.index', compact('teamMembers'));
    }
}
