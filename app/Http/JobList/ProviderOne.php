<?php

namespace App\Http\JobList;

use Illuminate\Support\Facades\Http;

class ProviderOne extends BaseProviderAbstract
{
    public $apiUrl = 'https://www.mediaclick.com.tr/api/5d47f235330000623fa3ebf7.json';
    public $listId = 1;
    public $response;

    public function __construct()
    {
        $this->response = Http::get($this->apiUrl);
    }

    public function getList()
    {
        $jsonArrayList = $this->response->json();

        foreach ($jsonArrayList as $jsonArray) {
            $title = key($jsonArray);
            $difficulty = $jsonArray[$title]['level'];
            $time = $jsonArray[$title]['estimated_duration'];

            $this->saveData($this->listId, $title, $title, $time, $difficulty);
        }

        return true;
    }
}
