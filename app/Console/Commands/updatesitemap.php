<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\SiteMapController;

class updatesitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:updatesitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $siteMap = new SiteMapController();
        $siteMap->run_all();
        return 'Cron Job executed successfully';
    }
}
