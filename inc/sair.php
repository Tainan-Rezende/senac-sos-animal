<?php

if (isset($_SESSION['usuario_id']) || isset($_SESSION['admin'])) {
  if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Destrua todas as variáveis de sessão
    $_SESSION = array();

    // Destrua a sessão
    session_destroy();

    // Redirecione para a página de login ou qualquer outra página desejada
    header("Location: " . $base_url);
    exit();
  }
  ?>
  <div class="container my-5">
    <div class="row">
      <div class="col-lg-6 mx-auto">
        <div class="rounded border p-3">
          <div class="alert alert-danger mb-0">
            <h4>Sair</h4>
            <hr class="my-2">
            <p class="mb-0">
              Você tem certeza que deseja sair de sua conta?
            </p>
          </div>
          <hr class="my-2">
          <form method="post">
            <div class="row">
              <div class="col-lg-4">
                <button type="submit" class="btn btn-outline-secondary w-100">Sair agora</button>
              </div>
              <div class="col-lg-6 ms-auto">
                <a href="painel" class="btn btn-danger w-100">Voltar</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>
<?php } else { ?>
  <div class="container my-5">
    <div class="row">
      <div class="col-lg-6 mx-auto">
        <div class="rounded border p-3">
          <div class="alert alert-danger mb-0">
            Você não tem uma sessão ativa para sair.
          </div>
        </div>
      </div>
    </div>
  </div>

<?php } ?>