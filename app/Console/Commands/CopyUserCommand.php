<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CopyUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'copy:users';

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
        DB::connection('mysql')->table('users')->truncate();

        $partners = DB::connection('manager')
            ->table('partners')
            ->get();

        foreach ($partners as $partner) {
            $userData = [
                'first_name' => $partner->name,
                'last_name' => $partner->name,
                'email' => $partner->email,
                'password' => $partner->password,
                'account_id' => rand(1, 100),
                'partner_id' => $partner->id,
                'created_at' => now(),
            ];

            try {
                DB::connection('mysql')->table('users')->insert($userData);
            } catch (\Exception $e) {
                continue;
            }
        }
    }
}
