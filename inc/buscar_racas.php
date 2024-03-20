<?php
// Definindo o cabeçalho Content-Type como application/json
header('Content-Type: application/json');

// Incluindo o arquivo de conexão
include('conexao.php');

// Verifique se o parâmetro 'categoria' foi recebido
if (isset($_GET['categoria'])) {
  // Obtém o nome da categoria selecionada
  $nomeCategoria = $_GET['categoria'];

  // Consulta o ID da categoria no banco de dados
  $sql = "SELECT c_id FROM tbl_pet WHERE c_categoria = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $nomeCategoria);
  $stmt->execute();
  $result = $stmt->get_result();

  // Verifica se a categoria existe no banco de dados
  if ($result->num_rows > 0) {
    // Obtém o ID da categoria
    $row = $result->fetch_assoc();
    $idCategoria = $row['c_id'];

    // Consulta as raças correspondentes à categoria no banco de dados
    $sqlRacas = "SELECT r_nome FROM tbl_raca WHERE c_id = ?";
    $stmtRacas = $conn->prepare($sqlRacas);
    $stmtRacas->bind_param("i", $idCategoria);
    $stmtRacas->execute();
    $resultRacas = $stmtRacas->get_result();

    // Array para armazenar as raças
    $racas = array();

    // Adiciona as raças ao array
    while ($rowRacas = $resultRacas->fetch_assoc()) {
      $racas[] = $rowRacas['r_nome'];
    }

    // Retorna as raças em formato JSON
    echo json_encode($racas);
    
    // Fecha o statement de raças
    $stmtRacas->close();
  } else {
    // Se a categoria não existir, retorna um erro
    http_response_code(404);
    echo "Categoria não encontrada.";
  }
} else {
  // Se o parâmetro 'categoria' não foi recebido, retorna um erro
  http_response_code(400);
  echo "Erro: Parâmetro 'categoria' não foi fornecido.";
}

// Fecha o statement principal
$stmt->close();

// Fecha a conexão com o banco de dados
$conn->close();
