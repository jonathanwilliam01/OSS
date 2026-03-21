<?php
session_start();

require_once __DIR__ . '/autenticacao_db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /autenticacao/autenticacao.php');
    exit;
}

$email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?? '');
$senha = $_POST['senha'] ?? '';

if (!$email || !$senha) {
    header('Location: /autenticacao/autenticacao.php?erro=campos_obrigatorios');
    exit;
}

$r = logarUsuario($email, $senha);

if ($r['ok']) {
    $u = $r['usuario'];
    $_SESSION['usuario_id']    = $u['id'];
    $_SESSION['usuario_nome']  = $u['nome'];
    $_SESSION['usuario_email'] = $u['email'];
    $_SESSION['empresa_id']    = $u['empresa_id'];
    $_SESSION['perfil']        = $u['perfil'];
    header('Location: /painel/');
    exit;
}

header('Location: /autenticacao/autenticacao.php?erro=' . urlencode($r['erro']));
exit;
