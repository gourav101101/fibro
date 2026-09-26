<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = config('admin.seed_email');
        $password = config('admin.seed_password');

        if (! $email || ! $password) {
            $this->command?->warn('Admin user was not created. Set ADMIN_SEED_EMAIL and ADMIN_SEED_PASSWORD first.');
            return;
        }

        $admin = config('admin.seed_current_email')
            ? AdminUser::where('email', config('admin.seed_current_email'))->first()
            : null;
        $admin ??= AdminUser::where('email', $email)->first();

        ($admin ?? new AdminUser())->fill([
            'name' => config('admin.seed_name', 'Fibro Admin'),
            'email' => $email,
            'password' => $password,
        ])->save();
    }
}
