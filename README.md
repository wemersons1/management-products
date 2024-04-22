## Yii framework

## Como instalar

Softwares obrigatórios:

- PHP >= 7.1
- Composer >= 1.10
- Mysql >= 8.0

Dentro da pasta raiz do projeto você deve executar `composer install` seguido de `php yii serve`. Esses dois comandos irão
instalar todas as dependências e iniciar a aplicação php.

É necessário realizar uma cópia do arquivo .env.example e salva-lo como .env na pasta config na raiz do projeto, preencher com as credenciais correspondentes ao seu banco de dados alguma JWT Secret de sua preferência.

Você está pronto para rodar agora.

Resumindo:

- Instale o software necessário
- `composer install`
- `php yii serve`
- `php yii migrate`
- `php yii create-user -n="seu nome" -l="seu_username" -s="sua_senha"`
- `access in http://localhost:8080`

## Documentação API

https://www.postman.com/analizzeisp/workspace/management-products
