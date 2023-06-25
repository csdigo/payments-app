### Passo a passo
Clone Repositório
```sh
git clone https://github.com/csdigo/payments-app.git
```
Entre na pasta do laravel
```sh
cd /payments-app/source
```

Crie o Arquivo .env e configurar os dados do banco de dados
```sh
cp .env.example .env
```

Instalar as dependências do projeto
```sh
composer install
```

Aplicando o migration no banco de dados
```sh
php artisan migrate
```

Gerar a key do projeto Laravel
```sh
php artisan key:generate
```

Subir o servidor abrir o navegador com o site indicado
```sh
php artisan serve
```

Rodar os testes
```sh
php artisan test
```