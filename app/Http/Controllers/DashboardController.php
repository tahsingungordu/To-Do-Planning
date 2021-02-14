<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helpers\TodoListHelper;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $jobsByDeveloper = Cache::remember('cacheJobsByDeveloper', 86400, function () {
            return (new TodoListHelper)->jobsByDeveloper();
        });

        $totalCompletionWeek = ceil($jobsByDeveloper['totalCompletionHour']/45);
        $totalCompletionDay = ceil($jobsByDeveloper['totalCompletionHour']/9);

        return view('dashboard', [
            'weeklyJobList' => $jobsByDeveloper['weeklyJobList'],
            'totalCompletionHour' => $jobsByDeveloper['totalCompletionHour'],
            'totalCompletionDay' => $totalCompletionDay,
            'totalCompletionWeek' => $totalCompletionWeek,
        ]);
    }


}
