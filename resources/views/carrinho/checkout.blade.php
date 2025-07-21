@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <h2>Resumo do Pedido</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(count($carrinho))
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Produto</th>
                    <th>Variação</th>
                    <th>Preço Unitário</th>
                    <th>Quantidade</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($carrinho as $item)
                    <tr>
                        <td>{{ $item['produto'] }}</td>
                        <td>{{ $item['variacao'] }}</td>
                        <td>R$ {{ number_format($item['preco'], 2, ',', '.') }}</td>
                        <td>{{ $item['quantidade'] }}</td>
                        <td>R$ {{ number_format($item['preco'] * $item['quantidade'], 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mb-3">
            <strong>Subtotal:</strong> R$ {{ number_format($subtotal, 2, ',', '.') }}<br>
            <strong>Frete:</strong> R$ {{ number_format($frete, 2, ',', '.') }}<br>
            <strong>Desconto:</strong> R$ {{ number_format($desconto, 2, ',', '.') }}<br>
            <strong>Total:</strong> <span class="text-success fw-bold">R$ {{ number_format($total, 2, ',', '.') }}</span>
        </div>

        <form method="POST" action="{{ route('carrinho.aplicarCupom') }}" class="mb-3">
            @csrf
            <div class="input-group" style="max-width: 300px;">
                <input type="text" name="codigo_cupom" class="form-control" placeholder="Digite o código do cupom" required>
                <button class="btn btn-primary" type="submit">Aplicar</button>
            </div>
        </form>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('pedido.finalizar') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="cep">CEP para entrega:</label>
                <input type="text" name="cep" id="cep" class="form-control" required placeholder="00000-000">
            </div>

            <div class="mb-3">
                <label>E-mail para envio da confirmação</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Finalizar Pedido</button>
            <a href="{{ route('carrinho.index') }}" class="btn btn-secondary">Voltar ao Carrinho</a>
        </form>

    @else
        <div class="alert alert-warning">Seu carrinho está vazio.</div>
        <a href="{{ route('produtos.index') }}" class="btn btn-primary">Ir para Produtos</a>
    @endif
@endsection


<script>
    document.getElementById('cep').addEventListener('blur', function () {
        let cep = this.value.replace(/\D/g, '');

        if (cep.length !== 8) {
            alert('CEP inválido.');
            return;
        }

        fetch('https://viacep.com.br/ws/' + cep + '/json/')
            .then(response => response.json())
            .then(data => {
                if (data.erro) {
                    alert('CEP não encontrado.');
                } else {
                    console.log('Endereço encontrado:', data);
                    // Exibir ou preencher campos de endereço se quiser
                }
            })
            .catch(() => alert('Erro ao consultar o CEP.'));
    });
</script>

