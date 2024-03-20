<?php
// Verifica se há sessão iniciada
if (isset($_SESSION['usuario_id'])) {
  // Redireciona para a página do painel
  header("Location: painel");
  exit();
}

if ($siteConfig['vag_registro'] > 0) {
  // Verifica se a requisição é do tipo POST
  if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Recebe os dados do formulário
    $nome = mysqli_real_escape_string($conn, strtolower($_POST['nome']));
    $sobrenome = mysqli_real_escape_string($conn, strtolower($_POST['sobrenome']));
    $email = mysqli_real_escape_string($conn, strtolower($_POST['email']));
    $senha = $_POST['senha'];
    $confirma = $_POST['confirmar'];

    // Verifica se os campos não estão vazios
    if (empty($nome) || empty($sobrenome) || empty($email) || empty($senha) || empty($confirma)) {
      $erro = "Erro: Preencha todos os campos.";
    } elseif ($senha != $confirma) {
      // Verifica se a senha e confirmação de senha são iguais
      $erro = "Erro: Senhas cadastradas não estão iguais.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      // Verifica se o email digitado é válido
      $erro = "Erro: E-mail inválido.";
    } else {
      // Gera uma criptografia segura da senha
      $senhaHash = password_hash($senha, PASSWORD_BCRYPT);

      // Verifica se e-mail e CPF já existe
      $checkExiste = "SELECT COUNT(*) as total FROM tbl_usuario WHERE email = '$email'";
      $existeResult = mysqli_query($conn, $checkExiste);
      $existe = mysqli_fetch_assoc($existeResult);

      // Se retornar maior que 0, o email já existe e informa o erro
      if ($existe['total'] > 0) {
        $erro = "Erro: E-mail informado já existe no banco de dados.";
      } else {
        // Processa a imagem
        $imagemNome = uniqid() . '_' . $_FILES['imagem_perfil']['name'];
        $imagemTemp = $_FILES['imagem_perfil']['tmp_name'];
        $imagemTamanho = $_FILES['imagem_perfil']['size'];

        // Diretório para salvar as imagens
        $diretorio = "img/usuarios/";

        // Verifica se uma imagem foi selecionada
        if ($imagemTamanho > 0) {
          // Move a imagem para o diretório de destino
          if (move_uploaded_file($imagemTemp, $diretorio . $imagemNome)) {
            // SQL para a inserção do usuário no banco de dados com o caminho da imagem
            $fotoCaminho = $diretorio . $imagemNome;
            $sqlCadastrar = "INSERT INTO tbl_usuario (nome, sobrenome, email, senha, foto) VALUES ('$nome', '$sobrenome', '$email', '$senhaHash', '$fotoCaminho')";
            $resultCadastrar = mysqli_query($conn, $sqlCadastrar);

            // Caso resultado da inserção retorne verdadeiro (true), informa que o cadastro foi realizado com sucesso
            if ($resultCadastrar) {
              $msg = "Cadastro realizado com sucesso!";
            } else {
              // caso retorne falso (false), informa que houve um erro e qual erro foi
              $erro = "Erro ao cadastrar usuário: " . mysqli_error($conn);
            }
          } else {
            // Se falhar ao mover a imagem, informa o erro
            $erro = "Erro: Falha ao mover a imagem para o diretório.";
          }
        } else {
          // Se nenhum arquivo foi enviado, informa o erro
          $erro = "Erro: Selecione uma imagem de perfil.";
        }
      }
    }
  }
  ?>
  <div class="container my-5">
    <div class="row g-1">
      <div class="col-lg-9 mx-auto">
        <div class="row g-2">
          <div class="col-lg-8">
            <div class="border border-warning rounded p-3">
              <p class="mb-0">Preencha todos os campos abaixo para realizar o cadastro.</p>
              <hr class="my-2 text-warning">
              <?php
              if (strlen($erro) > 0) { ?>
                <div class="alert alert-danger mb-0">
                  <h4>Erro!</h4>
                  <hr class="my-2">
                  <?= $erro; ?>
                </div>
                <hr class="my-2 text-warning">
              <?php } else if (strlen($msg) > 0) { ?>
                  <div class="alert alert-success mb-0">
                    <h4>Sucesso!</h4>
                    <hr class="my-2">
                  <?= $msg; ?>
                  </div>
                  <hr class="my-2 text-warning">
                  <meta http-equiv="refresh" content="3; url=login">
              <?php } ?>

              <form method="POST" enctype="multipart/form-data">
                <div class="row g-1">
                  <div class="col-lg-6">
                    <div class="form-floating">
                      <input type="text" name="nome" id="nome" placeholder="Digite seu nome" class="form-control"
                        required>
                      <label for="nome">Digite seu nome</label>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-floating">
                      <input type="text" name="sobrenome" id="sobrenome" placeholder="Digite seu sobrenome"
                        class="form-control" required>
                      <label for="sobrenome">Digite seu sobrenome</label>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-floating">
                      <input type="email" name="email" id="email" placeholder="Digite seu email" class="form-control"
                        required>
                      <label for="email">Digite seu email</label>
                    </div>
                  </div>
                  <div class="col-lg-5">
                    <div class="form-floating">
                      <input type="password" name="senha" id="senha" placeholder="Digite sua senha" class="form-control"
                        required>
                      <label for="senha">Digite sua senha</label>
                    </div>
                  </div>
                  <div class="col-lg-5">
                    <div class="form-floating">
                      <input type="password" name="confirmar" id="confirmar" placeholder="Digite sua senha novamente"
                        class="form-control" required>
                      <label for="confirmar">Digite sua senha novamente</label>
                    </div>
                  </div>
                  <div class="col-lg-2 d-flex justify-content-center align-items-center">
                    <div class="form-check mb-0">
                      <input type="checkbox" name="visualizar" id="visualizar" class="form-check-input">
                      <label for="visualizar">Visualizar</label>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-floating">
                      <input type="file" name="imagem_perfil" id="imagem_perfil" class="form-control" accept="image/*"
                        required>
                      <label for="imagem_perfil">Escolha uma imagem de perfil</label>
                    </div>
                  </div>

                  <hr class="my-2 text-danger">
                  <div class="col-lg-7">
                  </div>
                  <div class="col-lg-5">
                    <div class="d-flex justify-content-end">
                      <button type="submit" class="btn btn-warning w-100 rounded-0 rounded-bottom">Cadastrar</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="fonte-2 fs-4">
              Já possuí conta?
            </div>
            <hr class="my-2 text-warning">
            <a href="login" class="btn btn-outline-warning w-100 rounded-0 rounded-bottom">Entrar agora</a>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } else { ?>
<div class="container my-3">
  <div class="row g-1">
    <div class="col-lg-6 mx-auto">
      <div class="border border-warning p-3 rounded">
        <div class="alert alert-warning mb-0">
          <div class="fs-4 fw-bold">Não há vagas</div>
          <hr class="my-2">
          <p class="mb-0">
            Não há vagas disponíveis para cadastro.
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>