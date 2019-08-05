<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Notifval;
use App\Models\Notification;
use DB;
use App\Services\Checkfornotification;


class CheckNotification extends Command
{
    /**
 * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will check if rain value for every sensors exceeded the threshold value';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $checknotification;
    /**
     * Create a new command instance.
     *
     * @return void
     */

    public function __construct(Checkfornotification $checknotification)
    {
        
        parent::__construct();
        $this->checknotification = $checknotification;
        
    }

    public function handle()
    {
       $this->checknotification->docheck();
        
    }
}
