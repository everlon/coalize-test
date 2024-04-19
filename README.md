# Passos iniciais para instalar e testar

1. git clone https://github.com/everlon/coalize-test.git
2. php composer.phar update
3. docker-composer up -d
4. docker exec -i mysql-container mysql -uroot -p < script_init.sql
5. php yii migrate
6. php yii create-user "Everlon Passos" "everlon@protonmail.com" "everlon.passos" "1234567890"

---

## Rotas para uso da API

1. Efetuar o login com JSON em http://localhost:8888/user/login

**ATENÇÃO:** _É necessário trocar a `db.php` para `localhost:3636` para usar fora do container._

Exemplo de JSON:
```
    {
        "username" : "everlon.passos",
        "password" : "1234567890"
    }
```

2. Voltar para `host=mysql:3306` no arquivo `db.php`.

3. `POST http://localhost:8888/clientes/novo` Cadastra novo Cliente por meios de form-data.

Exemplo de JSON:
```
    {
        "nome": "Margarida",
        "cpf": 74752966281,
        "email": "margarida@example.com",
        "logradouro": "Avenida do Sol",
        "num": 250,
        "cep": 12398000,
        "cidade": "Macapá",
        "uf": "AP",
        "complemento": "-",
        "foto": null,
        "sexo": "F"
    }
```
**_Criei esta rota com `clientes/novo` para que possa enviar arquivo de foto, já que não consegui sobreescrever o actionsCreate nativo do framework_**

4. `GET http://localhost:8888/clientes` listará os Clientes cadastrados.

    1. `GET /clientes/1` - Irá pegar somente o Cliente de ID 1.
    2. **Não é possível DELETAR ou ATUALIZAR os dados neste teste.**
    3. `GET http://localhost:8888/clientes?page=2` - Paginação esta em 12 registros por página.

5. `POST http://localhost:8888/produtos/cadastro` Cadastra novo Produto por meio de form-data.

Exemplo de JSON:
```
{
    "nome": "Curso de MS Excel",
    "preco": "12",
    "cliente_id": "1",
    "foto": "882272c89a0f6828f0d4b62.jpg",
}
```

**_Criei esta rota com `produtos/cadastro` para que possa enviar arquivo de foto, já que não consegui sobreescrever o actionsCreate nativo do framework_**

6. `GET http://localhost:8888/produtos` listará os Produtos cadastrados.

    1. `GET /produtos/1` - Irá pegar somente o Produto de ID 1.
    2. **Não é possível DELETAR ou ATUALIZAR os dados neste teste.**
    3. `GET http://localhost:8888/produtos?page=2` - Paginação esta em 12 registros por página.
    4. `http://localhost:8888/produtos/cliente/2` - Irá listar somente os Produtos do Cliente de ID 2.

---
## Agradeço a atenção.