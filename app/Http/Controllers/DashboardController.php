<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helpers\TodoListHelper;

class DashboardController extends Controller
{
    public function index()
    {
        $jobsByDeveloper = (new TodoListHelper)->jobsByDeveloper();

        return view('dashboard', [
            'weeklyJobList' => $jobsByDeveloper['weeklyJobList']
        ]);
    }


}
