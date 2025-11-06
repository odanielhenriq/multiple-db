<?php
namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Database\Seeder;

class MultiDatabaseSeeder extends Seeder
{
    public function run(): void
    {

        $officeUsers = User::factory(10)
            ->make()
            ->each(function (User $user) {
                $user->setConnection('mysql_office');
                $user->save();

                $this->createInvoicesForUser($user, 'mysql_office');
            });

        $backofficeUsers = User::factory(10)
            ->make()
            ->each(function (User $user) {
                $user->setConnection('mysql_backoffice');
                $user->save();

                $this->createInvoicesForUser($user, 'mysql_backoffice');
            });

        $duplicatedFromOffice = $officeUsers->take(3);
        foreach ($duplicatedFromOffice as $officeUser) {
            $user = User::factory()->make([
                'name' => $officeUser->name, 'email' => $officeUser->email,
            ]);
            $user->setConnection('mysql_backoffice');
            $user->save();

            $this->createInvoicesForUser($user, 'mysql_backoffice');
        }

        $duplicatedFromBack = $backofficeUsers->take(3);
        foreach ($duplicatedFromBack as $backUser) {
            $user = User::factory()->make([
                'name'  => $backUser->name,
                'email' => $backUser->email,
            ]);
            $user->setConnection('mysql_office');
            $user->save();

            $this->createInvoicesForUser($user, 'mysql_office');
        }
    }

    private function createInvoicesForUser(User $user, string $connection): void
    {
        Invoice::factory(fake()->numberBetween(10, 15))
            ->make(['user_id' => $user->id])
            ->each(function (Invoice $invoice) use ($connection) {
                $invoice->setConnection($connection);
                $invoice->save();
            });
    }
}
