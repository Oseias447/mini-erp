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


