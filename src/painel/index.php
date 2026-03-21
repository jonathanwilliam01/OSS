<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: /autenticacao/autenticacao.php');
    exit;
}

require_once __DIR__ . '/../functions/conexao.php';

// ── Dados do Kanban ──
$statuses = [
    'aberto'       => ['label' => 'Aberto',       'color' => '#a78bfa', 'bg' => 'rgba(108,99,255,.15)'],
    'em_andamento' => ['label' => 'Em Andamento',  'color' => '#febc2e', 'bg' => 'rgba(254,188,46,.12)'],
    'aguardando'   => ['label' => 'Aguardando',    'color' => '#ff8080', 'bg' => 'rgba(255,95,87,.15)'],
    'finalizado'   => ['label' => 'Finalizado',    'color' => '#27c840', 'bg' => 'rgba(39,200,64,.12)'],
];

$os_map = array_fill_keys(array_keys($statuses), []);

$stmt = $pdo->prepare("
    SELECT o.id, o.numero, o.titulo, o.prioridade, o.status, o.cliente,
           u.nome AS responsavel_nome
    FROM   ordens_servico o
    LEFT   JOIN usuarios u ON u.id = o.responsavel_id
    WHERE  o.empresa_id = :eid
    ORDER  BY o.created_at DESC
");
$stmt->execute([':eid' => $_SESSION['empresa_id']]);
foreach ($stmt->fetchAll() as $os) {
    if (array_key_exists($os['status'], $os_map)) {
        $os_map[$os['status']][] = $os;
    }
}

// ── Usuários para o modal ──
$u_stmt = $pdo->prepare("SELECT id, nome FROM usuarios WHERE empresa_id = :eid AND ativo = true ORDER BY nome");
$u_stmt->execute([':eid' => $_SESSION['empresa_id']]);
$usuarios = $u_stmt->fetchAll();

// ── Mensagens de feedback ──
$ok_msg   = $_GET['ok']   ?? '';
$erro_msg = $_GET['erro'] ?? '';

// ── Iniciais do usuário ──
$palavras = explode(' ', trim($_SESSION['usuario_nome']));
$iniciais = strtoupper($palavras[0][0] ?? 'U');
if (isset($palavras[1][0])) $iniciais .= strtoupper($palavras[1][0]);

$prioridade_color = ['alta' => '#ff5f57', 'media' => '#febc2e', 'baixa' => '#27c840'];
$prioridade_bg    = ['alta' => 'rgba(255,95,87,.15)', 'media' => 'rgba(254,188,46,.12)', 'baixa' => 'rgba(39,200,64,.12)'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>OSS — Painel</title>
  <link rel="icon" type="image/svg+xml" href="/assets/img/favicon.svg" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
  <link href="/assets/estilos/styles.css" rel="stylesheet" />
  <link href="/assets/estilos/painel.css" rel="stylesheet" />
</head>
<body>

<!-- ═══════════════ SIDEBAR ═══════════════ -->
<aside class="sidebar">
  <div class="sidebar-brand">
    <a href="/painel/" class="brand">OS<span>S</span>
      <span style="font-size:.65rem;font-weight:400;color:var(--text-muted);letter-spacing:.06em;margin-left:.3rem">PLATFORM</span>
    </a>
    <div class="mt-3">
      <button class="btn-nova-demanda" data-bs-toggle="modal" data-bs-target="#modalNovaDemanda">
        <i class="bi bi-plus-lg"></i> Nova Demanda
      </button>
    </div>
  </div>

  <nav class="sidebar-nav">
    <div class="nav-section-label">Principal</div>
    <a href="/painel/" class="s-link active">
      <i class="bi bi-kanban-fill"></i> Kanban
    </a>
    <a href="#" class="s-link">
      <i class="bi bi-list-task"></i> Minhas OS
    </a>
    <a href="#" class="s-link">
      <i class="bi bi-collection-fill"></i> Todas as OS
    </a>

    <div class="nav-section-label">Gestão</div>
    <a href="#" class="s-link">
      <i class="bi bi-people-fill"></i> Usuários
    </a>
    <a href="#" class="s-link">
      <i class="bi bi-bar-chart-fill"></i> Relatórios
    </a>

    <div class="nav-section-label">Sistema</div>
    <a href="#" class="s-link">
      <i class="bi bi-gear-fill"></i> Configurações
    </a>
    <a href="/painel/sair.php" class="s-link danger">
      <i class="bi bi-box-arrow-right"></i> Sair
    </a>
  </nav>

  <div class="sidebar-bottom">
    <div class="user-cell">
      <div class="user-avatar"><?= $iniciais ?></div>
      <div>
        <div class="user-name"><?= htmlspecialchars($_SESSION['usuario_nome']) ?></div>
        <div class="user-role"><?= ucfirst(htmlspecialchars($_SESSION['perfil'])) ?></div>
      </div>
    </div>
  </div>
</aside>

<!-- ═══════════════ MAIN CONTENT ═══════════════ -->
<div class="main-content">

  <!-- Topbar -->
  <div class="topbar">
    <div class="topbar-title">
      Kanban
      <small>Visão geral das ordens de serviço</small>
    </div>
    <div class="search-box">
      <i class="bi bi-search"></i>
      <input type="text" placeholder="Buscar OS por título ou cliente…" />
    </div>
    <button class="btn-nova-demanda"
            style="width:auto;padding:.5rem 1.1rem;font-size:.85rem"
            data-bs-toggle="modal" data-bs-target="#modalNovaDemanda">
      <i class="bi bi-plus-lg"></i> Nova Demanda
    </button>
  </div>

  <!-- Feedback -->
  <?php if ($ok_msg === 'os_criada'): ?>
    <div class="alert-bar" style="background:rgba(39,200,64,.1);border:1px solid rgba(39,200,64,.3);color:#27c840">
      <i class="bi bi-check-circle-fill"></i> Ordem de serviço criada com sucesso!
    </div>
  <?php elseif ($erro_msg): ?>
    <div class="alert-bar" style="background:rgba(255,95,87,.1);border:1px solid rgba(255,95,87,.3);color:#ff8080">
      <i class="bi bi-exclamation-circle-fill"></i> <?= htmlspecialchars($erro_msg) ?>
    </div>
  <?php endif; ?>

  <!-- Kanban Board -->
  <div class="kanban-wrapper">
    <div class="kanban-board">
      <?php foreach ($statuses as $key => $cfg): ?>
        <?php $cards = $os_map[$key]; ?>
        <div class="k-col">
          <div class="k-col-head">
            <div class="k-col-label">
              <div class="k-dot" style="background:<?= $cfg['color'] ?>"></div>
              <span style="color:<?= $cfg['color'] ?>"><?= $cfg['label'] ?></span>
            </div>
            <span class="k-count"><?= count($cards) ?></span>
          </div>
          <div class="k-col-body">
            <?php if (empty($cards)): ?>
              <div class="empty-col">
                <i class="bi bi-inbox"></i>
                Nenhuma OS aqui
              </div>
            <?php else: ?>
              <?php foreach ($cards as $os):
                $pc  = $prioridade_color[$os['prioridade']] ?? '#a79fff';
                $pbg = $prioridade_bg[$os['prioridade']]    ?? 'rgba(108,99,255,.15)';
                $ri  = null;
                if ($os['responsavel_nome']) {
                    $rw = explode(' ', trim($os['responsavel_nome']));
                    $ri = strtoupper($rw[0][0] ?? '');
                    if (isset($rw[1][0])) $ri .= strtoupper($rw[1][0]);
                }
              ?>
                <div class="os-card">
                  <div class="os-num">#<?= str_pad($os['numero'], 4, '0', STR_PAD_LEFT) ?></div>
                  <div class="os-title"><?= htmlspecialchars($os['titulo']) ?></div>
                  <?php if ($os['cliente']): ?>
                    <div class="os-client">
                      <i class="bi bi-building me-1"></i><?= htmlspecialchars($os['cliente']) ?>
                    </div>
                  <?php endif; ?>
                  <div class="os-footer">
                    <span class="p-badge" style="background:<?= $pbg ?>;color:<?= $pc ?>">
                      <?= ucfirst($os['prioridade']) ?>
                    </span>
                    <?php if ($ri): ?>
                      <div class="resp-avatar" title="<?= htmlspecialchars($os['responsavel_nome']) ?>">
                        <?= $ri ?>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<!-- ═══════════════ MODAL NOVA DEMANDA ═══════════════ -->
<div class="modal fade" id="modalNovaDemanda" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="bi bi-plus-circle-fill me-2" style="color:var(--primary)"></i>Nova Demanda
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" action="/painel/nova_os.php">
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-12">
              <label>Título *</label>
              <input type="text" name="titulo" class="form-control"
                     placeholder="Descreva brevemente a demanda" required />
            </div>
            <div class="col-12">
              <label>Descrição</label>
              <textarea name="descricao" class="form-control" rows="3"
                        placeholder="Detalhes adicionais…"></textarea>
            </div>
            <div class="col-md-6">
              <label>Cliente</label>
              <input type="text" name="cliente" class="form-control" placeholder="Nome do cliente" />
            </div>
            <div class="col-md-6">
              <label>Prioridade *</label>
              <select name="prioridade" class="form-select" required>
                <option value="baixa">Baixa</option>
                <option value="media" selected>Média</option>
                <option value="alta">Alta</option>
              </select>
            </div>
            <div class="col-12">
              <label>Responsável</label>
              <select name="responsavel_id" class="form-select">
                <option value="">Sem responsável</option>
                <?php foreach ($usuarios as $u): ?>
                  <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['nome']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-hero-ghost"
                  style="padding:.48rem 1.2rem;font-size:.86rem"
                  data-bs-dismiss="modal">
            Cancelar
          </button>
          <button type="submit" class="btn-nova-demanda"
                  style="width:auto;padding:.52rem 1.4rem;font-size:.87rem">
            <i class="bi bi-check-lg"></i> Criar Demanda
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
