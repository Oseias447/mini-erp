@extends('layouts.app')

@section('title', 'Cadastrar Produto')

@section('content')
    <h2>Cadastrar Produto com Variações</h2>

    <form action="{{ route('produtos.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nome do Produto</label>
            <input type="text" name="nome" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Preço</label>
            <input type="number" step="0.01" name="preco" class="form-control" required>
        </div>

        <hr>
        <h5>Variações e Estoque</h5>
        <div id="variacoes-container"></div>

        <button type="button" class="btn btn-secondary mb-3" onclick="addVariacao()">Adicionar Variação</button>

        <div class="mb-3">
            <button type="submit" class="btn btn-success">Salvar Produto</button>
            <a href="{{ route('produtos.index') }}" class="btn btn-danger">Cancelar</a>
        </div>
    </form>

    <script>
        let index = 0;
        function addVariacao() {
            let html = `
                <div class="row mb-2">
                    <div class="col">
                        <input type="text" name="variacoes[${index}][nome]" class="form-control" placeholder="Nome da Variação" required>
                    </div>
                    <div class="col">
                        <input type="number" name="variacoes[${index}][quantidade]" class="form-control" placeholder="Estoque" required>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-danger" onclick="this.parentElement.parentElement.remove()">X</button>
                    </div>
                </div>
            `;
            document.getElementById('variacoes-container').insertAdjacentHTML('beforeend', html);
            index++;
        }
    </script>
@endsection
