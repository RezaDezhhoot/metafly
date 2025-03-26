<?php

namespace App\Console\Commands;

use App\Models\User;
use Database\Seeders\PermissionTableSeeder;
use Database\Seeders\RoleTableSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SyncRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-role {--super-admin-id=1} {--truncate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $truncate = $this->option('truncate');
        $superAdminId = $this->option('super-admin-id');
        if ($truncate) {
            Schema::disableForeignKeyConstraints();
            Permission::query()->truncate();
            Role::query()->truncate();
            Schema::enableForeignKeyConstraints();
        }
        // Import permissions
        Artisan::call('db:seed', [
            '--class' => PermissionTableSeeder::class,
            '--force' => true
        ]);
        // Import roles
        Artisan::call('db:seed', [
            '--class' => RoleTableSeeder::class,
            '--force' => true
        ]);
        $permission = Permission::all()->pluck('name');
        $administrator = Role::findByName('administrator')->syncPermissions($permission);
        $admin = Role::findByName('admin');
        if ($user = User::query()->find($superAdminId)) {
            $user->syncRoles([$administrator->name,$admin->name]);
        }
    }
}
