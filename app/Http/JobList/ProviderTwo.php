<?php

namespace App\Http\JobList;

use Illuminate\Support\Facades\Http;

class ProviderTwo extends BaseProviderAbstract
{
    public $apiUrl = 'https://www.mediaclick.com.tr/api/5d47f24c330000623fa3ebfa.json';
    public $listId = 2;
    public $response;

    public function __construct()
    {
        $this->response = Http::get($this->apiUrl);
    }

    public function getList()
    {
        $jsonArrayList = $this->response->json();

        foreach ($jsonArrayList as $jsonArray) {
            $title = $jsonArray['id'];
            $difficulty = $jsonArray['zorluk'];
            $time = $jsonArray['sure'];

            $this->saveData($this->listId, $title, $title, $time, $difficulty);
        }

        return true;
    }
}
