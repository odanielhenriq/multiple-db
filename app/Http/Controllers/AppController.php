<?php
namespace App\Http\Controllers;

use App\Repositories\AppRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class AppController extends Controller
{
    private $appRepository;

    public function __construct(
        AppRepository $appRepository
    ) {
        $this->appRepository = $appRepository;
    }

    //bancos:
    // mysql_app
    // mysql_office
    // mysql_backoffice
    public function listUsers()
    {
        try {

            $sort = request('sort', 'name');
            $dir  = request('dir', 'desc');

            $collection = $this->appRepository->listUsers();

            $keyFn = match ($sort) {
                'name'   => fn($r)   => $r->name,
                'email'  => fn($r)  => $r->email,
                'origem' => fn($r) => $r->origem,
                default  => fn($r)  => $r->name,
            };

            $sorted = $dir === 'asc'
                ? $collection->sortBy($keyFn)->values()
                : $collection->sortByDesc($keyFn)->values();

            [$info, $paginator] = $this->paginateCollection($sorted, 20);

            return view('users.index', compact('info', 'paginator'));

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Não foi possível listar os usuários, tente novamente mais tarde',
                'error'   => $th->getMessage(),
            ], 500);
        }

    }

    public function listInvoices()
    {
        try {
            $sort = request('sort', 'due_date');
            $dir  = request('dir', 'desc');

            $collection = $this->appRepository->listInvoices();

            $keyFn = match ($sort) {
                'due_date'      => fn($r)      => $r->due_date,
                'payment_date'  => fn($r)  => $r->payment_date,
                'value'         => fn($r)         => $r->value,
                'payment_value' => fn($r) => $r->payment_value,
                'email'         => fn($r)         => $r->email,
                'origem'        => fn($r)        => $r->origem,
                default         => fn($r)         => $r->name,
            };

            $sorted = $dir === 'asc'
                ? $collection->sortBy($keyFn)->values()
                : $collection->sortByDesc($keyFn)->values();

            [$info, $paginator] = $this->paginateCollection($sorted, 20);

            return view('invoices.index', compact('info', 'paginator'));

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Não foi possível listar os usuários, tente novamente mais tarde',
                'error'   => $th->getMessage(),
            ], 500);
        }

    }

    private function paginateCollection($collection, int $perPage = 20): array
    {
        $perPage = (int) request('per_page', $perPage);
        $page    = LengthAwarePaginator::resolveCurrentPage();
        $total   = $collection->count();

        // fatia da página atual
        $items = $collection->forPage($page, $perPage)->values();

        $paginator = new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            [
                'path'  => request()->url(),
                'query' => request()->query(),
            ]
        );
        return [$items, $paginator];
    }
}
