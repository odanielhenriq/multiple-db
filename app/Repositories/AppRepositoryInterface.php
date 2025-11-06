<?php
namespace App\Repositories;

use Illuminate\Support\Collection;

interface AppRepositoryInterface
{
    /**
     * Retorna usuários mesclados dos bancos mysql_office e mysql_backoffice.
     * Se quiser, você pode aceitar filtros por aqui no futuro.
     */
    public function listUsers(): Collection;

    public function listInvoices(): Collection;
}
