<?php
session_start();

require_once __DIR__ . '/autenticacao_db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /autenticacao/autenticacao.php?tab=cadastro');
    exit;
}

$nome     = trim($_POST['nome']     ?? '');
$email    = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?? '');
$empresa  = trim($_POST['empresa']  ?? '');
$cnpj     = trim($_POST['cnpj']     ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$senha    = $_POST['senha']         ?? '';

if (!$nome || !$email || !$empresa || !$senha) {
    header('Location: /autenticacao/autenticacao.php?tab=cadastro&erro=campos_obrigatorios');
    exit;
}

if (strlen($senha) < 8) {
    header('Location: /autenticacao/autenticacao.php?tab=cadastro&erro=senha_curta');
    exit;
}

$r = cadastrarUsuario([
    'nome'     => $nome,
    'email'    => $email,
    'empresa'  => $empresa,
    'cnpj'     => $cnpj,
    'telefone' => $telefone,
    'senha'    => $senha,
]);

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

header('Location: /autenticacao/autenticacao.php?tab=cadastro&erro=' . urlencode($r['erro']));
exit;
