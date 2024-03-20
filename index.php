<?php
// Conexão
require_once("inc/conexao.php");
// Funções
require_once("inc/functions.php");

if (isset($_GET['init_admin'])) {
  $_SESSION['admin'] = true;
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    <?= $siteConfig['titulo']; ?>
  </title>
  <link rel="stylesheet" href="<?php echo $base_url; ?>/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $base_url; ?>/css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="shortcut icon" href="img/favicon.png" type="image/png">
</head>

<body>
  <?php // Navbar
  require_once("inc/navbar.php"); ?>

  <?php // Cabeçalho
  require_once("inc/header.php"); ?>

  <?php


  $page = isset($_GET['p']) ? $_GET['p'] : 'inicio';

  // Verificar se a página solicitada está mapeada
  if (array_key_exists($page, $pageMappings)) {
    $pageFile = "inc/" . $pageMappings[$page];

    // Verificar se o arquivo da página existe
    if (file_exists($pageFile)) {
      require_once($pageFile);
    } else {
      // Página não encontrada
      echo "<div class='container'><div class='row'><div class='col-lg-8 mx-auto mt-3'><div class='alert alert-danger'><b>DEBUG:</b> Arquivo da página ($pageFile) não encontrado.</div></div></div></div>";
      require_once("inc/erro.php");
    }
  } else {
    // Página não encontrada
    echo "<div class='container'><div class='row'><div class='col-lg-8 mx-auto mt-3'><div class='alert alert-danger'><b>DEBUG:</b> Página não mapeada ($page).</div></div></div></div>";
    require_once("inc/erro.php");
  }
  ?>


  <!-- FOOTER -->
  <?php require_once('inc/footer.inc.php'); ?>

  <!-- SCRIPTS -->
  <script src="<?php echo $base_url; ?>/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo $base_url; ?>/js/main.js"></script>
</body>

</html>