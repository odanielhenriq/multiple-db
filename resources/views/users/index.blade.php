@extends('layouts.app')

@section('content')
    <div class="container">
        <div class=" justify-content-between align-items-center mb-3">
            <h1 class="h3 mb-0">
                Usuários
                <span class="badge bg-secondary">{{ $info->count() }}</span>
            </h1>
        </div>

        @if ($info->isEmpty())
            <div class="alert alert-warning">Nenhum usuário encontrado.</div>
        @else
            <div class="card shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="">{!! sort_link('name', 'Nome') !!}</th>
                                <th class="">{!! sort_link('email', 'E-mail') !!}</th>
                                <th class="text-end">{!! sort_link('origem', 'Origem') !!}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($info as $user)
                                <tr>
                                    <td class="fw-medium">{{ $user->name }}</td>
                                    <td class="text-muted">{{ $user->email }}</td>
                                    <td class="text-end">
                                        @php $origem = $user->origem ?? '—'; @endphp
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
