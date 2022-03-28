# Desafio Troupe
O desenvolvimento da API foi feito utilizando Lumen, que é um microframework PHP que tem como objetivo a criação de microsserviços e APIs. Como banco de dados foi escolhido o MySQL por maior afinidade e por ser o padrão do framework.

## Endpoints
Documentação simples dos endpoints da API. Para cada endpoint temos, em sequência, o método, o URL, parâmetros e a descrição de seu retorno.

#### 1. GET `/users``
Sem parâmetros 

&nbsp;
Retorna status ``200`` todos os usuários em ordem alfabética JSON

#### 2. GET ``/users/{cpf}``
| Nome         | Obrigatório |     Tipo      |
|--------------|-------------|:-------------:|
| cpf          | obrigatorio | string na url |

&nbsp;
Retorna status ``200`` e o usuário em formato JSON

#### 3. POST ``/users``
- Parâmetros

| Nome         | Obrigatório |                  Tipo                   |
|--------------|-------------|:---------------------------------------:|
| cpf          | obrigatorio |                 string                  |
| name         | obrigatorio |                 string                  |
| last_name    | obrigatorio |                 string                  |
| email        | obrigatorio |                 string                  |
| phone        | obrigatorio | string somente com caracteres numericos |
| cep          | obrigatorio |                 char(8)                 |
| public_place | opcional    |                 string                  |
| district     | opcional    |                 string                  |
| city         | opcional    |                 string                  |
| uf           | opcional    |                 char(2)                 |

&nbsp;
Retorna status ``201`` em caso de sucesso e o estado do usuário em formato JSON

#### 4. PUT `/users/{cpf}``
- Parâmetros

| Nome         | Obrigatório |                  Tipo                   |
|--------------|-------------|:---------------------------------------:|
| cpf          | obrigatorio |              string na url              |
| name         | obrigatorio |                 string                  |
| last_name    | obrigatorio |                 string                  |
| email        | obrigatorio |                 string                  |
| phone        | obrigatorio | string somente com caracteres numericos |
| cep          | obrigatorio |                 char(8)                 |
| public_place | opcional    |                 string                  |
| district     | opcional    |                 string                  |
| city         | opcional    |                 string                  |
| uf           | opcional    |                 char(2)                 |

- Retorna status ``200`` e o estado final do usuário em formato JSON

#### 5. DELETE ``/users/{cpf}``
- Parâmetros

| Nome         | Obrigatório |                  Tipo                   |
|--------------|-------------|:---------------------------------------:|
| cpf          | obrigatorio |              string na url              |

&nbsp;
Retorna ``204`` em caso de sucesso
