<?php
session_start();
session_destroy();
header('Location: /autenticacao/autenticacao.php');
exit;
