<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:user {--id=}';

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
        if ($this->option('id') == 'all') {
            $partners = DB::connection('manager')
                ->table('partners')
                ->get();

            foreach ($partners as $partner) {

//                dump($partner);

                $userData = [
                    'first_name' => $partner->name,
                    'last_name' => $partner->name,
                    'email' => $partner->email,
                    'password' => $partner->password,
                    'account_id' => rand(1, 100),
                    'partner_id' => $partner->id,
                    'update_at' => now(),
                ];

                try {
                    $user = DB::connection('mysql')
                        ->table('users')
                        ->where('partner_id', '=', $partner->id)
                        ->update($userData);

                    dump($user);
                } catch (\Exception $e) {
                    continue;
                }
            }
        }
    }
}
