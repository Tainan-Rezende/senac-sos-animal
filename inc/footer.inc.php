<footer class="bg-black border-top border-5 border-warning py-4 text-white mt-2">
  <div class="container">
    <div class="row">

      <div class="col-xl-3 col-lg-6 text-center">
        <div class="d-flex justify-content-center align-items-center flex-column h-100">
          <img src="img/logo.jpeg" alt="Logotipo" class="rounded-circle img-fluid w-50">
          <div class="fs-4 fonte-2 pt-4">INSTITUTO <span class="text-warning">S.O.S</span> ANIMAL</div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-6">
        <div class="fs-4 text-warning">Missão</div>
        <hr class="my-2 text-warning">
        <p class="mb-0">
          Acolher animais com carinho e dedicação, a fim de promover um novo lar para aqueles que se encontram em
          situações de maus-tratos ou abandono.
        </p>
        <div class="fs-4 text-warning">Visão</div>
        <hr class="my-2 text-warning">
        <p class="mb-0">
          Ser reconhecida como ONG de maior prestígio e acolhimento de animais no vale do paraíba, fortalecendo
          parcerias e incentivando a causa animal como principal para ofertar o bem-estar de animais de rua, situações
          de maus-tratos e abandono.
        </p>
      </div>
      <div class="col-xl-3 col-lg-6">
        <div class="fs-4 text-warning">Valores</div>
        <hr class="my-2 text-warning">
        <div class="valores p-3">
          <div><img src="img/gato.png" class="img-fluid" width="25" alt="Gatinho"></div>
          <div>Acolher com amor</div>
        </div>
        <hr class="my-2 text-warning">
        <div class="valores p-3">
          <div><img src="img/shiba-inu.png" class="img-fluid" width="25" alt="Cachorrinho"></div>
          <div>Preservação da Vida animal</div>
        </div>
        <hr class="my-2 text-warning">
        <div class="valores p-3">
          <div><img src="img/gato.png" class="img-fluid" width="25" alt="Gatinho"></div>
          <div>Amor, carinho e dedicação</div>
        </div>
        <hr class="my-2 text-warning">
        <div class="valores p-3">
          <div><img src="img/shiba-inu.png" class="img-fluid" width="25" alt="Cachorrinho"></div>
          <div>O Bem-estar animal é prioridade</div>
        </div>
        <hr class="my-2 text-warning">
      </div>
      <div class="col-xl-3 col-lg-6">
        <div class="fs-4 text-warning">Links rápidos</div>
        <hr class="my-2 text-warning">
        <div class="valores p-1">
          <div>
            <img src="img/patas-2.png" alt="Patinhas" class="img-fluid" width="25">
          </div>
          <div>
            <a href="<?= $base_url; ?>" class="link-warning text-decoration-none">Página Inicial</a>
          </div>
        </div>
        <hr class="my-2 text-warning">
        <div class="valores p-1">
          <div>
            <img src="img/patas-2.png" alt="Patinhas" class="img-fluid" width="25">
          </div>
          <div>
            <a href="<?= $base_url; ?>/doe" class="link-warning text-decoration-none">Faça uma doação</a>
          </div>
        </div>
        <hr class="my-2 text-warning">
        <div class="valores p-1">
          <div>
            <img src="img/patas-2.png" alt="Patinhas" class="img-fluid" width="25">
          </div>
          <div>
            <a href="<?= $base_url; ?>/sos" class="link-danger text-decoration-none fw-bold">S.O.S</a>
          </div>
        </div>
        <hr class="my-2 text-warning">
        <div class="valores p-1">
          <div>
            <img src="img/patas-2.png" alt="Patinhas" class="img-fluid" width="25">
          </div>
          <div>
            <a href="<?= $base_url; ?>/adote" class="link-warning text-decoration-none">Adote um animal</a>
          </div>
        </div>
        <hr class="my-2 text-warning">
        <div class="valores p-1">
          <div>
            <img src="img/patas-2.png" alt="Patinhas" class="img-fluid" width="25">
          </div>
          <div>
            <a href="<?= $base_url; ?>/contato" class="link-warning text-decoration-none">Contato</a>
          </div>
        </div>
        <hr class="my-2 text-warning">
        <div class="valores p-1">
          <div>
            <img src="img/patas-2.png" alt="Patinhas" class="img-fluid" width="25">
          </div>
          <div>
            <a href="<?= $base_url; ?>/mural" class="link-warning text-decoration-none">Mural</a>
          </div>
        </div>
        <hr class="my-2 text-warning">
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12 text-center mt-2">
        <hr class="my-2">
        <p class="mb-0 pt-3">
          &copy;
          <?php echo date('Y'); ?>
          <?= $siteConfig['titulo']; ?><a href="?init_admin" class="text-decoration-none text-white">.</a> Todos os
          direitos
          reservados<a href="sair" class="text-decoration-none text-white">.</a>
        </p>
      </div>
    </div>
  </div>
</footer>