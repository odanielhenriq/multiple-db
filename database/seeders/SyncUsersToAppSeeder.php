<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SyncUsersToAppSeeder extends Seeder
{
    public function run(): void
    {
        $office = DB::connection('mysql_office')->table('users')->get();
        $back   = DB::connection('mysql_backoffice')->table('users')->get();

        $toInsert = [];

        foreach ($office as $u) {
            $toInsert[] = [
                'id'                => $u->id,
                'name'              => $u->name,
                'email'             => $u->email,
                'password'          => $u->password ?? null,
                'email_verified_at' => $u->email_verified_at,
                'created_at'        => $u->created_at ?? now(),
                'updated_at'        => $u->updated_at ?? now(),
                'source'            => 'office',
            ];
        }

        foreach ($back as $u) {
            $toInsert[] = [
                'id'                => $u->id,
                'name'              => $u->name,
                'email'             => $u->email,
                'password'          => $u->password ?? null,
                'email_verified_at' => $u->email_verified_at,
                'created_at'        => $u->created_at ?? now(),
                'updated_at'        => $u->updated_at ?? now(),
                'source'            => 'backoffice',
            ];
        }

        // Inserir todos os registros de uma vez
        DB::connection('mysql_app')
            ->table('users')
            ->insertOrIgnore($toInsert);
    }
}
