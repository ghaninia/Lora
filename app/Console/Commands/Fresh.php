<?php

namespace App\Console\Commands;
use App\Repositories\Picture;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Fresh extends Command
{
    protected $signature = 'reinstall';
    protected $description = 'install again !';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Artisan::call("migrate:fresh") ;
        Artisan::call("cache:clear") ;
        Artisan::call("view:clear") ;
        Artisan::call("db:seed") ;
        Artisan::call("config:clear") ;
        Picture::uploadFolderDelete() ;
    }
}
