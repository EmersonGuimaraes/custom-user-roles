# Custom User Roles

O **Custom User Roles** é um plugin para WordPress que permite gerenciar funções de usuário através da API REST. Com ele, você pode adicionar, remover, listar funções e criar novas funções de usuário, bem como listar as funções associadas a um usuário específico.

## Índice

- [Descrição](#descrição)
- [Instalação](#instalação)
- [Uso](#uso)
  - [Endpoints da API](#endpoints-da-api)
- [Permissões](#permissões)
- [Contribuições](#contribuições)
- [Licença](#licença)
- [Contato](#contato)

## Descrição

Este plugin fornece uma interface para manipulação de funções de usuários no WordPress usando a API REST. Ideal para administradores e desenvolvedores que precisam gerenciar funções de usuário de forma programática.

## Instalação

1. **Download e Upload**
   - Baixe o plugin do [repositório GitHub](https://github.com/EmersonGuimaraes/custom-user-roles).
   - Faça o upload da pasta do plugin para o diretório `/wp-content/plugins/` no seu servidor WordPress.

2. **Ativação**
   - No painel de administração do WordPress, vá para a seção `Plugins`.
   - Encontre `Custom User Roles` e clique em `Ativar`.

## Uso

### Endpoints da API

#### 1. Adicionar Função a um Usuário

- **Método:** `POST`
- **Endpoint:** `/wp-json/custom-user-roles/v1/add-role`
- **Parâmetros:**
  - `user_id` (int) - ID do usuário ao qual a função será adicionada.
  - `role` (string) - Nome da função a ser adicionada.
- **Resposta Exemplo:**
  ```json
  {
    "message": "Role added successfully",
    "user_id": 1,
    "role": "editor"
  }

Descrição: Adiciona uma função ao usuário especificado.
2. Remover Função de um Usuário
Método: POST
Endpoint: /wp-json/custom-user-roles/v1/remove-role
Parâmetros:
user_id (int) - ID do usuário do qual a função será removida.
role (string) - Nome da função a ser removida.
Resposta Exemplo:

{
  "message": "Role removed successfully",
  "user_id": 1,
  "role": "editor"
}


Descrição: Remove uma função do usuário especificado.
3. Listar Todas as Funções
Método: GET
Endpoint: /wp-json/custom-user-roles/v1/list-roles
Resposta Exemplo:

{
  "subscriber": {
    "name": "Subscriber",
    "capabilities": { ... }
  },
  "editor": {
    "name": "Editor",
    "capabilities": { ... }
  },
  ...
}

Descrição: Lista todas as funções de usuário disponíveis no WordPress.
4. Criar Nova Função
Método: POST
Endpoint: /wp-json/custom-user-roles/v1/create-role
Parâmetros:
role (string) - Nome da nova função.
display_name (string) - Nome a ser exibido para a nova função.

Resposta Exemplo:

{
  "message": "Role created successfully",
  "role": "custom_role",
  "display_name": "Custom Role"
}

Descrição: Cria uma nova função de usuário com as permissões baseadas na função de "subscriber".
5. Listar Funções de um Usuário Específico
Método: GET
Endpoint: /wp-json/custom-user-roles/v1/user-roles
Parâmetros:
user_id (int) - ID do usuário cujas funções serão listadas.

Resposta Exemplo:

{
  "user_id": 1,
  "roles": [
    "subscriber",
    "editor"
  ]
}

Descrição: Lista todas as funções associadas ao usuário especificado.

# Permissões
Todos os endpoints da API REST requerem que o usuário autenticado tenha a capacidade de edit_users. Certifique-se de que o usuário tenha as permissões adequadas para acessar e modificar funções de usuário.


# Contribuições
Contribuições são bem-vindas! Para contribuir com o desenvolvimento deste plugin:

Faça um fork do repositório GitHub.
Crie uma branch para suas alterações (git checkout -b minha-alteracao).
Faça commit das suas alterações (git commit -am 'Adiciona nova funcionalidade').
Faça um push para a branch (git push origin minha-alteracao).
Envie um pull request com uma descrição detalhada das alterações.

#Licença
Este plugin é licenciado sob a Licença Pública Geral GNU (GPL2). Veja o arquivo LICENSE para mais detalhes.

Contato
Para questões ou suporte, entre em contato com o autor:

Autor: Emerson Guimarães
URI do Autor: https://github.com/EmersonGuimaraes
URI do Plugin: https://github.com/EmersonGuimaraes/custom-user-roles


