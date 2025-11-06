<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SyncInvoicesToAppSeeder extends Seeder
{
    public function run(): void
    {
        $connOffice = 'mysql_office';
        $connBack   = 'mysql_backoffice';
        $connApp    = 'mysql_app';

        // 1) Copiar invoices do OFFICE
        $officeInvoices = DB::connection($connOffice)
            ->table('invoices')
            ->orderBy('id')
            ->get();

        $dataOffice = $officeInvoices->map(function ($u) {
            return [
                'id'            => $u->id,
                'user_id'       => $u->user_id,
                'due_date'      => $u->due_date,
                'value'         => $u->value,
                'payment_date'  => $u->payment_date,
                'payment_value' => $u->payment_value,
                'created_at'    => $u->created_at ?? now(),
                'updated_at'    => $u->updated_at ?? now(),
                'source'        => 'office',
            ];
        })->toArray();

        DB::connection($connApp)
            ->table('invoices')
            ->insertOrIgnore($dataOffice);

        // 2) Copiar invoices do BACKOFFICE
        $backInvoices = DB::connection($connBack)
            ->table('invoices')
            ->orderBy('id')
            ->get();

        $dataBack = $backInvoices->map(function ($u) {
            return [
                'id'            => $u->id,
                'user_id'       => $u->user_id,
                'due_date'      => $u->due_date,
                'value'         => $u->value,
                'payment_date'  => $u->payment_date,
                'payment_value' => $u->payment_value,
                'created_at'    => $u->created_at ?? now(),
                'updated_at'    => $u->updated_at ?? now(),
                'source'        => 'backoffice',
            ];
        })->toArray();

        DB::connection($connApp)
            ->table('invoices')
            ->insertOrIgnore($dataBack);
    }
}
