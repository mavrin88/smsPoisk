<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:record';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $partnerData = [
            'name' => 'NewTest',
            'email' => 'NewTest2',
            'password' => 'NewTest',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $partner = DB::connection('manager')
            ->table('partners')
            ->insertGetId($partnerData);

        dump($partner);
    }
}
