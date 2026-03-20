<?php
/**
 * Arquivo de Conexão com PostgreSQL
 * Sistema de Ordem de Serviço Multiempresa
 */

$db_host = getenv('DB_HOST');
$db_port = getenv('DB_PORT');
$db_name = getenv('DB_NAME');
$db_user = getenv('DB_USER');
$db_pass = getenv('DB_PASS');

try {
    // String de conexão PDO para PostgreSQL
    $dsn = "pgsql:host={$db_host};port={$db_port};dbname={$db_name}";
    
    // Criar conexão PDO
    $pdo = new PDO($dsn, $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    
    // Definir charset UTF-8
    $pdo->exec("SET NAMES 'UTF8'");
    
} catch (PDOException $e) {
    // Em produção, registre o erro em um log ao invés de exibir
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

/**
 * Função para testar a conexão
 * @return bool
 */
function testarConexao() {
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT version()");
        $version = $stmt->fetch();
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

// Retornar objeto de conexão
return $pdo;
?>
