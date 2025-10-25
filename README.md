# Mercafácil (MVC PHP + POO)
Trabalho projeto de softwere

Mercafácill

Alunos: 
Alexandre Magno Pianetti Junior: 12301817
Júlia da Silva Rocha Ribeiro: 12302562
Mateus Mendes Assunção: 12302228
Letícia Antunes: 12302627
Pedro Henrique: 12300985


[X] Permitir o cadastro de novos usuários.

[X] Implementar a funcionalidade de redefinição de senha.

[ ] Configurar o envio de notificações e lembretes.

[ ] Desenvolver a tela de histórico de atividades do usuário (compras, pesquisas, gastos, datas).

[X] Criar opções de personalização da interface (modo claro/escuro, organização, tamanho da fonte).

[X] Construir um sistema de busca eficiente com filtros (categoria, preço, avaliação).

[ ] Adicionar a função de escaneamento de produtos (QR code e código de barras).

[ ] Integrar o sistema com diferentes métodos de pagamento (Pix, cartão de crédito/débito).

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
