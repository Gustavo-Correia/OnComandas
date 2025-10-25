# Contributing — OnComandas

Obrigado por querer contribuir. Este documento descreve o fluxo mínimo para Issues, Branches, Tags, Pull Requests e os comandos para executar migrations no Laravel.

## 1. Reportar Issues
- Pesquise issues existentes antes de abrir outra.
- Forneça:
  - Título curto e descritivo.
  - Passos para reproduzir.
  - Resultado esperado vs. resultado atual.
  - Logs / stack traces / versão do PHP / ambiente (Docker / local).

## 2. Branches e convenções
-criação de branch
  git checkout main
  git fetch
  git pull
  git checkout -b feature/teste-fechamento-issue
  git push -u origin feature/teste-fechamento-issue
- Branches principais:
  - `main` — código em produção.
  - `develop` — integração de features (se usado).
- Nomes de branch:
  - feature/NN-descricao (ex.: `feature/123-login-social`)
  - fix/NN-descricao
  - hotfix/descrição
  - release/X.Y.Z
- Cada branch deve ter um único objetivo claro.

## 3. Commits
- Mensagens curtas e descritivas.
- Use idioma português ou inglês conforme contexto do PR.
- Referencie issue: `Fixes #NN` ou `Refs #NN`.

## 4. Pull Requests (PR)
- Faça um fork do repositório (se não tiver permissão).
- Crie branch a partir de `develop` (ou `main` se for hotfix).
- Faça commits pequenos e atômicos.
- Inclua descrição clara do que foi alterado, screenshots se aplicável e como testar.
- Vincule issues relacionadas no texto do PR.
- Execute migrations/testes antes de submeter.
- Após revisão, PR pode ser mergeado por mantenedor; siga instruções do repositório (Squash/Merge/Rebase).

## 5. Tags / Releases
- Use versionamento semântico: `vMAJOR.MINOR.PATCH` (ex.: `v1.2.0`).
- Para criar uma tag local:
  - git tag -a v1.2.0 -m "Release v1.2.0"
  - git push origin v1.2.0
- Crie release no GitHub a partir da tag com changelog resumido.

## 6. Migrations (Laravel)
Observação: o Compose já possui um serviço `db` (Postgres). Recomenda-se em `.env`:
- DB_CONNECTION=pgsql
- DB_HOST=db
- DB_PORT=5432
- DB_DATABASE, DB_USERNAME, DB_PASSWORD conforme `.env`

Com Docker Compose (recomendado):
- Subir containers:
  - docker-compose up -d --build
- Instalar dependências/composer:
  - docker-compose exec app composer install
- Preparar .env (se necessário):
  - docker-compose exec app cp .env.example .env
  - docker-compose exec app php artisan key:generate
- Executar migrations:
  - docker-compose exec app php artisan migrate
- Rodar migrations com seed:
  - docker-compose exec app php artisan migrate --seed
- Refazer todas migrations:
  - docker-compose exec app php artisan migrate:fresh --seed
- Rollback:
  - docker-compose exec app php artisan migrate:rollback
- Criar nova migration:
  - docker-compose exec app php artisan make:migration create_\<table\>_table --create=\<table\>
- Dropar o banco e criar novas migrations copulando elas
  -docker compose exec app php artisan migrate:fresh --seed

Sem Docker (local):
- composer install
- cp .env.example .env
- php artisan key:generate
- php artisan migrate
- php artisan migrate --seed

## 7. Boas práticas
- Execute `php artisan migrate` em ambientes de desenvolvimento; evite rodar comandos destrutivos em produção sem backup.
- Teste manualmente e, se disponível, execute suíte de testes automatizados antes do PR.
- Mantenha PRs pequenos e focados.

Obrigado por contribuir!