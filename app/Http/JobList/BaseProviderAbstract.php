<?php

namespace App\Http\JobList;

use App\Models\TodoList;

abstract class BaseProviderAbstract
{
    abstract function getList();

    public function saveData($listId, $externalId, $title, $time, $difficulty)
    {
        $todoList = TodoList::updateOrCreate(
            [
                'job_list_id' => $listId,
                'external_id' => $externalId,
            ],
            [
                'title' => $title,
                'time_hour' => $time,
                'difficulty' => $difficulty,
            ]
        );

        return $todoList;
    }
}
