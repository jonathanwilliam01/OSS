<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>OSS — Sistema de Ordens de Serviço</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
  <link href="assets/estilos/styles.css" rel="stylesheet" />
  <link rel="icon" type="image/svg+xml" href="/assets/img/favicon.svg" />
</head>
<body>


<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg px-3">
  <div class="container">
    <a class="navbar-brand fw-bold fs-5 text-white text-decoration-none" href="#">
      OS<span>S</span>
      <small class="text-muted fw-normal ms-1" style="font-size:.7rem;letter-spacing:.06em;">PLATFORM</small>
    </a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" style="color:#c9c9e3">
      <i class="bi bi-list fs-4"></i>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav mx-auto gap-1">
        <li class="nav-item"><a class="nav-link" href="#sobre">Informações</a></li>
        <li class="nav-item"><a class="nav-link" href="#features">Funcionalidades</a></li>
        <li class="nav-item"><a class="nav-link" href="#contact">Contato</a></li>
      </ul>
      <div class="d-flex gap-2 mt-3 mt-lg-0">
        <a href="autenticacao/autenticacao.php" class="btn btn-hero-ghost btn-sm">Login</a>
        <a href="autenticacao/autenticacao.php?tab=cadastro" class="btn-primary-custom text-decoration-none btn btn-hero-ghost btn-sm">Cadastrar-se</a>
      </div>
    </div>
  </div>
</nav>

<!-- HERO -->
<section id="hero">
  <div class="container position-relative" style="z-index:1">
    <div class="row align-items-center gy-5">
      <div class="col-lg-6">
        <div class="hero-badge"><i class="bi bi-lightning-charge-fill me-1"></i>Ordens de Serviço</div>
        <h1 class="hero-title">
          Gerencie ordens de serviço com <span class="highlight">total controle</span>
        </h1>
        <p class="hero-sub mt-3">
          Plataforma completa para organizar suas demandas com Kanban, histórico, comentários e notificações — tudo em um só lugar.
        </p>
        <div class="hero-actions">
          <a href="autenticacao/autenticacao.php?tab=cadastro" class="btn-hero-primary text-decoration-none">Começar gratuitamente</a>
          <a href="#features" class="btn-hero-ghost text-decoration-none">Ver funcionalidades <i class="bi bi-arrow-down ms-1"></i></a>
        </div>
        <div class="d-flex flex-wrap gap-3 mt-4">
          <div class="float-card"><i class="bi bi-kanban"></i><span>Kanban nativo</span></div>
          <div class="float-card"><i class="bi bi-clock-history"></i><span>Histórico completo</span></div>
          <div class="float-card"><i class="bi bi-envelope-check"></i><span>Notificações</span></div>
        </div>
      </div>
      <div class="col-lg-6 d-none d-lg-block">
        <div class="kanban-preview">
          <div class="d-flex gap-2 mb-3">
            <div style="width:10px;height:10px;background:#ff5f57;border-radius:50%"></div>
            <div style="width:10px;height:10px;background:#febc2e;border-radius:50%"></div>
            <div style="width:10px;height:10px;background:#27c840;border-radius:50%"></div>
            <span class="ms-2 text-muted" style="font-size:.73rem">Quadro de OS</span>
          </div>
          <div class="row g-2">
            <div class="col-4">
              <div class="kanban-col-head" style="background:rgba(108,99,255,.15);color:#a79fff">Aberto</div>
              <div class="kanban-card-item">
                Trocar servidor de email
                <div><span class="tag" style="background:rgba(255,95,87,.15);color:#ff8080">Urgente</span></div>
              </div>
              <div class="kanban-card-item">
                Revisar contratos Q1
                <div><span class="tag" style="background:rgba(108,99,255,.15);color:#a79fff">Normal</span></div>
              </div>
            </div>
            <div class="col-4">
              <div class="kanban-col-head" style="background:rgba(254,188,46,.12);color:#febc2e">Em Progresso</div>
              <div class="kanban-card-item">
                Atualização do sistema
                <div><span class="tag" style="background:rgba(255,95,87,.15);color:#ff8080">Urgente</span></div>
              </div>
              <div class="kanban-card-item">
                Revisão de processos
                <div><span class="tag" style="background:rgba(108,99,255,.15);color:#a79fff">Normal</span></div>
              </div>
            </div>
            <div class="col-4">
              <div class="kanban-col-head" style="background:rgba(39,200,64,.12);color:#27c840">Concluído</div>
              <div class="kanban-card-item">
                Onboarding do cliente
                <div><span class="tag" style="background:rgba(39,200,64,.15);color:#27c840">Feito</span></div>
              </div>
              <div class="kanban-card-item">
                Cadastro de usuários
                <div><span class="tag" style="background:rgba(39,200,64,.15);color:#27c840">Feito</span></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- INFORMAÇÕES -->
<section id="sobre">
  <div class="container">
    <div class="text-center mb-5">
      <div class="section-label">Sobre o sistema</div>
      <h2 class="section-title">Tudo o que você precisa saber</h2>
      <p class="section-sub mx-auto mt-2">
        O OSS é uma plataforma web desenvolvida para simplificar a gestão de ordens de serviço, centralizando demandas, equipes e comunicação em um único ambiente.
      </p>
    </div>
    <div class="row g-4">
      <div class="col-md-6 col-lg-4">
        <div class="stack-card">
          <div class="stack-icon" style="background:rgba(108,99,255,.15)">
            <i class="bi bi-kanban-fill" style="color:#a78bfa;font-size:1.5rem"></i>
          </div>
          <h5>Gestão visual com Kanban</h5>
          <p>Acompanhe o andamento de cada ordem de serviço em um quadro Kanban intuitivo, do abertura à conclusão.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="stack-card">
          <div class="stack-icon" style="background:rgba(39,200,64,.12)">
            <i class="bi bi-check2-circle" style="color:#27c840;font-size:1.5rem"></i>
          </div>
          <h5>Controle total de demandas</h5>
          <p>Crie, atribua e monitore ordens de serviço com prioridades, prazos e responsáveis definidos.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="stack-card">
          <div class="stack-icon" style="background:rgba(254,188,46,.12)">
            <i class="bi bi-bell-fill" style="color:#febc2e;font-size:1.5rem"></i>
          </div>
          <h5>Notificações automáticas</h5>
          <p>Seja avisado por e-mail a cada atualização relevante em suas ordens de serviço, sem precisar ficar verificando manualmente.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="stack-card">
          <div class="stack-icon" style="background:rgba(255,95,87,.12)">
            <i class="bi bi-clock-history" style="color:#ff8080;font-size:1.5rem"></i>
          </div>
          <h5>Histórico detalhado</h5>
          <p>Cada alteração fica registrada com data, hora e responsável, garantindo rastreabilidade total das suas OS.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="stack-card">
          <div class="stack-icon" style="background:rgba(36,150,237,.15)">
            <i class="bi bi-chat-dots-fill" style="color:#2496ed;font-size:1.5rem"></i>
          </div>
          <h5>Comentários integrados</h5>
          <p>Toda a comunicação sobre uma OS acontece dentro dela mesma. Sem e-mails paralelos ou informações perdidas.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="stack-card">
          <div class="stack-icon" style="background:rgba(108,99,255,.15)">
            <i class="bi bi-shield-lock-fill" style="color:#a78bfa;font-size:1.5rem"></i>
          </div>
          <h5>Acesso seguro</h5>
          <p>Controle quem pode ver e editar cada OS com níveis de permissão por usuário, mantendo sua operação protegida.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FUNCIONALIDADES -->
<section id="features" style="background:var(--surface-2)">
  <div class="container">
    <div class="row align-items-center gy-5">
      <div class="col-lg-5">
        <div class="section-label">Funcionalidades</div>
        <h2 class="section-title">Simples de usar, poderoso na prática</h2>
        <p class="section-sub mt-2">Do primeiro acesso ao fechamento da OS, cada passo do fluxo foi pensado para times que precisam de agilidade.</p>
        <div class="mt-4">
          <div class="feature-item">
            <div class="feature-icon"><i class="bi bi-kanban-fill"></i></div>
            <div class="feature-text">
              <h6>Quadro Kanban</h6>
              <p>Visualize e mova ordens de serviço entre colunas — Aberto, Em Progresso e Concluído — de forma rápida e intuitiva.</p>
            </div>
          </div>
          <div class="feature-item">
            <div class="feature-icon"><i class="bi bi-clock-history"></i></div>
            <div class="feature-text">
              <h6>Histórico & Auditoria</h6>
              <p>Rastreie cada alteração com data, hora e usuário responsável — total rastreabilidade.</p>
            </div>
          </div>
          <div class="feature-item">
            <div class="feature-icon"><i class="bi bi-chat-dots-fill"></i></div>
            <div class="feature-text">
              <h6>Comentários em OS</h6>
              <p>Colaboração centralizada na própria ordem de serviço, sem precisar de e-mail ou chat externo.</p>
            </div>
          </div>
          <div class="feature-item">
            <div class="feature-icon"><i class="bi bi-shield-lock-fill"></i></div>
            <div class="feature-text">
              <h6>Controle de Acesso</h6>
              <p>Gerencie permissões por usuário e garanta que cada pessoa veja apenas o que deve ver.</p>
            </div>
          </div>
          <div class="feature-item">
            <div class="feature-icon"><i class="bi bi-envelope-fill"></i></div>
            <div class="feature-text">
              <h6>Notificações por e-mail</h6>
              <p>Alertas automáticos a cada movimentação importante, para que nenhuma atualização passe despercebida.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-7">
        <div class="row g-3">
          <div class="col-6">
            <div class="stack-card text-center py-4">
              <div class="display-5 fw-bold mb-1" style="color:var(--primary)">100%</div>
              <div class="fw-600">Web</div>
              <div class="text-muted" style="font-size:.83rem">acesse de qualquer lugar</div>
            </div>
          </div>
          <div class="col-6">
            <div class="stack-card text-center py-4">
              <div class="display-5 fw-bold mb-1" style="color:#27c840">99.9%</div>
              <div class="fw-600">Uptime</div>
              <div class="text-muted" style="font-size:.83rem">alta disponibilidade</div>
            </div>
          </div>
          <div class="col-12">
            <div class="stack-card">
              <div class="d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-person-check-fill" style="color:var(--primary)"></i>
                <span class="fw-600" style="font-size:.88rem">Pronto para sua equipe em minutos</span>
              </div>
              <div class="d-flex flex-column gap-2">
                <div class="d-flex align-items-center gap-2" style="font-size:.87rem;color:#c9c9e3">
                  <i class="bi bi-check-circle-fill" style="color:#27c840"></i> Crie sua conta gratuitamente
                </div>
                <div class="d-flex align-items-center gap-2" style="font-size:.87rem;color:#c9c9e3">
                  <i class="bi bi-check-circle-fill" style="color:#27c840"></i> Cadastre sua equipe e defina permissões
                </div>
                <div class="d-flex align-items-center gap-2" style="font-size:.87rem;color:#c9c9e3">
                  <i class="bi bi-check-circle-fill" style="color:#27c840"></i> Crie e gerencie suas ordens de serviço
                </div>
                <div class="d-flex align-items-center gap-2" style="font-size:.87rem;color:#c9c9e3">
                  <i class="bi bi-check-circle-fill" style="color:#27c840"></i> Acompanhe tudo pelo Kanban em tempo real
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CONTATO -->
<section id="contact">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-7">
        <div class="text-center mb-4">
          <div class="section-label">Contato</div>
          <h2 class="section-title">Fale com a gente</h2>
          <p class="section-sub mx-auto mt-2">Dúvidas, parcerias ou suporte — nossa equipe retorna em até 24h úteis.</p>
        </div>
        <div class="contact-card">
          <form>
            <div class="row g-3">
              <div class="col-md-6">
                <label>Nome completo</label>
                <input type="text" class="form-control" placeholder="Seu nome" />
              </div>
              <div class="col-md-6">
                <label>E-mail</label>
                <input type="email" class="form-control" placeholder="voce@email.com" />
              </div>
              <div class="col-12">
                <label>Assunto</label>
                <select class="form-select">
                  <option value="">Selecione o assunto</option>
                  <option>Suporte</option>
                  <option>Interesse comercial</option>
                  <option>Parceria</option>
                  <option>Outro</option>
                </select>
              </div>
              <div class="col-12">
                <label>Mensagem</label>
                <textarea class="form-control" rows="4" placeholder="Descreva sua necessidade..."></textarea>
              </div>
              <div class="col-12">
                <button type="submit" class="btn-hero-primary w-100 py-3 border-0" style="border-radius:10px;cursor:pointer">
                  <i class="bi bi-send-fill me-2"></i>Enviar mensagem
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="container">
    <div class="row gy-4">
      <div class="col-lg-4">
        <p class="fw-bold fs-5 text-white brand-name mb-2">OS<span>S</span> Platform</p>
        <p style="max-width:280px;line-height:1.7">Sistema de ordens de serviço com Kanban, histórico e notificações.</p>
        <div class="d-flex gap-2 mt-3">
          <a href="#" class="social-btn"><i class="bi bi-github"></i></a>
          <a href="#" class="social-btn"><i class="bi bi-linkedin"></i></a>
          <a href="#" class="social-btn"><i class="bi bi-twitter-x"></i></a>
        </div>
      </div>
      <div class="col-6 col-lg-2 offset-lg-2">
        <p class="text-white fw-600 mb-3" style="font-size:.9rem">Navegação</p>
        <a href="#sobre" class="footer-link">Informações</a>
        <a href="#features" class="footer-link">Funcionalidades</a>
        <a href="#contact" class="footer-link">Contato</a>
      </div>
      <div class="col-6 col-lg-2">
        <p class="text-white fw-600 mb-3" style="font-size:.9rem">Acesso</p>
        <a href="autenticacao/autenticacao.php" class="footer-link">Login</a>
        <a href="autenticacao/autenticacao.php?tab=cadastro" class="footer-link">Cadastrar-se</a>
      </div>
      <div class="col-12 col-lg-2">
        <p class="text-white fw-600 mb-3" style="font-size:.9rem">Suporte</p>
        <a href="#contact" class="footer-link">Fale conosco</a>
        <a href="#" class="footer-link">Documentação</a>
      </div>
    </div>
    <hr class="footer-divider" />
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
      <span>&copy; <?php echo date('Y'); ?> OSS Platform. Todos os direitos reservados.</span>
      <span>A solução que sua empresa precisa.</span>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
