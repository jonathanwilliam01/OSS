<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: /autenticacao/autenticacao.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /painel/');
    exit;
}

require_once __DIR__ . '/../functions/conexao.php';

$titulo      = trim($_POST['titulo']        ?? '');
$descricao   = trim($_POST['descricao']     ?? '');
$cliente     = trim($_POST['cliente']       ?? '');
$prioridade  = $_POST['prioridade']         ?? 'media';
$responsavel = (int)($_POST['responsavel_id'] ?? 0) ?: null;

$empresa_id  = (int)$_SESSION['empresa_id'];
$criado_por  = (int)$_SESSION['usuario_id'];

if (!$titulo) {
    header('Location: /painel/?erro=' . urlencode('O título da demanda é obrigatório.'));
    exit;
}

$prioridades_validas = ['baixa', 'media', 'alta'];
if (!in_array($prioridade, $prioridades_validas, true)) {
    $prioridade = 'media';
}

try {
    $pdo->beginTransaction();

    // Incrementa sequência e obtém o próximo número
    $seq = $pdo->prepare("
        UPDATE sequencia_empresa
        SET    ultimo_numero = ultimo_numero + 1, updated_at = NOW()
        WHERE  empresa_id = :eid
        RETURNING ultimo_numero
    ");
    $seq->execute([':eid' => $empresa_id]);
    $numero = (int)$seq->fetchColumn();

    // Insere a OS
    $stmt = $pdo->prepare("
        INSERT INTO ordens_servico
            (empresa_id, numero, titulo, descricao, cliente, prioridade, status, responsavel_id, criado_por)
        VALUES
            (:eid, :num, :titulo, :desc, :cliente, :prior, 'aberto', :resp, :criado)
        RETURNING id
    ");
    $stmt->execute([
        ':eid'    => $empresa_id,
        ':num'    => $numero,
        ':titulo' => $titulo,
        ':desc'   => $descricao ?: null,
        ':cliente'=> $cliente   ?: null,
        ':prior'  => $prioridade,
        ':resp'   => $responsavel,
        ':criado' => $criado_por,
    ]);
    $os_id = (int)$stmt->fetchColumn();

    // Registra no histórico
    $pdo->prepare("
        INSERT INTO historico_os (os_id, usuario_id, acao)
        VALUES (:os, :uid, 'Criou a ordem de serviço')
    ")->execute([':os' => $os_id, ':uid' => $criado_por]);

    $pdo->commit();
    header('Location: /painel/?ok=os_criada');
    exit;

} catch (\PDOException $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    header('Location: /painel/?erro=' . urlencode('Erro ao criar demanda. Tente novamente.'));
    exit;
}
