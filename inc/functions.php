<?php
$erro = "";
$msg = "";

// Função para obter o caminho base do script PHP atual
function getBaseUrl()
{
  $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https' ? 'https' : 'http';
  $host = $_SERVER['HTTP_HOST'];
  $script = $_SERVER['SCRIPT_NAME'];
  return $protocol . '://' . $host . dirname($script);
}

// Usar a função para obter o caminho base
$base_url = getBaseUrl();

// Mapea os arquivos de cada página
$pageMappings = [
  'inicio' => 'home.php',
  'doe' => 'doacao.php',
  'adote' => 'adocao.php',
  'contato' => 'contato.php',
  'login' => 'login.php',
  'cadastrar' => 'cadastrar.php',
  'painel' => 'painel.php',
  'sair' => 'sair.php',
  'mural' => 'mural.home.php',
  'sos' => 'sos.php'
];

// Titulo das páginas
$pageTitles = [
  'inicio' => 'Home',
  'doe' => 'Doação',
  'adote' => 'Adoção',
  'contato' => 'Contato',
  'login' => 'Entrar',
  'cadastrar' => 'Cadastrar',
  'painel' => 'Painel',
  'sair' => 'Sair',
  'mural' => 'Mural',
  'sos' => 'S.O.S'
];

// Página padrão (se $_GET['p'] não estiver definido ou não mapeado)
$defaultPage = 'inicio';

function getUsuarioByID($conn)
{

  // Verifica se a sessão está ativa
  if (isset($_SESSION['usuario_id'])) {
    $usuarioID = $_SESSION['usuario_id'];

    // Consulta no banco de dados para obter os dados do usuário
    $sql = "SELECT * FROM tbl_usuario WHERE id = '$usuarioID'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
      // Retorna os dados do usuário como array associativo
      return mysqli_fetch_assoc($result);
    }
  }

  return null; // Retorna null se a sessão não estiver ativa ou se não houver dados do usuário
}

function getSiteConfig($conn)
{
  $sql = "SELECT * FROM tbl_config WHERE id = 1";
  $siteConfig = mysqli_query($conn, $sql);

  return mysqli_fetch_assoc($siteConfig);
}
$siteConfig = getSiteConfig($conn);