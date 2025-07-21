# 🛒 Mini ERP Laravel — Controle de Produtos, Estoque, Pedidos e Cupons

## 📋 Requisitos

- PHP >= 8.1  
- Composer  
- MySQL  
- Node.js & NPM  
- Laravel 12.x  

---

## 🚀 Instalação

```bash
# Clone o projeto
git clone https://github.com/seu-usuario/mini-erp.git
cd mini-erp

# Instale as dependências PHP
composer install

# Instale as dependências JS e compile os assets
npm install && npm run build

# Copie o arquivo .env e configure seu banco de dados
cp .env.example .env

# Gere a chave da aplicação
php artisan key:generate

# Execute as migrations
php artisan migrate

# Rodar aplicação
composer run dev


Acesse no navegador:

🛒 Produtos: http://127.0.0.1:8000/produtos

🎟️ Cupons: http://127.0.0.1:8000/cupons


# Rotas disponíveis
- Produtos
http://127.0.0.1:8000/produtos
CRUD para gerenciamento de produtos, variações e estoque.

- Cupons
http://127.0.0.1:8000/cupons
Gerenciamento de cupons com validade e regras de valor mínimo.

- Carrinho / Checkout
http://127.0.0.1:8000/carrinho
Visualização do carrinho, finalização do pedido e aplicação de cupons.

- Webhook para atualização de status do pedido
http://127.0.0.1:8000/webhook/pedido-status

Método: POST

Corpo JSON esperado:

{
  "pedido_id": 1,
  "status": "cancelado"
}

# Funcionalidade:

Se o status for "cancelado", o pedido será removido do banco.

Para outros status válidos ("pendente", "pago", "enviado"), o status do pedido será atualizado.

Observação:
Essa rota está isenta da verificação CSRF. Para testes via Postman, use o método POST com cabeçalhos Content-Type: application/json e Accept: application/json.


📑 Funcionalidades principais

✅ Cadastro, edição e exclusão de Produtos com variações e estoque

✅ Gestão de Carrinho de Compras com regras de frete dinâmicas

✅ Finalização de Pedidos com atualização automática do estoque

✅ Envio automático de e-mail de confirmação ao finalizar pedido

✅ Aplicação de Cupons de Desconto com validade e regras de subtotal

✅ Consulta de endereço via API ViaCEP


🛠️ Observações importantes

Configure corretamente seu .env para banco de dados e SMTP de e-mail

O projeto usa Bootstrap 5 e Blade Templates

Testado em ambiente local com XAMPP + Laravel Serve