<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Checkforfloodnotification;

class Checkfloodnotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:flood';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check flood notification';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Checkforfloodnotification $checkforfloodnotification)
    {
        parent::__construct();
        $this->checkforfloodnotification = $checkforfloodnotification;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->checkforfloodnotification->checkfloodvaluefromthreshold();
    }
}
