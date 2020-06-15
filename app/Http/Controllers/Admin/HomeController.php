<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Test\TestAttempt;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $attempts = TestAttempt::OrderedByCreatedDesc()->paginate(20);
        return view('admin.home', compact('attempts'));
    }
}
