
Projeto desenvolvido para o desafio da empresa [Kanastra](https://kanastra.com.br).  
O desafio consiste em criar uma aplicação de um sistema de cobrança    

O projeto foi desenvolvido em [Laravel](https://laravel.com/)  

#####Desenvolvido utilizando Ubuntu 22.04.1 LTS  
MySQL 10.6.11-MariaDB  
Apache/2.4.52 PHP 8.1.14  
Redis Server v=6.0.16  

Versão hospedada disponível em:  
https://kanastra.uaibits.com.br  

####Rotas hospedada (API) 

`POST`  - https://kanastra.uaibits.com.br/invoices  
`GET`   - https://kanastra.uaibits.com.br/invoices  
`GET`   - https://kanastra.uaibits.com.br/invoice/{id}  
`POST`   - https://kanastra.uaibits.com.br/invoice/upload  
`POST`   - https://kanastra.uaibits.com.br/payment  
`POST`   - https://kanastra.uaibits.com.br/payment/{debtId}

Para acessar a documentação da API, basta acessar o link abaixo:  
https://documenter.getpostman.com/view/8500239/2s8ZDYWMNo

####Rotas hospedada (Web)

`GET`  - https://kanastra.uaibits.com.br/pagamentos  
`GET`   - https://kanastra.uaibits.com.br/emails  
`GET`   - https://kanastra.uaibits.com.br/faturas

Para executar o projeto localmente, basta seguir os passos abaixo:

####Instalação

1. Clone o repositório
```bash
git clone https://github.com/EduardoMGP/KanastraDesafio.git
```

2. Entre na pasta do projeto
```bash
cd KanastraDesafio
```

3. Instale as dependências
```bash
composer install
```

3. Crie o arquivo .env
```bash
cp .env.example .env
```

4. Gere a chave da aplicação
```bash
php artisan key:generate
```

5. Configure o arquivo .env com as informações do seu banco de dados
6. Execute as migrations
```bash
php artisan migrate
```

7. Inicie o worker do redis  
   `Esse work executará toda a fila de emails pendentes`
```bash
php artisan queue:work
```

7. Crie um cronjob para executar o comando abaixo a cada minuto  
`Esse cronjob buscará todos os emails pendentes e os enviará para a fila de emails`
```bash
php artisan schedule:run
```

8. Inicie o servidor
```bash
php artisan serve
```

9. Acesse o projeto em http://127.0.0.1:8000
