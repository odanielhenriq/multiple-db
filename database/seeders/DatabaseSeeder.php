<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(MultiDatabaseSeeder::class);

        $this->call(SyncUsersToAppSeeder::class);

        $this->call(SyncInvoicesToAppSeeder::class);
    }
}
