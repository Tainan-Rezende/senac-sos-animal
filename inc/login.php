<?php
// Verifica se há sessão iniciada
if (isset($_SESSION['usuario_id'])) {
  // Redireciona para a página do painel
  header("Location: painel");
  exit();
}

// Verifica se a requisição é do tipo POST
if ($_SERVER['REQUEST_METHOD'] === "POST") {
  // Recebe os dados do formulário
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $senha = $_POST['senha'];

  // Verifica se os campos não estão vazios
  if (empty($email) || empty($senha)) {
    $erro = "Erro: Preencha todos os campos.";
  } else {
    // Consulta no banco de dados para obter os dados do usuário
    $sql = "SELECT * FROM tbl_usuario WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      $dadosUsuario = mysqli_fetch_assoc($result);

      // Verifica se a senha está correta
      if ($dadosUsuario && password_verify($senha, $dadosUsuario['senha'])) {
        // Login bem-sucedido
        $_SESSION['usuario_id'] = $dadosUsuario['id'];

        // Redireciona para a página do painel
        header("Location: painel");
        exit();
      } else {
        // Senha incorreta
        $erro = "Erro: E-mail ou senha incorretos.";
      }
    } else {
      // Erro na consulta ao banco de dados
      $erro = "Erro ao consultar o banco de dados: " . mysqli_error($conn);
    }
  }
}
?>
<div class="container my-5">
  <div class="row">
    <div class="col-lg-8 mx-auto">
      <div class="row g-1">
        <div class="col-lg-8">
          <div class="border border-warning p-3 rounded">
            <p class="mb-0">Preencha os campos abaixo para entrar na sua conta.</p>
            <hr class="my-2 text-warning">
            <?php if (strlen($erro) > 0) { ?>
              <div class="alert alert-danger mb-0">
                <h4>Erro</h4>
                <hr class="my-2">
                <p class="mb-0">
                  <?= $erro; ?>
                </p>
              </div>
              <hr class="my-2 text-warning">
            <?php } ?>
            <form method="post">
              <div class="form-floating mb-1">
                <input type="email" name="email" id="email" class="form-control" placeholder="Digite seu E-mail">
                <label for="email">Digite seu E-mail</label>
              </div>
              <div class="form-floating">
                <input type="password" name="senha" id="senha" class="form-control" placeholder="Digite sua senha">
                <label for="senha">Digite sua senha</label>
              </div>
              <hr class="my-2 text-warning">
              <div class="row g-1">
                <div class="col-lg-8">
                  <button type="submit" class="btn btn-warning w-100 rounded-0 rounded-bottom">Entrar</button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="p-2 rounded">
            <div class="fonte-2 fs-4">Ainda não possui conta?</div>
            <hr class="my-2 text-warning">
            <a href="cadastrar" class="btn btn-outline-warning w-100 rounded-0 rounded-bottom">Cadastre-se agora!</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>