<div class="container">
  <div class="row">
    <div class="col-lg-8 col-md-12 mx-auto py-5">
      <div class="text-center">
        <p>
          Estamos emocionados por você considerar dar um lar amoroso a um amigo peludo que precisa desesperadamente de
          carinho e segurança. Aqui, na nossa Página de Adoção, cada história tem um final feliz esperando para ser
          escrito, e é você quem pode fazer a diferença.
        </p>

        <p>
          Ao escolher a adoção, você não apenas ganha um companheiro leal, mas também salva uma vida. Nossos animais
          resgatados, cheios de gratidão e amor, aguardam ansiosamente a chance de serem parte da sua história. Explore
          nossos adoráveis candidatos à adoção e descubra como um simples gesto pode trazer alegria e felicidade a ambos
          os lados.
        </p>
        <p>
          Juntos, vamos fazer a diferença na vida de um animal e encher nossos lares de alegria. Comece a jornada de
          adoção hoje e descubra o inestimável presente de amor que um animal de estimação pode trazer à sua vida.
        </p>
      </div>
    </div>

    <div class="col-lg-8 col-md-10 col-sm-12 mx-auto pt-3">
      <div class="display-6 fonte-2 text-center">
        Pets
      </div>
      <hr class="my-2 text-warning">
      <p class="mb-0">
        Adote um animal e receba amor incondicional. Nossos queridos estão te aguardando.
      </p>
      <hr class="my-2 text-warning">
      <div class="row">
        <div class="col-lg-12 bg-warning p-2 rounded">
          <div class="row g-1">
            <?php
            $sql = "SELECT * FROM tbl_adote WHERE a_status = 'ativo' ORDER BY a_id DESC";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_array($result)) {
                // Consulta para buscar imagens do pet
                $sql_imagens = "SELECT f_caminho FROM tbl_adote_fotos WHERE a_id = " . $row['a_id'];
                $result_imagens = mysqli_query($conn, $sql_imagens);

                // Se houver imagens disponíveis
                if (mysqli_num_rows($result_imagens) > 0) {
                  // Se houver apenas uma imagem, mostra essa imagem
                  if (mysqli_num_rows($result_imagens) == 1) {
                    $imagem = mysqli_fetch_array($result_imagens)['f_caminho'];
                  } else {
                    // Se houver mais de uma imagem, busca uma imagem aleatória
                    $imagens_array = array();
                    while ($img_row = mysqli_fetch_array($result_imagens)) {
                      $imagens_array[] = $img_row['f_caminho'];
                    }
                    $imagem = $imagens_array[array_rand($imagens_array)];
                  }
                } else {
                  // Se não houver imagens disponíveis, use uma imagem padrão ou deixe em branco
                  $imagem = ""; // ou defina uma imagem padrão
                }

                // Consulta para buscar a categoria do pet
                $sql_categoria = "SELECT c_categoria FROM tbl_pet WHERE c_id = " . $row['c_id'];
                $result_categoria = mysqli_query($conn, $sql_categoria);
                $categoria = mysqli_fetch_array($result_categoria)['c_categoria'];

                // Exibição dos dados do pet
                ?>
                <div class="col-lg-6">
                  <div class="adotar text-light rounded" style="background-image: url('<?php echo $imagem; ?>');">
                    <div class="bg-black rounded h-100 p-3" style="--bs-bg-opacity: 0.50;">
                      <span class="fonte-1 text-warning fs-3">
                        <?= ucfirst($row['a_nome']); ?>
                      </span>
                      <hr class="my-1 text-warning">
                      <p class="mb-0">
                        <i class="bi bi-info-square-fill text-warning"></i>
                        <?= ucfirst($categoria); ?>
                      </p>
                      <p class="mb-0">
                        <i class="bi bi-suit-heart-fill text-danger"></i>
                        <?= ucfirst($row['a_idade']); ?>
                      </p>
                      <p class="mb-0">
                        <i class="bi bi-gender-ambiguous text-warning"></i>
                        <?= ucfirst($row['a_sexo']); ?>
                      </p>
                      <hr class="my-1 text-warning">
                      <a href="#" data-bs-toggle="modal" data-bs-target="#petConheca<?= $row['a_id']; ?>"
                        class="btn btn-warning rounded-top-0 rounded-bottom-1 w-100">Conheça</a>
                    </div>
                  </div>
                </div>

                <!-- MODAL CONHEÇA O PET -->
                <div class="modal fade" id="petConheca<?= $row['a_id']; ?>" tabindex="-1" aria-labelledby="petConhecaLabel"
                  aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="petConhecaLabel">
                          <?= ucfirst($row['a_nome']); ?>
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="bg-warning p-3 rounded-1 mb-1">
                          <div class="p-3 bg-dark text-white rounded-1">
                            <div class="row">
                              <div class="col-lg-6 border-end border-warning">
                                <p class="mb-0"><i class="bi bi-star-fill text-warning"></i>
                                  <?= ucfirst($row['a_nome']); ?>
                                </p>
                                <p class="mb-0">
                                  <i class="bi bi-suit-heart-fill text-danger"></i>
                                  <?= ucfirst($row['a_idade']); ?>
                                </p>
                              </div>
                              <div class="col-lg-6">
                                <p class="mb-0">
                                  <i class="bi bi-info-square-fill text-warning"></i>
                                  <?= ucfirst($categoria); ?>
                                </p>
                                <p class="mb-0">
                                  <i class="bi bi-gender-ambiguous text-warning"></i>
                                  <?= ucfirst($row['a_sexo']); ?>
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                        <?php
                        // Consulta para obter as imagens do pet
                        $pet_id = $row['a_id'];
                        $sql_imagens = "SELECT * FROM tbl_adote_fotos WHERE a_id = $pet_id";
                        $result_imagens = mysqli_query($conn, $sql_imagens);
                        $num_imagens = mysqli_num_rows($result_imagens);

                        if ($num_imagens > 1) { // Se houver mais de uma imagem, use o carrossel
                          ?>
                          <div id="carrosselConhecaPet<?= $row['a_id']; ?>" class="carousel slide">
                            <div class="carousel-indicators">
                              <?php for ($i = 0; $i < $num_imagens; $i++) { ?>
                                <button type="button" data-bs-target="#carrosselConhecaPet<?= $row['a_id']; ?>"
                                  data-bs-slide-to="<?= $i ?>" <?= $i === 0 ? 'class="active"' : '' ?>
                                  aria-label="Slide <?= $i + 1 ?>"></button>
                              <?php } ?>
                            </div>
                            <div class="carousel-inner">
                              <?php $index = 0;
                              while ($imagem = mysqli_fetch_assoc($result_imagens)) { ?>
                                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                  <img src="<?= $imagem['f_caminho'] ?>" class="rounded d-block w-100">
                                </div>
                                <?php $index++;
                              } ?>
                            </div>
                            <button class="carousel-control-prev" type="button"
                              data-bs-target="#carrosselConhecaPet<?= $row['a_id']; ?>" data-bs-slide="prev">
                              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                              <span class="visually-hidden">Anterior</span>
                            </button>
                            <button class="carousel-control-next" type="button"
                              data-bs-target="#carrosselConhecaPet<?= $row['a_id']; ?>" data-bs-slide="next">
                              <span class="carousel-control-next-icon" aria-hidden="true"></span>
                              <span class="visually-hidden">Próximo</span>
                            </button>
                          </div>
                        <?php } else if ($num_imagens === 1) { // Se houver apenas uma imagem, mostrar como <img> tag ?>
                          <?php $imagem = mysqli_fetch_assoc($result_imagens); ?>
                            <img src="<?= $imagem['f_caminho'] ?>" class="rounded d-block w-100">
                        <?php } else { // Se não houver imagens disponíveis ?>
                            <p>Nenhuma imagem disponível.</p>
                        <?php } ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Fechar</button>
                        <a data-bs-toggle="modal" data-bs-target="#tenhoInteresse" class="btn btn-warning rounded-0">Tenho
                          interesse</a>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="tenhoInteresse" tabindex="-1" aria-labelledby="tenhoInteresseLabel"
                  aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="tenhoInteresseLabel">Tenho interesse</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="bg-warning p-2 rounded-1">
                          <div class="bg-white p-2 rounded-1">
                            <p class="mb-0">Ficamos felizes que você possui interesse em adotar o(a)
                              <?= ucfirst($row['a_nome']); ?>, porém agora para continuar com o processo você deverá
                              preencher
                              um formulário e em breve retornaremos contato.
                            </p>
                          </div>
                        </div>
                        <div class="row mt-1 g-1">
                          <div class="col-lg-6">
                            <div class="border border-warning p-3 rounded-1">
                              <img src="img/qr-adocao-animal.png" alt="QR Code Adoção animal" class="img-fluid">
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="border border-warning p-3 rounded-1">
                              <p>Caso esteja havendo problemas com o QR Code, você pode clicar no botão abaixo</p>
                              <p class="mb-0">
                                <a href="https://forms.gle/sMHCNHuYPMSaLnbW6" target="_blank"
                                  class="btn btn-warning rounded-0 w-100">Ir para o formulário</a>
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                      </div>
                    </div>
                  </div>
                </div>

              <?php }
            } else { ?>
              <div class="col-lg-12 mx-auto">
                <div class="alert alert-warning text-center mb-0">
                  <p class="mb-0">Ainda não há nenhum animal para adoção.</p>
                </div>
              </div>
            <?php } ?>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>