<?php
// Configura o tempo máximo de vida da sessão
ini_set('session.gc_maxlifetime', 3600);

// Inicia a sessão
session_start();

// Define o horario do site como o de São Paulo / Brasilia
date_default_timezone_set('America/Sao_Paulo');

// Dados de conexão com o servidor MySQL
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "sosanimal";

// Realiza a conexão com o banco de dados
$conn = mysqli_connect($servidor, $usuario, $senha, $banco);

// Avisa se houver erro na conexão
if (!$conn) {
  echo "Erro ao conectar. ";
}

// Inicia variáveis de sucesso e erro sem valor
$msg = "";
$erro = "";
