<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'role')) {
            return;
        }

        $driver = DB::getDriverName();

        if (! in_array($driver, ['mysql', 'mariadb'], true)) {
            return;
        }

        DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('super_admin','admin','member','customer') NOT NULL DEFAULT 'customer'");
    }

    public function down(): void
    {
        if (! Schema::hasColumn('users', 'role')) {
            return;
        }

        $driver = DB::getDriverName();

        if (! in_array($driver, ['mysql', 'mariadb'], true)) {
            return;
        }

        DB::table('users')->where('role', 'super_admin')->update(['role' => 'admin']);

        DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('admin','member','customer') NOT NULL DEFAULT 'customer'");
    }
};
