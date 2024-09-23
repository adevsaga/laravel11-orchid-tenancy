# Template Laravel 11 com Orchid e Tenancy

## Objetivo

Ter um template base para projetos que possam necessitar:

- Criação de interfaces de maneira dinâmica usando a biblioteca [Orchid](https://orchid.software/)
- Separação de base de dados por inquilino usando a biblioteca [Tenancy](https://tenancyforlaravel.com/)
- PostgreSql como base de dados
- Testes automatizados com a biblioteca [Dusk](https://laravel.com/docs/11.x/dusk)
- Validação de testes a cada *Pull Request* aberta no *Github* usando *Github Actions*

## Utilidades

### Testes

#### PHPUnit

- Para resultados simples de validação, utilize o comando

    ```shell
    php artisan test
    ```

- Para resultados com a cobertura de testes, mas somente no console, utilize o comando:

  ```shell
  php artisan test --coverage
  ```

- Para gerar um relatório com a cobertura de testes, utilize o comando
  
  ```shell
  php artisan test --coverage-html coverage-report
  ```

#### Dusk

- Garanta que a variável de ambiente `APP_URL` tenha o valor que você usa para acessar localmente, por exemplo: `http://127.0.0.1:8000`
- Rode em um processo o projeto com o comando

    ```shell
    php artisan serve
    ```

- Rode em outro processo o comando

  ```shell
  ./vendor/laravel/dusk/bin/chromedriver-linux --port=9515
  ```

- Rode em outro processo o comando

    ```shell
    php artisan dusk
    ```

  - Variação usando cobertura de testes

    ```shell
    php artisan dusk --coverage-html coverage-report
    ```

## Utilidades WSL
