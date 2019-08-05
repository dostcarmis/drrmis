<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Getcsvdataapi;
class Generatehydrometdata extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generates:hydromet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Data';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    public function __construct(Getcsvdataapi $getcsvdataapi)
    {
        parent::__construct();
        $this->getcsvdataapi = $getcsvdataapi;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
         $this->getcsvdataapi->savetextFile();
    }
}
