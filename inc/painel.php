<?php

// Use sua função para obter os dados do usuário
$usuario = getUsuarioByID($conn);

if ($usuario) {
  ?>
  <div class="container my-4">
    <div class="row">
      <div class="col-lg-8 mx-auto mb-2">
        <div class="border rounded p-3">
          <div class="d-flex justify-content-between align-items-center">
            <div class="fs-4 fonte-2">
              Olá,
              <?= ucfirst($usuario['nome']); ?>.
            </div>
          </div>
          <hr class="my-2 text-warning">
          <?php require_once("painel.info.php"); ?>
        </div>
      </div>
    </div>
  </div>

<?php } else { ?>
  <div class="container">
    <div class="row">
      <div class="col-lg-8 mx-auto">
        <div class="border rounded p-3">
          <div class="alert alert-danger mb-0">
            <h4>Erro!</h4>
            <hr class="my-2">
            <p class="mb-0">Você deve estar conectado para acessar essa página.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <meta http-equiv="refresh" content="3; url=?p=login">
<?php } ?>