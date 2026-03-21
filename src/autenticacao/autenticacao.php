<?php
$tab       = $_GET['tab'] ?? 'login';
$activeTab = ($tab === 'cadastro') ? 'cadastro' : 'login';

$erros = [
    'campos_obrigatorios'  => 'Preencha todos os campos obrigatórios.',
    'senha_curta'          => 'A senha deve ter no mínimo 8 caracteres.',
    'dados_duplicados'     => 'CNPJ ou e-mail já cadastrado.',
    'credenciais_invalidas'=> 'E-mail ou senha incorretos.',
    'usuario_inativo'      => 'Usuário inativo. Entre em contato com o suporte.',
    'erro_interno'         => 'Erro interno. Tente novamente mais tarde.',
];
$erro_key = $_GET['erro'] ?? '';
$erro_msg = $erro_key ? ($erros[$erro_key] ?? 'Ocorreu um erro. Tente novamente.') : '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>OSS — <?php echo $activeTab === 'cadastro' ? 'Criar conta' : 'Entrar'; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
  <link href="../assets/estilos/styles.css" rel="stylesheet" />
  <link rel="icon" type="image/svg+xml" href="/assets/img/favicon.svg" />
</head>
<body style="min-height:100vh;display:flex;flex-direction:column">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg px-3">
  <div class="container">
    <a class="navbar-brand fw-bold fs-5 text-white text-decoration-none" href="/index.php">
      OS<span>S</span>
      <small class="text-muted fw-normal ms-1" style="font-size:.7rem;letter-spacing:.06em;">PLATFORM</small>
    </a>
    <div class="ms-auto d-flex gap-2">
      <a href="autenticacao.php"
         class="btn btn-hero-ghost btn-sm <?php echo $activeTab === 'login' ? 'active-nav' : ''; ?>"
         style="<?php echo $activeTab === 'login' ? 'border-color:var(--primary);color:#fff' : ''; ?>">
        Login
      </a>
      <a href="autenticacao.php?tab=cadastro"
         class="btn-primary-custom text-decoration-none btn btn-hero-ghost btn-sm"
         style="<?php echo $activeTab === 'cadastro' ? 'background:var(--primary-d)' : ''; ?>">
        Cadastrar-se
      </a>
    </div>
  </div>
</nav>

<!-- CONTEÚDO PRINCIPAL -->
<section style="flex:1;display:flex;align-items:center;padding:4rem 0;
  background:radial-gradient(ellipse 70% 50% at 50% -10%, rgba(108,99,255,.3) 0%, transparent 70%), var(--surface)">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-5 col-md-7">

        <!-- Logo + subtítulo -->
        <div class="text-center mb-4">
          <a href="index.php" class="text-decoration-none">
            <span class="fw-bold fs-3 text-white">OS<span style="color:var(--primary)">S</span></span>
          </a>
          <p class="mt-2 mb-0" style="color:var(--text-muted);font-size:.93rem">
            <?php echo $activeTab === 'cadastro' ? 'Crie sua conta e comece agora' : 'Bem-vindo de volta'; ?>
          </p>
        </div>

        <!-- Card de autenticação -->
        <div class="auth-card">

          <?php if ($erro_msg): ?>
            <div style="background:rgba(255,95,87,.1);border:1px solid rgba(255,95,87,.3);
                        color:#ff8080;border-radius:8px;padding:.65rem .9rem;
                        font-size:.85rem;margin-bottom:1.2rem;display:flex;align-items:center;gap:.5rem">
              <i class="bi bi-exclamation-circle-fill"></i>
              <?= htmlspecialchars($erro_msg) ?>
            </div>
          <?php endif; ?>

          <!-- Tabs -->
          <ul class="nav nav-tabs-auth nav-tabs border-0">
            <li class="nav-item">
              <button class="nav-link <?php echo $activeTab === 'login' ? 'active' : ''; ?>"
                      id="tab-login" onclick="switchTab('login')">
                <i class="bi bi-box-arrow-in-right me-1"></i>Login
              </button>
            </li>
            <li class="nav-item">
              <button class="nav-link <?php echo $activeTab === 'cadastro' ? 'active' : ''; ?>"
                      id="tab-cadastro" onclick="switchTab('cadastro')">
                <i class="bi bi-person-plus me-1"></i>Cadastrar-se
              </button>
            </li>
          </ul>

          <!-- ── PAINEL LOGIN ── -->
          <div id="pane-login" <?php echo $activeTab !== 'login' ? 'style="display:none"' : ''; ?>>
            <form method="POST" action="login.php">
              <div class="mb-3">
                <label>E-mail</label>
                <input type="email" name="email" class="form-control" placeholder="voce@email.com" required />
              </div>
              <div class="mb-4">
                <label>Senha</label>
                <input type="password" name="senha" class="form-control" placeholder="••••••••" required />
              </div>
              <button type="submit" class="btn-hero-primary w-100 py-3 border-0"
                      style="border-radius:10px;cursor:pointer">
                Entrar na plataforma
              </button>
              <p class="text-center mt-3 mb-0" style="font-size:.83rem;color:var(--text-muted)">
                <a href="#" style="color:var(--primary);text-decoration:none">Esqueceu a senha?</a>
              </p>
            </form>
          </div>

          <!-- ── PAINEL CADASTRO ── -->
          <div id="pane-cadastro" <?php echo $activeTab !== 'cadastro' ? 'style="display:none"' : ''; ?>>
            <form method="POST" action="cadastro.php">
              <div class="row g-3">
                <div class="col-md-6">
                  <label>Nome completo</label>
                  <input type="text" name="nome" class="form-control" placeholder="Seu nome" required />
                </div>
                <div class="col-md-6">
                  <label>E-mail</label>
                  <input type="email" name="email" class="form-control" placeholder="voce@email.com" required />
                </div>
                <div class="col-12">
                  <label>Nome da empresa</label>
                  <input type="text" name="empresa" class="form-control" placeholder="Sua empresa" required />
                </div>
                <div class="col-md-6">
                  <label>CNPJ</label>
                  <input type="text" name="cnpj" class="form-control" placeholder="00.000.000/0000-00" />
                </div>
                <div class="col-md-6">
                  <label>Telefone</label>
                  <input type="tel" name="telefone" class="form-control" placeholder="(11) 90000-0000" />
                </div>
                <div class="col-12">
                  <label>Senha</label>
                  <input type="password" name="senha" class="form-control"
                         placeholder="Mínimo 8 caracteres" minlength="8" required />
                </div>
                <div class="col-12">
                  <button type="submit" class="btn-hero-primary w-100 py-3 border-0"
                          style="border-radius:10px;cursor:pointer">
                    <i class="bi bi-person-check-fill me-2"></i>Criar conta gratuitamente
                  </button>
                </div>
              </div>
            </form>
          </div>

        </div>

        <!-- Voltar -->
        <p class="text-center mt-3" style="font-size:.83rem;color:var(--text-muted)">
          <a href="/index.php" style="color:var(--primary);text-decoration:none">
            <i class="bi bi-arrow-left me-1"></i>Voltar para o início
          </a>
        </p>

      </div>
    </div>
  </div>
</section>

<!-- FOOTER MÍNIMO -->
<footer style="background:var(--surface-2);border-top:1px solid var(--border);
               padding:1.2rem 0;text-align:center;font-size:.83rem;color:var(--text-muted)">
  &copy; <?php echo date('Y'); ?> OSS Platform. Todos os direitos reservados.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function switchTab(tab) {
    const isLogin = tab === 'login';
    document.getElementById('pane-login').style.display   = isLogin ? 'block' : 'none';
    document.getElementById('pane-cadastro').style.display = isLogin ? 'none'  : 'block';
    document.getElementById('tab-login').classList.toggle('active', isLogin);
    document.getElementById('tab-cadastro').classList.toggle('active', !isLogin);
    const url = new URL(window.location);
    if (isLogin) { url.searchParams.delete('tab'); } else { url.searchParams.set('tab', 'cadastro'); }
    window.history.replaceState({}, '', url);
  }
</script>
</body>
</html>
