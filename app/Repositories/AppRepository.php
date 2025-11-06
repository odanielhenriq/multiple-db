<?php
namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use \Illuminate\Support\Collection;

class AppRepository implements AppRepositoryInterface
{
    public function listUsers(): Collection
    {
        //obter os dados dos dados já mesclados do banco app
        // $usersApp   = DB::connection('mysql_app')->table('users')->get();

        //obter dados de ambos os bancos
        $usersOffice = DB::connection('mysql_office')
            ->table('users')
            ->select('*', DB::raw("'office' as origem"))
            ->get();
        $usersBack = DB::connection('mysql_backoffice')
            ->table('users')
            ->select('*', DB::raw("'backoffice' as origem"))
            ->get();

        $users = $usersOffice->merge($usersBack);
        return $users;
    }

    public function listInvoices(): Collection
    {
        //obter os dados dos dados já mesclados do banco app
        // $invoices = $this->getInvoicesByConnection('mysql_app');

        //obter dados de ambos os bancos
        $invoicesOffice = $this->getInvoicesByConnection('mysql_office', 'office');
        $invoicesBack   = $this->getInvoicesByConnection('mysql_backoffice', 'backoffice');

        $invoices = $invoicesOffice->merge($invoicesBack)
            ->map(fn($r) => $this->presentInvoice($r));

        return $invoices;
    }

    public function getInvoicesByConnection(string $connection, string $origem)
    {
        return DB::connection($connection)
            ->table('invoices')
            ->join('users', 'users.id', '=', 'invoices.user_id')
            ->select(
                'users.name',
                'users.email',
                'invoices.id as invoice_id',
                'invoices.due_date',
                'invoices.value',
                'invoices.payment_date',
                'invoices.payment_value',
                DB::raw("'{$origem}' as origem")
            )
            ->get();
    }

    private function presentInvoice(object $r): object
    {
        $r->due_date      = $this->dateBr($r->due_date);
        $r->payment_date  = $r->payment_date ? $this->dateBr($r->payment_date) : '-';
        $r->value         = $this->moneyBr($r->value);
        $r->payment_value = $r->payment_value !== null ? $this->moneyBr($r->payment_value) : '-';

        return $r;
    }

    private function dateBr($date): string
    {
        // aceita string/Carbon/DateTime
        return Carbon::parse($date)->format('d/m/Y');
    }

    private function moneyBr($value): string
    {
        return 'R$ ' . number_format((float) $value, 2, ',', '.');
    }

}
