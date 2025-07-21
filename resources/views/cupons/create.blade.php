@extends('layouts.app')

@section('title', 'Novo Cupom')

@section('content')
    <h2>Criar Novo Cupom</h2>

    <form action="{{ route('cupons.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Código</label>
            <input type="text" name="codigo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Valor</label>
            <input type="number" step="0.01" name="valor" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Tipo</label>
            <select name="percentual" class="form-control" required>
                <option value="0">Desconto Fixo (R$)</option>
                <option value="1">Desconto Percentual (%)</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Valor Mínimo do Pedido</label>
            <input type="number" step="0.01" name="valor_minimo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Validade</label>
            <input type="date" name="validade" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="{{ route('cupons.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
