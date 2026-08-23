# Gestão Acadêmica

Sistema de Cadastro, Edição, Listagem e Deleção de Alunos em PHP orientado a objetos, com Eloquent ORM e arquitetura Serviço + DAO. A área adicional de negócio é o catálogo de Cursos e Turnos.

## Requisitos

- PHP 8.1+
- Composer
- MySQL/MariaDB do XAMPP

## Instalação

1. Execute `composer install`.
2. Copie `.env.example` para `.env` e ajuste as credenciais do banco.
3. No phpMyAdmin, importe `database/schema.sql`.
4. Execute `composer serve` ou `php -S localhost:8000 -t public`.
5. Acesse `http://localhost:8000`.

## Organização

- `src/Models`: entidades Eloquent e relacionamento.
- `src/Dao`: persistência e consultas ORM.
- `src/Services`: regras e validações de negócio.
- `public`: front controller e CSS.
- `database`: script de criação e carga inicial.

Para a apresentação, destaque o fluxo `public/index.php -> Service -> Dao -> Model Eloquent -> MySQL` e demonstre as operações de aluno e a restrição de exclusão de curso com alunos vinculados.
