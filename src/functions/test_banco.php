<?php
/**
 * Página de Teste - Sistema OSS
 */
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema OSS - Teste de Conexão</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3>🔧 Sistema de Ordem de Serviço Multiempresa</h3>
                    </div>
                    <div class="card-body">
                        <h5>Teste de Conexão com Banco de Dados</h5>
                        <hr>
                        <?php
                        try {
                            // Incluir arquivo de conexão
                            $pdo = require_once 'conexao.php';
                            
                            // Testar conexão
                            $stmt = $pdo->query("SELECT version() as version, current_database() as database");
                            $info = $stmt->fetch();
                            
                            echo '<div class="alert alert-success">';
                            echo '<h4>✅ Conexão Estabelecida com Sucesso!</h4>';
                            echo '<p><strong>Banco de Dados:</strong> ' . htmlspecialchars($info['database']) . '</p>';
                            echo '<p><strong>Versão PostgreSQL:</strong> ' . htmlspecialchars($info['version']) . '</p>';
                            echo '</div>';
                            
                            // Informações do ambiente
                            echo '<div class="alert alert-info">';
                            echo '<h5>📋 Configurações</h5>';
                            echo '<ul>';
                            echo '<li><strong>Host:</strong> ' . getenv('DB_HOST') . '</li>';
                            echo '<li><strong>Porta:</strong> ' . getenv('DB_PORT') . '</li>';
                            echo '<li><strong>Banco:</strong> ' . getenv('DB_NAME') . '</li>';
                            echo '<li><strong>Usuário:</strong> ' . getenv('DB_USER') . '</li>';
                            echo '</ul>';
                            echo '</div>';
                            
                        } catch (Exception $e) {
                            echo '<div class="alert alert-danger">';
                            echo '<h4>❌ Erro na Conexão</h4>';
                            echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
                            echo '</div>';
                        }
                        ?>
                        
                        <div class="mt-3">
                            <h5>📌 Próximos Passos:</h5>
                            <ol>
                                <li>Criar as tabelas do banco de dados</li>
                                <li>Implementar sistema de autenticação</li>
                                <li>Desenvolver CRUD de empresas e usuários</li>
                                <li>Criar sistema de Ordens de Serviço</li>
                                <li>Implementar visualização Kanban</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
