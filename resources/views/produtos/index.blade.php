@extends('layouts.app')

@section('title', 'Produtos')

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h2>Produtos</h2>
        <div>
            <a href="{{ route('carrinho.index') }}" class="btn btn-primary">
                <i class="fas fa-shopping-cart"></i> Carrinho
            </a>
            <a href="{{ route('produtos.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Novo Produto
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-hover">
        <thead class="table-dark">
            <tr>
                <th>Nome</th>
                <th>Preço</th>
                <th>Estoque</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        @forelse($produtos as $produto)
            <tr>
                <td>{{ $produto->nome }}</td>
                <td>R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                <td>
                    @if ($produto->estoques->count())
                        <ul class="list-unstyled mb-0">
                            @foreach ($produto->estoques as $estoque)
                                <li class="d-flex justify-content-between align-items-center mb-1">
                                    <span>{{ $estoque->variacao }} — {{ $estoque->quantidade }}</span>
                                    <form action="{{ route('carrinho.add') }}" method="POST" class="ms-2">
                                        @csrf
                                        <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                                        <input type="hidden" name="variacao_id" value="{{ $estoque->id }}">
                                        <button class="btn btn-success btn-sm">
                                            <i class="fas fa-plus"></i> Comprar
                                        </button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <span class="text-muted">Sem estoque cadastrado</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('produtos.edit', $produto) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-pen"></i>Editar
                    </a>
                    <form action="{{ route('produtos.destroy', $produto) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Deseja excluir este produto?')">
                            <i class="fas fa-xmark"></i>Excluir
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4" class="text-center">Nenhum produto cadastrado.</td></tr>
        @endforelse
        </tbody>
    </table>
@endsection