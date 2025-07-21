@extends('layouts.app')

@section('title', 'Editar Produto')

@section('content')
    <h2>Editar Produto</h2>

    <form action="{{ route('produtos.update', $produto) }}" method="POST" class="mt-3">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Nome</label>
            <input type="text" name="nome" class="form-control" required value="{{ old('nome', $produto->nome) }}">
        </div>

        <div class="mb-3">
            <label>Preço</label>
            <input type="number" step="0.01" name="preco" class="form-control" required value="{{ old('preco', $produto->preco) }}">
        </div>

        @foreach ($produto->estoques as $estoque)
            <div class="mb-3">
                <label>Variação: {{ $estoque->variacao }}</label>
                <input type="number" name="estoques[{{ $estoque->id }}][quantidade]" class="form-control" value="{{ $estoque->quantidade }}">
            </div>
        @endforeach
        <button type="submit" class="btn btn-success">Atualizar</button>
        <a href="{{ route('produtos.index') }}" class="btn btn-danger">Cancelar</a>
    </form>
@endsection