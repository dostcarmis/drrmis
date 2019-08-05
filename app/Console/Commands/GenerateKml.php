<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Generatekmlservice;
class GenerateKml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:contour';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will generate contour map on homepage';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Generatekmlservice $generatekmlservice)
    {
        parent::__construct();
        $this->generatekmlservice = $generatekmlservice;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->generatekmlservice->doAll();
    }
}
