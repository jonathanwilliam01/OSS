# 🔧 Sistema de Ordem de Serviço Multiempresa (SaaS)

Sistema web de ordens de serviço com arquitetura multiempresa usando PHP, PostgreSQL e Docker.

## 🚀 Como Executar

### Pré-requisitos
- Docker
- Docker Compose

### Passo a Passo

1. **Clone ou acesse o diretório do projeto**
   ```bash
   cd "/home/embras/Fontes /OSS"
   ```

2. **Verifique o arquivo .env**
   ```env
   DB=OSS
   HOST=sysdba
   PORT=5432
   USER=localhost
   PASS=oss
   ```

3. **Construa e inicie os containers**
   ```bash
   docker-compose up -d --build
   ```

4. **Aguarde os serviços iniciarem**
   ```bash
   docker-compose logs -f
   ```

5. **Acesse a aplicação**
   - Navegador: http://localhost:8080
   - Banco de Dados: localhost:5432

### Comandos Úteis

```bash
# Iniciar os containers
docker-compose up -d

# Parar os containers
docker-compose down

# Ver logs
docker-compose logs -f web
docker-compose logs -f postgres

# Reconstruir após mudanças
docker-compose up -d --build

# Acessar o container PHP
docker exec -it oss_web bash

# Acessar o PostgreSQL
docker exec -it sysdba psql -U localhost -d OSS

# Remover tudo (incluindo volumes)
docker-compose down -v
```

## 📁 Estrutura do Projeto

```
.
├── Dockerfile              # Imagem PHP com Apache
├── docker-compose.yml      # Orquestração dos serviços
├── init.sql               # Script de inicialização do banco
├── .env                   # Variáveis de ambiente
├── .dockerignore          # Arquivos ignorados no build
├── OSS.MD                 # Documentação do projeto
└── src/                   # Código-fonte da aplicação
    ├── index.php          # Página inicial (teste)
    └── conexao.php        # Conexão com PostgreSQL
```

## 🗄️ Banco de Dados

O PostgreSQL está configurado com:
- **Host**: sysdba (container)
- **Porta**: 5432
- **Banco**: OSS
- **Usuário**: localhost
- **Senha**: oss

### Inicialização Automática

O banco de dados **OSS** e todas as tabelas são criados automaticamente na primeira execução através do script [init.sql](init.sql).

**Tabelas criadas:**
- `empresas` - Cadastro de empresas
- `usuarios` - Usuários por empresa
- `ordens_servico` - Ordens de serviço
- `comentarios` - Comentários nas OS
- `historico_os` - Histórico de alterações
- `sequencia_empresa` - Controle de numeração sequencial

**Dados de teste:**
- Empresa: Empresa Demo
- Usuário: admin@demo.com
- Senha: admin123

### Conectar ao banco externamente

```bash
psql -h localhost -p 5432 -U localhost -d OSS
# Senha: oss
```

## 🔧 Desenvolvimento

Os arquivos PHP ficam em `src/` e são sincronizados automaticamente com o container através de volumes.

Para fazer alterações:
1. Edite os arquivos em `src/`
2. Recarregue a página no navegador
3. Não é necessário reiniciar o container

## 📦 Tecnologias

- **Backend**: PHP 8.2
- **Servidor Web**: Apache
- **Banco de Dados**: PostgreSQL 15
- **Containerização**: Docker & Docker Compose
- **Frontend**: Bootstrap 5

## 📋 Próximos Passos

1. ✅ Configurar ambiente Docker
2. ✅ Criar conexão com PostgreSQL
3. ⬜ Criar estrutura do banco de dados
4. ⬜ Implementar autenticação multiempresa
5. ⬜ Desenvolver CRUD de empresas
6. ⬜ Desenvolver CRUD de usuários
7. ⬜ Implementar sistema de OS
8. ⬜ Criar visualização Kanban
9. ⬜ Adicionar sistema de comentários
10. ⬜ Implementar notificações por email

## 📝 Licença

Sistema proprietário - Todos os direitos reservados
