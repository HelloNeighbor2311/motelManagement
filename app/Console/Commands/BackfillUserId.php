<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BackfillUserId extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:backfill {--user= : User id to assign (defaults to 1 or first user)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backfill user_id on tenant tables using provided user id or default first user';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $user = $this->option('user');

        if ($user) {
            $default = $user;
        } else {
            $default = DB::table('users')->where('id', 1)->value('id') ?? DB::table('users')->orderBy('id')->value('id');
        }

        if (! $default) {
            $this->error('No users found. Create a user first (php artisan db:seed or via tinker).');
            return 1;
        }

        $tables = ['KhuVuc', 'ToaNha', 'CanHo', 'KhachHang', 'HopDong', 'HoaDon', 'ThuChi', 'BaoCaoTaiChinh'];

        foreach ($tables as $table) {
            $count = DB::table($table)->whereNull('user_id')->count();
            if ($count > 0) {
                DB::table($table)->whereNull('user_id')->update(['user_id' => $default]);
                $this->info("Updated {$count} rows in {$table}");
            } else {
                $this->info("No rows to update in {$table}");
            }
        }

        $this->info('Backfill complete.');
        return 0;
    }
}
