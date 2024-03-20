<?php if (!isset($_GET['p']) || $_GET['p'] === "inicio") { ?>
  <section class="title">
    <div class="d-flex justify-content-center align-items-center h-100 w-100 bg-black text-white text-center"
      style="--bs-bg-opacity: .60;">
      <div class="display-3">Levando a esperança<br>de um <span class="text-warning text-uppercase fw-bold">novo
          lar</span>.
      </div>
    </div>
  </section>
<?php } else { ?>
  <section class="titleOut fonte-2">
    <div class="d-flex justify-content-center align-items-end pb-5 h-100 w-100 bg-black text-white text-center"
      style="--bs-bg-opacity: .70;">
      <?php
      // Página atual
      $page = isset($_GET['p']) && array_key_exists($_GET['p'], $pageMappings) ? $_GET['p'] : $defaultPage;

      // Título da página
      $pageTitle = $pageTitles[$page];

      // Exibição do título no cabeçalho
      echo '<h1 class="fonte-1 pb-5">' . $pageTitle . '</h1>';

      ?>
    </div>
  </section>
<?php } ?>