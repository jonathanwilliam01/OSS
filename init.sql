-- Script de Inicialização do Banco de Dados OSS
-- Sistema de Ordem de Serviço Multiempresa

-- Criar extensão para UUID (opcional)
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

-- Tabela de Empresas
CREATE TABLE IF NOT EXISTS empresas (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    cnpj VARCHAR(18) UNIQUE,
    email VARCHAR(255),
    telefone VARCHAR(20),
    ativo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Usuários
CREATE TABLE IF NOT EXISTS usuarios (
    id SERIAL PRIMARY KEY,
    empresa_id INTEGER NOT NULL REFERENCES empresas(id) ON DELETE CASCADE,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    perfil VARCHAR(20) NOT NULL CHECK (perfil IN ('admin', 'usuario', 'platform_admin')),
    ativo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(empresa_id, email)
);

-- Tabela de Sequência por Empresa
CREATE TABLE IF NOT EXISTS sequencia_empresa (
    id SERIAL PRIMARY KEY,
    empresa_id INTEGER NOT NULL UNIQUE REFERENCES empresas(id) ON DELETE CASCADE,
    ultimo_numero INTEGER DEFAULT 0,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Ordens de Serviço
CREATE TABLE IF NOT EXISTS ordens_servico (
    id SERIAL PRIMARY KEY,
    empresa_id INTEGER NOT NULL REFERENCES empresas(id) ON DELETE CASCADE,
    numero INTEGER NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT,
    cliente VARCHAR(255),
    prioridade VARCHAR(20) NOT NULL CHECK (prioridade IN ('baixa', 'media', 'alta')),
    status VARCHAR(20) NOT NULL CHECK (status IN ('aberto', 'em_andamento', 'aguardando', 'finalizado')),
    responsavel_id INTEGER REFERENCES usuarios(id) ON DELETE SET NULL,
    criado_por INTEGER NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(empresa_id, numero)
);

-- Tabela de Comentários
CREATE TABLE IF NOT EXISTS comentarios (
    id SERIAL PRIMARY KEY,
    os_id INTEGER NOT NULL REFERENCES ordens_servico(id) ON DELETE CASCADE,
    usuario_id INTEGER NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
    comentario TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Histórico de Alterações
CREATE TABLE IF NOT EXISTS historico_os (
    id SERIAL PRIMARY KEY,
    os_id INTEGER NOT NULL REFERENCES ordens_servico(id) ON DELETE CASCADE,
    usuario_id INTEGER NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE,
    acao VARCHAR(255) NOT NULL,
    campo_alterado VARCHAR(100),
    valor_anterior TEXT,
    valor_novo TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Índices para melhor performance
CREATE INDEX IF NOT EXISTS idx_usuarios_empresa ON usuarios(empresa_id);
CREATE INDEX IF NOT EXISTS idx_os_empresa ON ordens_servico(empresa_id);
CREATE INDEX IF NOT EXISTS idx_os_status ON ordens_servico(status);
CREATE INDEX IF NOT EXISTS idx_os_responsavel ON ordens_servico(responsavel_id);
CREATE INDEX IF NOT EXISTS idx_comentarios_os ON comentarios(os_id);
CREATE INDEX IF NOT EXISTS idx_historico_os ON historico_os(os_id);

-- Função para atualizar updated_at automaticamente
CREATE OR REPLACE FUNCTION update_updated_at_column()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ language 'plpgsql';

-- Triggers para updated_at
CREATE TRIGGER update_empresas_updated_at BEFORE UPDATE ON empresas
    FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

CREATE TRIGGER update_usuarios_updated_at BEFORE UPDATE ON usuarios
    FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

CREATE TRIGGER update_ordens_servico_updated_at BEFORE UPDATE ON ordens_servico
    FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();

-- Inserir empresa de teste (opcional)
INSERT INTO empresas (nome, cnpj, email, telefone) 
VALUES ('Empresa Demo', '00.000.000/0000-00', 'contato@demo.com', '(11) 98765-4321')
ON CONFLICT DO NOTHING;

-- Inserir usuário admin da empresa demo (senha: admin123)
-- Hash gerado com password_hash('admin123', PASSWORD_DEFAULT)
INSERT INTO usuarios (empresa_id, nome, email, senha, perfil)
VALUES (1, 'Administrador', 'admin@demo.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin')
ON CONFLICT DO NOTHING;

-- Inicializar sequência para empresa demo
INSERT INTO sequencia_empresa (empresa_id, ultimo_numero)
VALUES (1, 0)
ON CONFLICT DO NOTHING;

-- Mensagem de conclusão
DO $$
BEGIN
    RAISE NOTICE '✅ Banco de dados OSS inicializado com sucesso!';
    RAISE NOTICE '📋 Tabelas criadas: empresas, usuarios, ordens_servico, comentarios, historico_os, sequencia_empresa';
    RAISE NOTICE '👤 Usuário teste: admin@demo.com / senha: admin123';
END $$;
