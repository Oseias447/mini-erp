@extends('layouts.app')

@section('title', 'Gerenciar Cupons')

@section('content')
    <h2>Cupons</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('cupons.create') }}" class="btn btn-primary mb-3">Novo Cupom</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Código</th>
                <th>Valor</th>
                <th>Tipo</th>
                <th>Valor Mínimo</th>
                <th>Validade</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cupons as $cupom)
                <tr>
                    <td>{{ $cupom->codigo }}</td>
                    <td>R$ {{ number_format($cupom->valor, 2, ',', '.') }}</td>
                    <td>{{ $cupom->percentual ? 'Percentual' : 'Fixo' }}</td>
                    <td>R$ {{ number_format($cupom->valor_minimo, 2, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($cupom->validade)->format('d/m/Y') }}</td>
                    <td>
                        <form action="{{ route('cupons.destroy', $cupom) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
