<?php

namespace App\Console\Commands;

use App\Imports\ListingsImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;


class ImportListings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:listings {--path= : Path relative to current directory}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports New Listings';

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
     * Path is specified relative to current directory
     * @return mixed
     */
    public function handle()
    {
        $path = getcwd() . DIRECTORY_SEPARATOR  . $this->option('path');

        Excel::import(new ListingsImport, $path);
    }
}
