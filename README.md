# Mercafácil (MVC PHP + POO)

## Estrutura
- public/: arquivos públicos (index, login, register, assets)
- app/: Models, Repositories, Controllers, Database
- config/: configuração do banco

## Como rodar
1. Crie o banco com `database.sql`.
2. Ajuste `config/config.php` se necessário.
3. Coloque a pasta no `htdocs` do XAMPP (ex: C:\xampp\htdocs\mercafacil).
4. Acesse: http://localhost/mercafacil/public/

## Notas
- Senhas armazenadas com password_hash()
- Uso mínimo de sessão e sanitização de entrada