<?php
// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Verifica se todos os campos obrigatórios estão presentes no POST
  if (empty($_POST['a_nome']) || empty($_POST['a_idade']) || empty($_POST['a_sexo']) || empty($_POST['petCategoria']) || empty($_POST['petRaca'])) {
    echo "Por favor, preencha todos os campos obrigatórios.";
    exit();
  }

  // Verifica se o usuário enviou imagens
  if (empty($_FILES['a_img']['name'][0])) {
    echo "Por favor, selecione pelo menos uma imagem do pet.";
    exit();
  }

  // Obtém os valores dos campos do formulário
  $a_nome = mysqli_real_escape_string($conn, $_POST['a_nome']);
  $a_idade = mysqli_real_escape_string($conn, $_POST['a_idade']);
  $a_sexo = mysqli_real_escape_string($conn, $_POST['a_sexo']);
  $pet_categoria = mysqli_real_escape_string($conn, $_POST['petCategoria']);
  $pet_raca = mysqli_real_escape_string($conn, $_POST['petRaca']);

  // Convertendo para minúsculas
  $pet_categoria = strtolower($pet_categoria);

  // Consulta o ID da categoria no banco de dados
  $stmt_categoria = $conn->prepare("SELECT c_id FROM tbl_pet WHERE c_categoria = ?");
  $stmt_categoria->bind_param("s", $pet_categoria);
  $stmt_categoria->execute();
  $result_categoria = $stmt_categoria->get_result();

  if ($result_categoria->num_rows > 0) {
    $row_categoria = $result_categoria->fetch_assoc();
    $c_id = $row_categoria['c_id'];

    // Consulta o ID da raça no banco de dados
    $stmt_raca = $conn->prepare("SELECT r_id FROM tbl_raca WHERE r_nome = ? AND c_id = ?");
    $stmt_raca->bind_param("si", $pet_raca, $c_id);
    $stmt_raca->execute();
    $result_raca = $stmt_raca->get_result();

    if ($result_raca->num_rows > 0) {
      $row_raca = $result_raca->fetch_assoc();
      $r_id = $row_raca['r_id'];

      // Executa a inserção na tabela tbl_adote
      $stmt = $conn->prepare("INSERT INTO tbl_adote (a_nome, a_idade, a_sexo, c_id, r_id) VALUES (?, ?, ?, ?, ?)");
      $stmt->bind_param("sssss", $a_nome, $a_idade, $a_sexo, $c_id, $r_id);
      if ($stmt->execute()) {
        // Obtém o ID do animal inserido
        $a_id = $conn->insert_id;

        // Prepara e executa a inserção das imagens na tabela tbl_adote_foto
        $stmt_foto = $conn->prepare("INSERT INTO tbl_adote_fotos (a_id, f_caminho) VALUES (?, ?)");
        $stmt_foto->bind_param("is", $a_id, $f_caminho);

        $upload_path = "img/adote/"; // Caminho para onde salvar as imagens
        foreach ($_FILES['a_img']['name'] as $key => $name) {
          $file_tmp = $_FILES['a_img']['tmp_name'][$key];
          $file_name = basename($name);
          move_uploaded_file($file_tmp, $upload_path . $file_name);
          $f_caminho = $upload_path . $file_name;
          $stmt_foto->execute();
        }
        $stmt_foto->close();

        // Redireciona para a página de sucesso ou exibe uma mensagem
        $msg = "Cadastro de doação animal realizado com sucesso!";
      } else {
        $erro = "Erro ao cadastrar o animal.";
      }
    } else {
      echo "Raça inválida para a categoria selecionada.";
      exit();
    }
    $stmt_raca->close();
  } else {
    echo "Categoria inválida: " . $pet_categoria;
    exit();
  }
  $stmt_categoria->close();
}
?>

<div class="container">
  <div class="row">
    <div class="col-lg-8 col-md-12 text-center mx-auto py-5">
      <p>
        Aqui, a compaixão se transforma em ação, e cada doação é uma promessa de esperança para nossos amigos de quatro
        patas. Ao contribuir para o S.O.S Animal, você se junta a uma comunidade dedicada a salvar vidas, proporcionar
        conforto e construir futuros felizes para animais em situações vulneráveis.
      </p>
      <p class="mb-0">
        Cada centavo doado é um passo em direção a histórias de resgate, cura e amor. Juntos, somos a voz para aqueles
        que
        não podem falar e os guardiões dos que precisam de uma segunda chance. Faça parte desta jornada de compaixão e
        solidariedade - sua doação faz toda a diferença.
      </p>

    </div>
  </div>

  <div class="row">
    <div class="col-lg-8 mx-auto">
      <?php if (strlen($msg) > 0) { ?>
        <hr class="my-2 text-warning">
        <div class="alert alert-success mb-1">
          <div class="fs-4">Sucesso</div>
          <hr class="my-2">
          <?= $msg; ?>
        </div>
        <hr class="my-2 text-warning">
      <?php } elseif (strlen($erro) > 0) { ?>
        <hr class="my-2 text-warning">
        <div class="alert alert-danger mb-1">
          <div class="fs-4">Erro</div>
          <hr class="my-2">
          <?= $erro; ?>
        </div>
        <hr class="my-2 text-warning">
      <?php } ?>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-8 col-md-12 mx-auto">
      <div class="text-center">
        Você pode escolher uma das opções abaixo para doar.
      </div>
      <div class="text-bg-warning p-3 rounded mt-2">
        <p class="mb-0 fonte-2 fs-5">
          <b>Doe um animal</b>
        </p>
        <hr class="my-2">
        <p class="mb-0">
          Você também pode colocar alguns animais no site para adotantes, portanto é só combinar o acolhimento do cão ou
          gato.
        </p>
        <hr class="my-2">
        <div class="text-center fonte-2">
          <button class="btn btn-light rounded-0" data-bs-toggle="modal" data-bs-target="#doarAnimal">CADASTRAR DOAÇÃO
            ANIMAL</button>
        </div>
      </div>
      <div class="text-bg-dark p-3 rounded mt-1">
        <p class="mb-0 fonte-2 fs-5">
          <b>Doação via PIX</b>
          <hr class="my-2">
        </p>
        <p class="mb-0">
          Para ajudar, então você pode fazer uma transferência via PIX, com a chave de e-mail ou celular abaixo.
        </p>
        <hr class="my-2">
        <ul class="list-group list-group-flush" data-bs-theme="dark">
          <li class="list-group-item"><b>E-mail: </b> doe@sosanimal.org</li>
          <li class="list-group-item"><b>Celular: </b> +55 (12) 99142-2047</li>
        </ul>
      </div>
      <div class="text-bg-warning p-3 rounded mt-1">
        <p class="mb-0 fonte-2 fs-5">
          <b>Doação recorrente</b>
        </p>
        <hr class="my-2">
        <p class="mb-0">
          Para contribuir de forma recorrente, então é só clicar em assinar abaixo no valor desejado.
        </p>
        <hr class="my-2">

        <!-- DOAÇÃO RECORRENTE 1 -->
        <div class="doacao text-white w-100 rounded" style="background-image: url(img/animais/dog-3.jpg);">
          <div class="bg-black rounded" style="--bs-bg-opacity: 0.70;">
            <div class="container py-5">
              <div class="row py-5">
                <div class="col-lg-8 text-center fonte-2 fs-2 mx-auto py-5">
                  R$ 25,00 por mês
                  <hr class="my-2">
                  <a data-bs-toggle="modal" data-bs-target="#doacaoRecorrente25"
                    class="btn bg-light text-white w-100 rounded-0 bg-opacity-25">Assinar Doação</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- DOAÇÃO RECORRENTE 2 -->
        <div class="doacao text-white w-100 rounded mt-1" style="background-image: url(img/animais/dog-6.jpg);">
          <div class="bg-black rounded" style="--bs-bg-opacity: 0.70;">
            <div class="container py-5">
              <div class="row py-5">
                <div class="col-lg-8 text-center fonte-2 fs-2 mx-auto py-5">
                  R$ 50,00 por mês
                  <hr class="my-2">
                  <a data-bs-toggle="modal" data-bs-target="#doacaoRecorrente50"
                    class="btn bg-light text-white w-100 rounded-0 bg-opacity-25">Assinar Doação</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- DOAÇÃO RECORRENTE 3 -->
        <div class="doacao text-white w-100 rounded mt-1" style="background-image: url(img/animais/dog-8.jpg);">
          <div class="bg-black rounded" style="--bs-bg-opacity: 0.70;">
            <div class="container py-5">
              <div class="row py-5">
                <div class="col-lg-8 text-center fonte-2 fs-2 mx-auto py-5">
                  R$ 100,00 por mês
                  <hr class="my-2">
                  <a data-bs-toggle="modal" data-bs-target="#doacaoRecorrente100"
                    class="btn bg-light text-white w-100 rounded-0 bg-opacity-25">Assinar Doação</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- DOAÇÃO RECORRENTE 4 -->
        <div class="doacao text-white w-100 rounded mt-1" style="background-image: url(img/animais/cat-1.jpg);">
          <div class="bg-black rounded" style="--bs-bg-opacity: 0.70;">
            <div class="container py-5">
              <div class="row py-5">
                <div class="col-lg-8 text-center fonte-2 fs-2 mx-auto py-5">
                  R$ 200,00 por mês
                  <hr class="my-2">
                  <a data-bs-toggle="modal" data-bs-target="#doacaoRecorrente200"
                    class="btn bg-light text-white w-100 rounded-0 bg-opacity-25">Assinar Doação</a>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<?php if (isset($_SESSION['admin'])) { ?>
  <!-- Modal - Doar animal ADMIN -->
  <div class="modal fade" id="doarAnimal" tabindex="-1" aria-labelledby="doarAnimalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="doarAnimalLabel">Doar animal</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <p class="mb-0">Preencha os campos abaixo para colocar um animal para adoção.</p>
            <hr class="my-2 text-warning">
            <div class="row g-1">
              <div class="col-lg-6">
                <div class="form-floating">
                  <input type="text" name="a_nome" id="a_nome" class="form-control"
                    placeholder="Digite o nome do pet para adoção">
                  <label for="a_nome">Digite o nome do pet para adoção</label>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-floating">
                  <select name="a_idade" id="a_idade" class="form-select">
                    <option selected>Selecione a idade do Pet</option>
                    <option value="filhote">Filhote</option>
                    <option value="adulto">Adulto</option>
                    <option value="idoso">Idoso</option>
                  </select>
                  <label for="a_idade">Selecione a idade do Pet</label>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-floating">
                  <select name="a_sexo" id="a_sexo" class="form-select">
                    <option selected>Selecione o sexo do Pet</option>
                    <option value="macho">Macho</option>
                    <option value="femea">Femea</option>
                  </select>
                  <label for="a_idade">Selecione o sexo do Pet</label>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-floating">
                  <input type="text" name="petCategoria" list="datalistPets" id="petCategoria" class="form-control"
                    placeholder="Qual será o pet" onchange="atualizarRacas()">
                  <label for="petCategoria">Qual será o Pet</label>
                  <datalist id="datalistPets">
                    <option value="Cachorro">
                    <option value="Gato">
                  </datalist>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-floating">
                  <input type="text" name="petRaca" id="petRaca" list="datalistRaca" class="form-control"
                    placeholder="Selecione a raça">
                  <label for="petRaca">Selecione a raça</label>
                  <datalist id="datalistRaca">
                    <!-- Opções de raça serão preenchidas dinamicamente pelo JavaScript -->
                  </datalist>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-floating">
                  <input type="file" name="a_img[]" id="a_img" class="form-control" multiple>
                  <label for="a_img">Selecione as imagens do pet</label>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary rounded rounded-top-0" data-bs-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-warning w-50 rounded rounded-top-0">Cadastrar animal</button>
          </div>
        </form>
      </div>
    </div>
  </div>

<?php } else { ?>
  <!-- Modal - Doar animal USUÁRIO -->
  <div class="modal fade" id="doarAnimal" tabindex="-1" aria-labelledby="doarAnimalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="doarAnimalLabel">Doar animal</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="bg-warning p-2 rounded-1">
            <div class="bg-white p-2 rounded">
              <p>
                A doação animal desempenha um papel vital na proteção e bem-estar dos animais que precisam de ajuda. Ao
                optarmos por doar um animal em vez de vendê-lo, estamos oferecendo a oportunidade de uma nova vida a um
                companheiro peludo.
              </p>
              <p>
                Doar um animal não apenas evita contribuir para o comércio de animais, mas também ajuda
                a reduzir o número de animais em abrigos.
              </p>
              <p>
                Além disso, ao doar um animal, estamos permitindo que ele encontre
                um lar onde será amado e cuidado adequadamente.
              </p>
              <p>
                Essa ação não só transforma a vida do animal doado, mas
                também enriquece a vida daqueles que escolhem dar um novo começo a um amigo de quatro patas.
              </p>
              <hr class="my-2 text-warning">
              <div class="row g-1">
                <div class="col-lg-6">
                  <img src="img/qr-doacao-animal.png" class="img-fluid">
                </div>
                <div class="col-lg-6 text-center">
                  <div class="d-flex justify-content-center align-items-center flex-column">
                    <p class="mb-0">
                      Se não funcionar o QR Code
                    </p>
                    <a href="https://docs.google.com/forms/d/e/1FAIpQLScSKJm8qnf7wzzEdSuN7o2T828ixLmpZoHf9BXb0nra7ve_LA/viewform"
                      target="_blank" class="btn btn-warning rounded-0 w-100">Clique aqui</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary rounded rounded-top-0" data-bs-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>
<?php } ?>

<!-- Modal - Doação recorrente 1 -->
<div class="modal fade" id="doacaoRecorrente25" tabindex="-1" aria-labelledby="doacaoRecorrente25Label"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="doacaoRecorrente25Label">Doação Recorrente</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="bg-black p-2 rounded-1 text-white text-center">
          <p class="fs-5 mb-0">
            Doação recorrente de <span class="text-warning fw-bold">R$ 25,00</span> mensais
          </p>
        </div>
        <hr class="my-2 text-warning">
        <div class="bg-warning p-2 rounded-1">
          <div class="fs-4 mb-2 px-2">O que é?</div>
          <div class="bg-white rounded-1 p-3">
            <p>
              O que é doação recorrente? É como uma assinatura mensal para apoiar uma causa animal.
            </p>
            <p>
              Ao se
              comprometer com uma doação recorrente, você contribui regularmente com um valor fixo a cada mês para
              ajudar
              a sustentar nosso trabalho contínuo.
            </p>
            <p>
              Essa forma de doação é uma maneira conveniente e eficaz de garantir um
              apoio constante às nossas iniciativas, permitindo-nos planejar e implementar projetos de longo prazo com
              confiança.
            </p>
            <hr class="my-1 text-warning">
            <p class="mb-0">
              Junte-se a nós nessa jornada de fazer a diferença, mês após mês.
            </p>
          </div>
        </div>
        <hr class="my-2 text-warning">
        <div class="bg-warning p-2 rounded-1">
          <div class="fs-5 px-2 mb-2">Entre em contato pelo WhatsApp</div>
          <div class="bg-white p-3 rounded-1">
            <div class="row">
              <div class="col-lg-6">
                <div class="border border-warning p-2 rounded-1">
                  <img
                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/fa/Link_pra_pagina_principal_da_Wikipedia-PT_em_codigo_QR_b.svg/800px-Link_pra_pagina_principal_da_Wikipedia-PT_em_codigo_QR_b.svg.png"
                    class="img-fluid">
                </div>
              </div>
              <div class="col-lg-6 ">
                <p class="mb-0 text-center">Você pode tentar também clicando ou salvando:</p>
                <div class="d-flex justify-content-center align-items-center flex-column gap-1 h-75">
                  <p class="fs-5 mb-0 text-center"><a href="https://wa.me/5512991422047"
                      class="link-success text-decoration-none"><i class="bi bi-whatsapp"></i> 12 99142-2047</a></p>
                  <p class="fs-5 mb-0 text-center"><a href="https://wa.me/5512996033026"
                      class="link-success text-decoration-none"><i class="bi bi-whatsapp"></i> 12 99603-3026</a></p>
                  <p class="fs-5 mb-0 text-center"><a href="https://wa.me/5512982811671"
                      class="link-success text-decoration-none"><i class="bi bi-whatsapp"></i> 12 98281-1671</a></p>
                </div>
              </div>
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
<!-- Modal - Doação recorrente 2 -->
<div class="modal fade" id="doacaoRecorrente50" tabindex="-1" aria-labelledby="doacaoRecorrente50Label"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="doacaoRecorrente50Label">Doação Recorrente</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="bg-black p-2 rounded-1 text-white text-center">
          <p class="fs-5 mb-0">
            Doação recorrente de <span class="text-warning fw-bold">R$ 50,00</span> mensais
          </p>
        </div>
        <hr class="my-2 text-warning">
        <div class="bg-warning p-2 rounded-1">
          <div class="fs-4 mb-2 px-2">O que é?</div>
          <div class="bg-white rounded-1 p-3">
            <p>
              O que é doação recorrente? É como uma assinatura mensal para apoiar uma causa animal.
            </p>
            <p>
              Ao se
              comprometer com uma doação recorrente, você contribui regularmente com um valor fixo a cada mês para
              ajudar
              a sustentar nosso trabalho contínuo.
            </p>
            <p>
              Essa forma de doação é uma maneira conveniente e eficaz de garantir um
              apoio constante às nossas iniciativas, permitindo-nos planejar e implementar projetos de longo prazo com
              confiança.
            </p>
            <hr class="my-1 text-warning">
            <p class="mb-0">
              Junte-se a nós nessa jornada de fazer a diferença, mês após mês.
            </p>
          </div>
        </div>
        <hr class="my-2 text-warning">
        <div class="bg-warning p-2 rounded-1">
          <div class="fs-5 px-2 mb-2">Entre em contato pelo WhatsApp</div>
          <div class="bg-white p-3 rounded-1">
            <div class="row">
              <div class="col-lg-6">
                <img
                  src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/fa/Link_pra_pagina_principal_da_Wikipedia-PT_em_codigo_QR_b.svg/800px-Link_pra_pagina_principal_da_Wikipedia-PT_em_codigo_QR_b.svg.png"
                  class="img-fluid">
              </div>
              <div class="col-lg-6 ">
                <p class="mb-0 text-center">Você pode tentar também clicando ou salvando:</p>
                <div class="d-flex justify-content-center align-items-center flex-column gap-1 h-75">
                  <p class="fs-5 mb-0 text-center"><a href="https://wa.me/5512991422047"
                      class="link-success text-decoration-none"><i class="bi bi-whatsapp"></i> 12 99142-2047</a></p>
                  <p class="fs-5 mb-0 text-center"><a href="https://wa.me/5512996033026"
                      class="link-success text-decoration-none"><i class="bi bi-whatsapp"></i> 12 99603-3026</a></p>
                  <p class="fs-5 mb-0 text-center"><a href="https://wa.me/5512982811671"
                      class="link-success text-decoration-none"><i class="bi bi-whatsapp"></i> 12 98281-1671</a></p>
                </div>
              </div>
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
<!-- Modal - Doação recorrente 3 -->
<div class="modal fade" id="doacaoRecorrente100" tabindex="-1" aria-labelledby="doacaoRecorrente100Label"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="doacaoRecorrente100Label">Doação Recorrente</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="bg-black p-2 rounded-1 text-white text-center">
          <p class="fs-5 mb-0">
            Doação recorrente de <span class="text-warning fw-bold">R$ 100,00</span> mensais
          </p>
        </div>
        <hr class="my-2 text-warning">
        <div class="bg-warning p-2 rounded-1">
          <div class="fs-4 mb-2 px-2">O que é?</div>
          <div class="bg-white rounded-1 p-3">
            <p>
              O que é doação recorrente? É como uma assinatura mensal para apoiar uma causa animal.
            </p>
            <p>
              Ao se
              comprometer com uma doação recorrente, você contribui regularmente com um valor fixo a cada mês para
              ajudar
              a sustentar nosso trabalho contínuo.
            </p>
            <p>
              Essa forma de doação é uma maneira conveniente e eficaz de garantir um
              apoio constante às nossas iniciativas, permitindo-nos planejar e implementar projetos de longo prazo com
              confiança.
            </p>
            <hr class="my-1 text-warning">
            <p class="mb-0">
              Junte-se a nós nessa jornada de fazer a diferença, mês após mês.
            </p>
          </div>
        </div>
        <hr class="my-2 text-warning">
        <div class="bg-warning p-2 rounded-1">
          <div class="fs-5 px-2 mb-2">Entre em contato pelo WhatsApp</div>
          <div class="bg-white p-3 rounded-1">
            <div class="row">
              <div class="col-lg-6">
                <img
                  src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/fa/Link_pra_pagina_principal_da_Wikipedia-PT_em_codigo_QR_b.svg/800px-Link_pra_pagina_principal_da_Wikipedia-PT_em_codigo_QR_b.svg.png"
                  class="img-fluid">
              </div>
              <div class="col-lg-6 ">
                <p class="mb-0 text-center">Você pode tentar também clicando ou salvando:</p>
                <div class="d-flex justify-content-center align-items-center flex-column gap-1 h-75">
                  <p class="fs-5 mb-0 text-center"><a href="https://wa.me/5512991422047"
                      class="link-success text-decoration-none"><i class="bi bi-whatsapp"></i> 12 99142-2047</a></p>
                  <p class="fs-5 mb-0 text-center"><a href="https://wa.me/5512996033026"
                      class="link-success text-decoration-none"><i class="bi bi-whatsapp"></i> 12 99603-3026</a></p>
                  <p class="fs-5 mb-0 text-center"><a href="https://wa.me/5512982811671"
                      class="link-success text-decoration-none"><i class="bi bi-whatsapp"></i> 12 98281-1671</a></p>
                </div>
              </div>
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
<!-- Modal - Doação recorrente 4 -->
<div class="modal fade" id="doacaoRecorrente200" tabindex="-1" aria-labelledby="doacaoRecorrente200Label"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="doacaoRecorrente200Label">Doação Recorrente</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="bg-black p-2 rounded-1 text-white text-center">
          <p class="fs-5 mb-0">
            Doação recorrente de <span class="text-warning fw-bold">R$ 200,00</span> mensais
          </p>
        </div>
        <hr class="my-2 text-warning">
        <div class="bg-warning p-2 rounded-1">
          <div class="fs-4 mb-2 px-2">O que é?</div>
          <div class="bg-white rounded-1 p-3">
            <p>
              O que é doação recorrente? É como uma assinatura mensal para apoiar uma causa animal.
            </p>
            <p>
              Ao se
              comprometer com uma doação recorrente, você contribui regularmente com um valor fixo a cada mês para
              ajudar
              a sustentar nosso trabalho contínuo.
            </p>
            <p>
              Essa forma de doação é uma maneira conveniente e eficaz de garantir um
              apoio constante às nossas iniciativas, permitindo-nos planejar e implementar projetos de longo prazo com
              confiança.
            </p>
            <hr class="my-1 text-warning">
            <p class="mb-0">
              Junte-se a nós nessa jornada de fazer a diferença, mês após mês.
            </p>
          </div>
        </div>
        <hr class="my-2 text-warning">
        <div class="bg-warning p-2 rounded-1">
          <div class="fs-5 px-2 mb-2">Entre em contato pelo WhatsApp</div>
          <div class="bg-white p-3 rounded-1">
            <div class="row">
              <div class="col-lg-6">
                <img
                  src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/fa/Link_pra_pagina_principal_da_Wikipedia-PT_em_codigo_QR_b.svg/800px-Link_pra_pagina_principal_da_Wikipedia-PT_em_codigo_QR_b.svg.png"
                  class="img-fluid">
              </div>
              <div class="col-lg-6 ">
                <p class="mb-0 text-center">Você pode tentar também clicando ou salvando:</p>
                <div class="d-flex justify-content-center align-items-center flex-column gap-1 h-75">
                  <p class="fs-5 mb-0 text-center"><a href="https://wa.me/5512991422047"
                      class="link-success text-decoration-none"><i class="bi bi-whatsapp"></i> 12 99142-2047</a></p>
                  <p class="fs-5 mb-0 text-center"><a href="https://wa.me/5512996033026"
                      class="link-success text-decoration-none"><i class="bi bi-whatsapp"></i> 12 99603-3026</a></p>
                  <p class="fs-5 mb-0 text-center"><a href="https://wa.me/5512982811671"
                      class="link-success text-decoration-none"><i class="bi bi-whatsapp"></i> 12 98281-1671</a></p>
                </div>
              </div>
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