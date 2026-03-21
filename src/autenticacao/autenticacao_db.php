<?php
require_once __DIR__ . '/../functions/conexao.php';

/**
 * Cadastra uma nova empresa e seu usuário admin.
 */
function cadastrarUsuario(array $dados): array
{
    global $pdo;
    try {
        $pdo->beginTransaction();

        // Cria empresa
        $stmt = $pdo->prepare("
            INSERT INTO empresas (nome, cnpj, telefone)
            VALUES (:nome, :cnpj, :telefone)
            RETURNING id
        ");
        $stmt->execute([
            ':nome'     => $dados['empresa'],
            ':cnpj'     => $dados['cnpj']     ?: null,
            ':telefone' => $dados['telefone'] ?: null,
        ]);
        $empresa_id = (int) $stmt->fetchColumn();

        // Cria usuário admin da empresa
        $stmt = $pdo->prepare("
            INSERT INTO usuarios (empresa_id, nome, email, senha, perfil)
            VALUES (:eid, :nome, :email, :senha, 'admin')
            RETURNING id, empresa_id, nome, email, perfil
        ");
        $stmt->execute([
            ':eid'   => $empresa_id,
            ':nome'  => $dados['nome'],
            ':email' => $dados['email'],
            ':senha' => password_hash($dados['senha'], PASSWORD_BCRYPT),
        ]);
        $usuario = $stmt->fetch();

        // Inicializa sequência de numeração de OS
        $pdo->prepare("INSERT INTO sequencia_empresa (empresa_id) VALUES (?)")
            ->execute([$empresa_id]);

        $pdo->commit();
        return ['ok' => true, 'usuario' => $usuario];

    } catch (\PDOException $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        $erro = ($e->getCode() === '23505') ? 'dados_duplicados' : 'erro_interno';
        return ['ok' => false, 'erro' => $erro];
    }
}

/**
 * Autentica um usuário pelo e-mail e senha.
 */
function logarUsuario(string $email, string $senha): array
{
    global $pdo;
    try {
        $stmt = $pdo->prepare("
            SELECT id, empresa_id, nome, email, senha, perfil, ativo
            FROM usuarios
            WHERE email = :email
            LIMIT 1
        ");
        $stmt->execute([':email' => $email]);
        $u = $stmt->fetch();

        if (!$u || !password_verify($senha, $u['senha'])) {
            return ['ok' => false, 'erro' => 'credenciais_invalidas'];
        }
        if (!$u['ativo']) {
            return ['ok' => false, 'erro' => 'usuario_inativo'];
        }

        unset($u['senha']);
        return ['ok' => true, 'usuario' => $u];

    } catch (\PDOException $e) {
        return ['ok' => false, 'erro' => 'erro_interno'];
    }
}
