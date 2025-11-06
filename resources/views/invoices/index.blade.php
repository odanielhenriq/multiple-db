@extends('layouts.app')

@section('content')
    <div class="container">
        <div class=" justify-content-between align-items-center mb-3">
            <h1 class="h3 mb-0">
                Invoices
                <span class="badge bg-secondary">{{ $info->count() }}</span>
            </h1>
        </div>

        @if ($info->isEmpty())
            <div class="alert alert-warning">Nenhuma fatura encontrada.</div>
        @else
            <div class="card shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="">{!! sort_link('name', 'Nome') !!}</th>
                                <th class="">{!! sort_link('email', 'E-mail') !!}</th>
                                <th class="">{!! sort_link('due_date', 'Data de vencimento') !!}</th>
                                <th class="">{!! sort_link('value', 'Valor') !!}</th>
                                <th class="">{!! sort_link('payment_date', 'Data do Pagamento') !!}</th>
                                <th class="">{!! sort_link('payment_value', 'Valor do Pagamento') !!}</th>
                                <th class="">{!! sort_link('origem', 'Origem') !!}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($info as $invoice)
                                <tr>
                                    <td class="fw-medium">{{ $invoice->name }}</td>
                                    <td class="text-muted">{{ $invoice->email }}</td>
                                    <td class="fw-medium">{{ $invoice->due_date }}</td>
                                    <td class="fw-medium">{{ $invoice->value }}</td>
                                    <td class="fw-medium">{{ $invoice->payment_date }}</td>
                                    <td class="fw-medium">{{ $invoice->payment_value }}</td>

                                    <td class="text-end">
                                        @php $origem = $invoice->origem ?? '—'; @endphp
                                        <span
                                            class="badge
                  @if ($origem === 'office') bg-primary
                  @elseif($origem === 'backoffice') bg-success
                  @else bg-secondary @endif">
                                            {{ $origem }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                    <div class="mt-3">
                        {{ $paginator->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
