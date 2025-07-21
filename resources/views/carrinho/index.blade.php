@extends('layouts.app')

@section('title', 'Carrinho de Compras')

@section('content')
    <h2>Carrinho de Compras</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @php
        $subtotal = 0;
        $carrinho = session('carrinho', []);
    @endphp

    @if(count($carrinho) > 0)
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Produto</th>
                    <th>Variação</th>
                    <th>Quantidade</th>
                    <th>Preço Unitário</th>
                    <th>Total</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach($carrinho as $key => $item)
                    @php
                        $totalItem = $item['preco'] * $item['quantidade'];
                        $subtotal += $totalItem;
                    @endphp
                    <tr>
                        <td>{{ $item['produto'] }}</td>
                        <td>{{ $item['variacao'] }}</td>
                        <td>{{ $item['quantidade'] }}</td>
                        <td>R$ {{ number_format($item['preco'], 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($totalItem, 2, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('carrinho.remover', $key) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Remover</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @php
            if ($subtotal >= 52 && $subtotal <= 166.59) {
                $frete = 15.00;
            } elseif ($subtotal > 200) {
                $frete = 0.00;
            } else {
                $frete = 20.00;
            }
            $total = $subtotal + $frete;
        @endphp

        <div class="mb-3">
            <strong>Subtotal:</strong> R$ {{ number_format($subtotal, 2, ',', '.') }} <br>
            <strong>Frete:</strong> R$ {{ number_format($frete, 2, ',', '.') }} <br>
            <strong>Total:</strong> R$ {{ number_format($total, 2, ',', '.') }}
        </div>

        <hr>

        <h4>Calcular Endereço via CEP</h4>
        <div class="mb-3">
            <input type="text" id="cep" class="form-control" placeholder="Digite seu CEP">
        </div>
        <div class="mb-3">
            <input type="text" id="endereco" class="form-control" placeholder="Endereço completo" readonly>
        </div>

        <a href="{{ route('pedido.checkout') }}" class="btn btn-primary">Finalizar Pedido</a>
        <a href="{{ route('produtos.index') }}" class="btn btn-secondary">Continuar comprando</a>

    @else
        <p class="alert alert-warning">Seu carrinho está vazio.</p>
    @endif

    <script>
        document.getElementById('cep').addEventListener('blur', function() {
            let cep = this.value.replace(/\D/g, '');
            if (cep.length === 8) {
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('endereco').value =
                            `${data.logradouro}, ${data.bairro}, ${data.localidade} - ${data.uf}`;
                    });
            }
        });
    </script>
@endsection
