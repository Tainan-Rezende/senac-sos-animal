<?php

$erro = "";
$msg = "";

if (isset($_POST['formPost'])) {
  $nomePet = strtolower(mysqli_real_escape_string($conn, $_POST['pet_name']));
  $nomeDono = strtolower(mysqli_real_escape_string($conn, $_POST['pet_dono']));
  $idadePet = $_POST['pet_idade'];
  $descricaoPet = mysqli_real_escape_string($conn, $_POST['pet_descricao']);

  // Verificar se a idade do pet é um número positivo
  if (!is_numeric($idadePet) || $idadePet < 0) {
    $erro = "A idade do pet deve ser um número positivo.";
  } else {
    $upload_folder = "img/mural/";

    $idadePet = mysqli_real_escape_string($conn, $_POST['pet_idade']);

    // Verificar se foram enviados arquivos
    if (!empty(array_filter($_FILES['pet_foto']['name']))) {
      // Inserir os dados na tabela tbl_mural apenas uma vez
      $sqlMural = "INSERT INTO tbl_mural (m_pet, m_idade, m_dono, m_descricao) VALUES ('$nomePet', '$idadePet', '$nomeDono', '$descricaoPet')";

      // Se a idade for um número válido, então podemos inserir os dados na tabela
      if (mysqli_query($conn, $sqlMural)) {
        // Recuperar o ID do registro recém-inserido
        $mural_id = mysqli_insert_id($conn);

        // Percorrer cada arquivo enviado
        foreach ($_FILES['pet_foto']['tmp_name'] as $key => $tmp_name) {
          $file_name = $_FILES['pet_foto']['name'][$key];
          $file_tmp = $_FILES['pet_foto']['tmp_name'][$key];

          // Movendo a imagem para o diretório de uploads
          move_uploaded_file($file_tmp, $upload_folder . $file_name);

          // Inserir a foto na tabela tbl_mural_foto, associando-a ao ID do registro na tabela tbl_mural
          $sqlFoto = "INSERT INTO tbl_mural_foto (mf_foto, m_id) VALUES ('$file_name', $mural_id)";

          // Se ocorrer um erro ao adicionar uma foto à tabela mural_foto, definimos o erro e removemos o registro correspondente na tabela mural
          if (!mysqli_query($conn, $sqlFoto)) {
            $erro = "Erro ao adicionar foto ao mural.";
            mysqli_query($conn, "DELETE FROM tbl_mural WHERE m_id = $mural_id");
            // Interromper o loop
            break;
          }
        }

        // Se não houver erros
        if (!isset($erro)) {
          $msg = "Imagens adicionadas com sucesso ao mural!";
        }
      } else {
        $erro = "Erro ao adicionar entrada ao mural.";
      }
    }
  }
}
?>


<div class="container my-4">
  <div class="row">
    <div class="col-lg-6 mx-auto">
      <p class="mb-0 text-center">
        Poste as imagens favoritas de seu pet para que todos vejam!
      </p>
      <?php if (strlen($msg) > 0) { ?>
        <hr class="my-2 text-warning">
        <div class="alert alert-success mb-0">
          <div class="fs-4">Sucesso!</div>
          <hr class="my-2">
          <?= $msg; ?>
        </div>
      <?php } elseif (strlen($erro) > 0) { ?>
        <hr class="my-2 text-warning">
        <div class="alert alert-danger mb-0">
          <div class="fs-4">Erro!</div>
          <hr class="my-2">
          <?= $erro; ?>
        </div>
      <?php } ?>
      <hr class="my-2 text-warning">
      <div class="row">
        <div class="col-lg-6 mx-auto">
          <button class="btn btn-warning rounded-top-0 hover-button rounded w-100" data-bs-toggle="modal"
            data-bs-target="#modalPostar">Postar no mural</button>
        </div>
      </div>
    </div>
  </div>
  <div class="row g-1 my-4">
    <?php
    // Definir o número de resultados por página
    $resultados_por_pagina = 9;

    // Verificar a página atual
    if (isset($_GET['pagina'])) {
      $pagina_atual = $_GET['pagina'];
    } else {
      $pagina_atual = 1;
    }

    // Calcular o deslocamento para a consulta SQL
    $offset = ($pagina_atual - 1) * $resultados_por_pagina;

    // Consulta SQL modificada para recuperar os resultados de acordo com a página atual e o número de resultados por página
    $sql = "SELECT * FROM tbl_mural WHERE m_status = 'visivel' ORDER BY m_id DESC LIMIT $offset, $resultados_por_pagina";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_array($result)) {
        // Consulta para recuperar todas as imagens associadas ao registro
        $sqlImagens = "SELECT mf_foto FROM tbl_mural_foto WHERE m_id = " . $row['m_id'];
        $resultImagens = mysqli_query($conn, $sqlImagens);

        // Armazena todas as imagens em uma matriz
        $imagens = mysqli_fetch_all($resultImagens, MYSQLI_ASSOC);

        // Se houver imagens associadas
        if (!empty($imagens)) {
          // Escolha uma imagem aleatoriamente
          $imagemAleatoria = $imagens[array_rand($imagens)];
          $imagemUrl = 'img/mural/' . $imagemAleatoria['mf_foto'];
        } else {
          // Caso contrário, exiba uma imagem padrão ou mensagem de erro
          $imagemUrl = 'img/mural/padrao.jpg';
        }
        ?>
        <div class="col-lg-4">
          <div class="border border-warning p-3 rounded  h-100">
            <div class="mural-photo rounded rounded-bottom-0 w-100" style="background-image:url(<?= $imagemUrl; ?>)">
            </div>
            <div class="text-center my-2 fs-4">
              <?php if ($row['m_idade'] !== '') { ?>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="fonte-2">
                    <?= ucfirst($row['m_pet']); ?>
                  </div>
                  <div class="py-0 px-3 rounded-1 bg-warning fs-6">
                    <?= $row['m_idade'] . ($row['m_idade'] == 1 ? ' ano' : ' anos'); ?>
                  </div>
                </div>
              <?php } else { ?>
                <div class="fonte-2">
                  <?= ucfirst($row['m_pet']); ?>
                </div>
              <?php } ?>
            </div>
            <hr class="my-2 text-warning">
            <div class="row">
              <div class="col-lg-6">
                <?php if ($row['m_dono'] !== '') { ?>
                  <div class="d-flex justify-content-center align-items-center h-100 fst-italic">
                    <small>
                      <b>Dono(a): </b>
                      <?= ucfirst($row['m_dono']); ?>
                    </small>
                  </div>
                <?php } ?>
              </div>
              <div class="col-lg-6">
                <button class="btn btn-warning w-100 rounded-1 rounded-top-0 fonte-1" data-bs-toggle="modal"
                  data-bs-target="#viewMural<?= $row['m_id']; ?>">Visualizar</button>
              </div>
            </div>


          </div>
        </div>

        <!-- Modal - Visualizar -->
        <div class="modal fade" id="viewMural<?= $row['m_id']; ?>" tabindex="-1" aria-labelledby="viewMuralLabel"
          aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="viewMuralLabel">
                  <?= ucfirst($row['m_pet']); ?>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body text-center">
                <?php
                // Consulta para recuperar todas as imagens associadas ao registro
                $sqlImagens = "SELECT mf_foto FROM tbl_mural_foto WHERE m_id = " . $row['m_id'];
                $resultImagens = mysqli_query($conn, $sqlImagens);

                // Contar o número de imagens associadas
                $numImagens = mysqli_num_rows($resultImagens);

                // Se houver apenas uma imagem, exiba-a como imagem única
                if ($numImagens == 1) {
                  $imagem = mysqli_fetch_assoc($resultImagens);
                  $imagemUrl = 'img/mural/' . $imagem['mf_foto'];
                  ?>
                  <img src="<?= $imagemUrl ?>" class="img-fluid rounded">
                <?php } else if ($numImagens > 1) { ?>
                    <div id="muralCarrossel<?= $row['m_id']; ?>" class="carousel slide" data-bs-ride="carousel">
                      <div class="carousel-inner">
                        <?php
                        $active = true; // Defina a primeira imagem como ativa
                        while ($imagem = mysqli_fetch_assoc($resultImagens)) {
                          $imagemUrl = 'img/mural/' . $imagem['mf_foto'];
                          ?>
                          <div class="carousel-item <?= $active ? 'active' : '' ?>">
                            <img src="<?= $imagemUrl ?>" class="d-block w-100 rounded" alt="...">
                          </div>
                          <?php
                          $active = false; // Desativar a flag depois da primeira imagem
                        }
                        ?>
                      </div>
                      <button class="carousel-control-prev" type="button" data-bs-target="#muralCarrossel<?= $row['m_id']; ?>"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Anterior</span>
                      </button>
                      <button class="carousel-control-next" type="button" data-bs-target="#muralCarrossel<?= $row['m_id']; ?>"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Próximo</span>
                      </button>
                    </div>
                <?php } else { ?>
                    <p>Nenhuma imagem disponível.</p>
                <?php } ?>

                <?php if (strlen($row['m_descricao']) > 0) { ?>
                  <div class="p-3 rounded border mt-2">
                    <?= $row['m_descricao']; ?>
                  </div>
                <?php } ?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fechar</button>
              </div>
            </div>
          </div>
        </div>

      <?php }
    } else { ?>
      <div class="col-lg-6 mx-auto">
        <div class="alert alert-warning mb-0">
          <p class="mb-0">Ainda não há fotos no mural :(</p>
        </div>
      </div>
    <?php } ?>
  </div>
</div>


<!-- Modal - Postar -->
<div class="modal fade" id="modalPostar" tabindex="-1" aria-labelledby="modalPostarLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalPostarLabel">Postar imagem no mural</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <p class="mb-0">Preencha os campos abaixo para colocar a(s) imagem(ns) do seu pet no mural.</p>
          <p class="mb-0">Os campos com <span class="text-warning">*</span> são obrigatórios.</p>
          <hr class="my-2 text-warning">
          <div class="row g-1">
            <div class="col-lg-4">
              <div class="form-floating">
                <input type="text" name="pet_name" id="pet_name" class="form-control"
                  placeholder="Digite o nome do pet">
                <label for="pet_name">Digite o nome do pet <span class="text-warning">*</span></label>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-floating">
                <input type="text" name="pet_dono" id="pet_dono" class="form-control"
                  placeholder="Digite o nome do dono do pet">
                <label for="pet_dono">Digite o nome do dono do pet</label>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="form-floating">
                <input type="number" name="pet_idade" id="pet_idade" pattern="[0-9]+" class="form-control"
                  placeholder="Digite a idade do pet" min="0" max="30">
                <label for="pet_idade">Digite a idade do pet</label>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="form-floating">
                <input type="file" name="pet_foto[]" id="pet_foto" class="form-control"
                  placeholder="Selecione a(s) foto(s) do seu pet" multiple>
                <label for="pet_foto">Selecione a(s) foto(s) do seu pet <span class="text-warning">*</span></label>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="form-floating">
                <textarea name="pet_descricao" id="pet_descricao" class="form-control"
                  placeholder="Descreva sobre seu pet"></textarea>
                <label for="pet_descricao">Descreva sobre seu pet</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary rounded-top-0" data-bs-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-warning rounded-top-0 w-50" data-bs-dismiss="modal"
            name="formPost">Enviar</button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>