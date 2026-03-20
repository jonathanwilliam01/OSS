# 📋 Sistema de Ordem de Serviço Multiempresa (SaaS)

## 📌 Objetivo
Desenvolver um sistema web de **ordens de serviço (OS)** no modelo **multiempresa**, onde cada empresa possui seu próprio ambiente, usuários e demandas, com controle completo de fluxo via **Kanban**, histórico de alterações, comentários e notificações por e-mail.

---

## 🧱 Tecnologias

- Backend: PHP 
- Banco de Dados: PostgreSQL
- Frontend: HTML, CSS, JavaScript, Bootstrap 5
- Ambiente: Docker + Docker Compose
- Servidor: Apache/Nginx
- Email: SMTP (ex: Gmail, SendGrid, etc.)

---

## 🏢 Conceito Multiempresa

- Cada empresa possui:
  - Seu próprio cadastro
  - Seus usuários
  - Suas ordens de serviço
- Os dados são isolados por `id_empresa`

---

## 🔐 Autenticação e Controle de Acesso

### Tipos de Usuário

- **Admin da Plataforma**
  - Gerencia todas as empresas

- **Admin da Empresa**
  - Gerencia usuários da empresa
  - Gerencia todas as OS da empresa

- **Usuário da Empresa**
  - Cria e movimenta OS
  - Comenta nas OS

---

## ⚙️ Funcionalidades

### 1. 🏢 Cadastro de Empresas
- Nome da empresa
- CNPJ
- Email
- Telefone
- Criação automática do usuário admin da empresa

---

### 2. 👥 Gestão de Usuários (por empresa)
- Cadastro de usuários vinculados à empresa
- Campos:
  - Nome
  - Email
  - Senha
  - Perfil (admin / usuário)
- Login por empresa (multi-tenant)

---

### 3. 🧾 Ordem de Serviço (OS)

- Criação de OS:
  - Número da demanda (sequencial por empresa)
  - Título
  - Descrição
  - Cliente (opcional)
  - Prioridade (baixa, média, alta)
  - Responsável
  - Status
  - Data de criação

- Edição de OS
- Exclusão (controlada)

---

### 4. 🔢 Numeração de Demanda

- Cada empresa possui sua sequência própria:
EMPRESA A → OS-1, OS-2, OS-3
EMPRESA B → OS-1, OS-2


- Baseado em:
  - `id_empresa`
  - Sequencial incremental

---

### 5. 📌 Visualização das OS

#### 🗂️ Kanban
- Colunas:
  - Aberto
  - Em andamento
  - Aguardando
  - Finalizado

- Drag and drop entre colunas
- Atualiza status automaticamente

---

#### 📋 Lista
- Visualização em tabela:
  - Número da OS
  - Título
  - Status
  - Responsável
  - Data

- Filtros:
  - Status
  - Responsável
  - Prioridade

---

### 6. 💬 Comentários

- Adição de comentários em cada OS
- Registro de:
  - Usuário
  - Data/hora
  - Conteúdo

---

### 7. 🕓 Histórico de Alterações

- Registro automático de:
  - Mudança de status
  - Alteração de responsável
  - Edição de dados

- Campos:
  - OS
  - Usuário
  - Ação realizada
  - Data/hora

---

### 8. 🔔 Notificações por Email

- Disparos automáticos:
  - Nova OS criada
  - Mudança de status
  - Novo comentário

- Enviado para:
  - Responsável
  - Criador da OS

---

### 9. 🔍 Busca e Filtros

- Busca por:
  - Número da OS
  - Título
- Filtros:
  - Status
  - Prioridade
  - Responsável

---

## 🗄️ Estrutura do Banco de Dados (Sugestão)

### empresas
- id (PK)
- nome
- cnpj
- email
- telefone
- created_at

---

### usuarios
- id (PK)
- empresa_id (FK)
- nome
- email
- senha
- perfil
- created_at

---

### ordens_servico
- id (PK)
- empresa_id (FK)
- numero
- titulo
- descricao
- prioridade
- status
- responsavel_id (FK)
- criado_por (FK)
- created_at
- updated_at

---

### comentarios
- id (PK)
- os_id (FK)
- usuario_id (FK)
- comentario
- created_at

---

### historico_os
- id (PK)
- os_id (FK)
- usuario_id (FK)
- acao
- valor_anterior
- valor_novo
- created_at

---

### sequencia_empresa
- id (PK)
- empresa_id (FK)
- ultimo_numero

---

## 🔐 Requisitos Funcionais

- Cadastro de empresas
- Cadastro de usuários por empresa
- Login com isolamento por empresa
- CRUD de ordens de serviço
- Numeração sequencial por empresa
- Visualização Kanban e Lista
- Comentários em OS
- Histórico de alterações
- Notificações por email

---

## ⚠️ Requisitos Não Funcionais

- Sistema responsivo
- Segurança:
  - Hash de senha
  - Proteção contra SQL Injection
- Isolamento de dados por empresa
- Performance para múltiplas empresas
- Envio de emails assíncrono (recomendado)

🚀 Possíveis Melhorias Futuras
    Notificação via WhatsApp
    Upload de arquivos/anexos
    SLA e prazos automáticos
    Dashboard com métricas
    API REST
    Integração com apps mobile

💡 MVP (Versão Inicial)
    Cadastro de empresa
    Cadastro de usuários
    CRUD de OS
    Kanban simples
    Comentários
    Numeração por empresa
    📈 Modelo de Negócio
    Plano mensal por empresa
    Limite de usuários por plano
    Funcionalidades premium (email, relatórios, etc.)

🧠 Observações
    Estrutura ideal para SaaS
    Pode escalar facilmente
    Foco em simplicidade + produtividade