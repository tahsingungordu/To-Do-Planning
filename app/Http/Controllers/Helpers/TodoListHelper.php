<?php

namespace App\Http\Controllers\Helpers;

use App\Models\TodoList;

class TodoListHelper
{
    public $levels = [5, 4, 3, 2, 1];

    /**
     * Zorluğa göre saatlik olarak iş listesi
     *
     * @return mixed
     */
    public function getJobsByDifficulty()
    {
        foreach ($this->levels as $level) {
            $jobs = TodoList::where('difficulty', $level)->get();

            foreach ($jobs as $job) {
                for ($jobHour = 1; $jobHour <= $job->time_hour; $jobHour++) {
                    $hours[$level][] = [
                        'id' => $job->id,
                        'title' => $job->title,
                    ];
                }
            }
        }

        return $hours;
    }

    /**
     * İş listesini haftalık olarak düzenleme
     *
     * @param $jobList
     *
     * @return array
     */
    public function weeklyJobList($jobList)
    {
        $newJobList = [];

        foreach ($jobList as $level => $jobs) {
            $startWeek = 0;
            $jobKeyWeek = 0;
            foreach ($jobs as $job) {
                $modWeek = $jobKeyWeek%45;
                if ($modWeek == 0) {
                    $startWeek++;
                }

                $newJobList[$level][$startWeek][] = $job;
                $jobKeyWeek++;
            }
        }

        return $newJobList;
    }

    /**
     * Saatlik iş listesinde zorluğa göre tamamlama sonrası bir alt zorluk derecesini seçme
     *
     * @param $newLevel
     * @param $hours
     *
     * @return int|mixed
     */
    public function checkNewLevel($newLevel, $hours)
    {
        if ($newLevel != 0 && count($hours[$newLevel]) == 0) {
            $newLevel = $newLevel - 1;

            if ($newLevel != 0) {
                $newLevel = $this->checkNewLevel($newLevel, $hours);
            }
        }

        return $newLevel;
    }

    /**
     * Developer bazlı iş listesi
     *
     * @return array
     */
    public function jobsByDeveloper()
    {
        $hours = $this->getJobsByDifficulty();

        $largestTotalObj = TodoList::groupBy('difficulty')
                                   ->selectRaw('sum(time_hour) as sum, difficulty')
                                   ->orderBy('sum', 'DESC')
                                   ->first();
        $largestTotalHour = $largestTotalObj->sum;

        $totalHour = null;
        $devList = config('dev_lists');
        for ($startHour = 1; $startHour < $largestTotalHour; $startHour++) {

            foreach ($this->levels as $level) {
                if (count($hours[$level]) == 0) {
                    $newLevel = $this->checkNewLevel($level - 1, $hours);

                    if (isset($hours[$newLevel])) {
                        $selectHour = array_shift($hours[$newLevel]);
                        if ($selectHour == null) {
                            if ($totalHour == null) {
                                $totalHour = $startHour - 1;
                            }
                        } else {
                            foreach ($devList[$level] as $developerKey => $developer) {
                                if ($developerKey != 0) {
                                    $selectHour = array_shift($hours[$newLevel]);
                                }
                                $jobList[$level . '-' . $developerKey][] = $selectHour;
                            }
                        }
                    }
                } else {
                    $selectHour = array_shift($hours[$level]);
                    foreach ($devList[$level] as $developerKey => $developer) {
                        if ($developerKey != 0) {
                            $selectHour = array_shift($hours[$level]);
                        }
                        $jobList[$level . '-' . $developerKey][] = $selectHour;
                    }
                }
            }
        }

        return [
            'jobList' => $jobList,
            'weeklyJobList' => $this->weeklyJobList($jobList),
            'totalHour' => $totalHour
        ];
    }
}
