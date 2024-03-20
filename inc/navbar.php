<nav
  class="navbar navbar-expand-xxl bg-black fs-5 top-nav border-bottom border-5 text-center border-warning py-3 navbar-dark fixed-top"
  style="--bs-bg-opacity: .80;" aria-label="Menu Topo S.O.S Animal">
  <div class="container">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menutopo"
      aria-controls="menutopo" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse d-xxl-flex" id="menutopo">
      <a class="navbar-brand col-xxl-3 me-0" href="<?php echo $base_url; ?>">INSTITUTO <span
          class="text-warning">S.O.S</span>
        ANIMAL.</a>
      <ul class="navbar-nav col-xxl-6 justify-content-lg-center">
        <li class="nav-item">
          <a class="nav-link<?php if (!isset($_GET['p']) || $_GET['p'] === "inicio") {
            echo " link-warning";
          } ?>" href="<?php echo $base_url; ?>">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?php if (isset($_GET['p']) && $_GET['p'] === "doe") {
            echo " link-warning";
          } ?>" href="<?php echo $base_url; ?>/doe">Faça uma doação</a>
        </li>
        <li class="nav-item  px-4">
          <a class="nav-link fw-bold link-danger<?php if (isset($_GET['p']) && $_GET['p'] === "sos") {
            echo " link-warning";
          } ?>" href="<?php echo $base_url; ?>/sos">S.O.S</a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?php if (isset($_GET['p']) && $_GET['p'] === "adote") {
            echo " link-warning";
          } ?>" href="<?php echo $base_url; ?>/adote">Adote Um animal</a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?php if (isset($_GET['p']) && $_GET['p'] === "contato") {
            echo " link-warning";
          } ?>" href="<?php echo $base_url; ?>/contato">Contato</a>
        </li>
      </ul>

      <div class="d-xxl-flex col-xxl-3 justify-content-xxl-end">
        <?php if (isset($_SESSION['usuario_id']) && isset($_SESSION['admin'])) { ?>
          <a href="<?php echo $base_url; ?>/mural" class="btn btn-warning rounded-0 me-1">mural</a>
          <a href="<?php echo $base_url; ?>/painel" class="btn btn-warning rounded-0 px-5">Painel</a>
          <a href="<?php echo $base_url; ?>/sair" class="btn btn-outline-warning rounded-0 px-5 ms-1">Sair</a>
        <?php } elseif (isset($_SESSION['admin'])) { ?>
          <a href="<?php echo $base_url; ?>/mural" class="btn btn-warning rounded-0 me-1">mural</a>
          <a href="<?php echo $base_url; ?>/login" class="btn btn-warning rounded-0">Login / Cadastro</a>
        <?php } else { ?>
          <a href="<?php echo $base_url; ?>/mural" class="btn btn-warning rounded-0">mural</a>
        <?php } ?>
      </div>
    </div>
  </div>
</nav>