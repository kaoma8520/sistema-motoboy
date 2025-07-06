# Sistema Motoboy - Tele-entregas em PHP

## Descrição
Sistema completo para gestão de entregas rápidas, com áreas para cliente, entregador e administrador. Desenvolvido em PHP puro, com autenticação, cálculo de frete, controle de pagamentos e painel administrativo.

## Estrutura de Pastas
- `config/` - Configuração do banco de dados
- `public/client/` - Área do cliente (cadastro, login, solicitar entrega)
- `public/deliverer/` - Área do entregador (cadastro, login, aceitar/concluir pedidos)
- `public/admin/` - Painel administrativo (login, cadastro, gestão de pedidos)
- `src/Controllers/` - Lógica dos fluxos principais
- `src/Helpers/` - Funções auxiliares (ex: cálculo de distância)
- `sql/` - Scripts SQL para criação do banco

## Instalação
1. Crie um banco MySQL chamado `sistema_motoboy`.
2. Execute o script `sql/create_tables.sql` para criar as tabelas.
3. Configure o acesso ao banco em `config/database.php`.
4. Suba o projeto em um servidor Apache/Nginx com PHP 7.4+.

## Fluxos Principais
- Cadastro/login de cliente, entregador e admin
- Solicitação de entrega com cálculo de distância e valor
- Pagamento via PIX ou cartão (mock)
- Entregador recebe pedidos, aceita e conclui
- Admin visualiza e gerencia pedidos

## Credenciais de Teste
- Crie usuários de cada perfil usando as telas de cadastro

## Observações
- Todas as queries usam PDO e prepared statements
- Inputs são validados e sanitizados
- Controle de sessão protege as rotas
- Exemplo de cálculo de distância disponível em `src/Helpers/DistanceHelper.php`

---
Desenvolvido por GitHub Copilot