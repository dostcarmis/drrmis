<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Getcsvdataapi;

class RunMiner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    private $getcsvservices;
    protected $signature = 'run:miner';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will download data.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Getcsvdataapi $getcsvservices)
    {
        parent::__construct();
        $this->getcsvservices = $getcsvservices;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->getcsvservices->getapistocsv();
    }
}
