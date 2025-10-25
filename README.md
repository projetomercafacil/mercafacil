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


## Design Patterns Aplicados na Camada de Domínio
🔹 Singleton

Uso: Conexão única ao banco de dados (app/Database/Database.php).

Justificativa: Evita múltiplas instâncias de conexão PDO e reduz o consumo de recursos.
Centraliza a criação e o gerenciamento da conexão com o banco.

UML Simplificado:

+-------------------+
|     Database      |
+-------------------+
| - connection: PDO |
+-------------------+
| + connect(): PDO  |
+-------------------+
        ▲
        | (única instância compartilhada)

🔹 Repository

Uso: Implementado nos arquivos app/Repositories/*.php (ex: ProductRepository.php, UserRepository.php, CartRepository.php).

Justificativa: Encapsula a lógica de acesso e manipulação de dados, separando as regras de negócio da persistência.
Facilita manutenção, testes e substituição da fonte de dados (ex: MySQL → API).

UML Simplificado:

+---------------------+        +-------------------+
|  ProductRepository  |        |     Database      |
+---------------------+        +-------------------+
| + findAll()         |<>----->| + connect()       |
| + findById(id)      |        +-------------------+
| + save(product)     |
+---------------------+

🔹 Domain Model

Uso: Classes em app/Models/ (ex: Product, User, Cart, Supermarket).

Justificativa: Representam entidades do domínio com seus atributos e comportamentos próprios.
Aplicam o padrão Domain Model (dados + regras de negócio na mesma classe).

UML Simplificado:

+-------------------+
|     Product       |
+-------------------+
| - id              |
| - name            |
| - price           |
+-------------------+
| + getPrice()      |
| + applyDiscount() |
+-------------------+

🔹 MVC (Model–View–Controller)

Uso: Estrutura do sistema (app/Controllers/, app/Models/, app/views/).

Justificativa: Separa as responsabilidades da aplicação:

Controller: processa requisições e coordena ações.

Model: trata dados e lógica de negócio.

View: exibe a interface ao usuário.
Melhora a manutenibilidade e organização do código.

UML Simplificado:

+-------------+     +-------------+     +-------------+
|  Controller | --> |   Model     | --> |    View     |
| (ex: Product|     | (ex: Product|     | (HTML/PHP)  |
| Controller) |     | Model)      |     |             |
+-------------+     +-------------+     +-------------+
