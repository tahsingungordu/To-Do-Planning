<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateJobLists extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'todo:create-job-lists';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'İş listelerini kaydeder';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return string
     * @throws \Throwable
     */
    public function handle()
    {
        if ($this->confirm('İş listeleri kayıt edilecek onaylıyor musunuz?', true)) {

            $this->line('İş listeleri kayıt işlemi başladı.');

            foreach (config('job_lists') as $providerName) {
                $fullPath = file_exists(dirname(__DIR__, 2) . '/Http/JobList/' . $providerName . '.php');
                if ($fullPath) {
                    $className = '\\App\Http\\JobList\\' . $providerName;

                    $this->info($providerName . ' isimli iş listesi eklenmeye başladı.');

                    $getList = (new $className)->getList();
                    if ($getList) {
                        $this->info($providerName . ' isimli iş listesi ekleme işlemi tamamlandı.');
                    } else {
                        $this->info($providerName . ' isimli iş listesi ekleme işleminde hata oluştu.');
                    }
                }

            }

            $this->line('İş listeleri kayıt işlemi tamamlandı.');
        }
    }
}
