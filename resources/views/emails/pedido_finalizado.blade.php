<h2>Pedido Confirmado!</h2>

<p>Obrigado por sua compra!</p>

<p><strong>Pedido #{{ $pedido->id }}</strong></p>

<p><strong>Total:</strong> R$ {{ number_format($pedido->total, 2, ',', '.') }}</p>

<p><strong>Endereço de Entrega (CEP):</strong> {{ $pedido->cep }}</p>

<p>Itens do Pedido:</p>
<ul>
    @foreach($pedido->itens as $item)
        <li>{{ $item->produto->nome }} — {{ $item->variacao }} — {{ $item->quantidade }} un — R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}</li>
    @endforeach
</ul>

<p>Em breve entraremos em contato com mais informações.</p>
