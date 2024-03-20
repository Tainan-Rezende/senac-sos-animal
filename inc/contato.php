<?php
/*
## ID DOS ASSUNTOS

1 - Dúvidas
2 - Críticas
3 - Negócios
4 - Outro

*/
$erro = "";
$msg = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $nomeCompleto = $_POST['nomeCompleto'];
  $email = $_POST['email'];
  $assunto = $_POST['assunto'];
  $mensagem = $_POST['mensagemContato'];

  // Verificar se o nome contém apenas letras e espaços
  if (!preg_match("/^[a-zA-Z ]*$/", $nomeCompleto)) {
    $erro = "Nome inválido. Use apenas letras e espaços.";
  }
  // Verificar se o e-mail é válido
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erro = "E-mail inválido.";
  }
  // Verificar se o assunto foi selecionado
  if ($assunto === "Selecione o assunto") {
    $erro = "Selecione um assunto.";
  }
  // Verificar se há mensagem
  if (empty($mensagem)) {
    $erro = "Digite uma mensagem.";
  }
  // Se não houver erros, prosseguir com o envio
  if (empty($erro)) {
    $sqlContato = "INSERT INTO tbl_contato (c_nome, c_email, c_assunto, c_mensagem) VALUES ('$nomeCompleto', '$email', '$assunto', '$mensagem')";
    $queryContato = mysqli_query($conn, $sqlContato);

    if ($queryContato) {
      $msg = "Sua mensagem foi enviada com sucesso! Caso necessário, uma mensagem de resposta será retornada para o e-mail informado.";
    } else {
      $erro = "Houve algum erro ao enviar sua mensagem!";
    }
  }
}
?>

<div class="container">
  <div class="row g-1">
    <div class="col-xl-8 col-lg-12 mt-3">
      <div class="m-5 text-center">
        <p>
          Estamos muito felizes em saber que você está interessado em entrar em contato conosco. Na nossa página de
          contato, você encontrará todas as informações necessárias para se comunicar conosco de maneira eficiente e
          rápida.
        </p>
        <p>
          Se você tiver alguma dúvida, sugestão, feedback ou apenas quiser dizer olá, estamos aqui para ouvir você.
          Nossa equipe está comprometida em oferecer o melhor atendimento possível e responderemos a todas as suas
          mensagens o mais rápido possível.
        </p>
        <p class="mb-0">
          Não hesite em utilizar os diversos métodos de contato disponíveis para nos alcançar. Seja por e-mail,
          telefone ou redes sociais, estamos prontos para ajudá-lo no que for necessário.
        </p>
      </div>
      <hr class="my-2 text-warning">
      <div class="border p-3 border-warning rounded">

        <p class="mb-0">Entre em contato com nossa equipe preenchendo os campos abaixo.</p>
        <hr class="my-2 text-warning">
        <?php // Caso haja mensagem de sucesso
        if (strlen($msg) > 0) { ?>
          <div class="alert alert-warning mb-0">
            <h4 class="fonte-2">Mensagem Enviada!</h4>
            <hr class="my-2">
            <p class="mb-0">
              <?php echo $msg; ?>
            </p>
          </div>
          <hr class="my-2 text-warning">
        <?php // Caso haja mensagem de erro
        } elseif (strlen($erro) > 0) { ?>
          <div class="alert alert-danger mb-0">
            <h4 class="fonte-2">Falha ao enviar!</h4>
            <hr class="my-2">
            <p class="mb-0">
              <?php echo $erro; ?>
            </p>
          </div>
          <hr class="my-2 text-warning">
        <?php } ?>
        <form method="post">
          <div class="form-floating mb-1">
            <input type="text" name="nomeCompleto" id="nomeCompleto" class="form-control"
              placeholder="Digite seu nome completo" required>
            <label for="nomeCompleto">Digite seu nome completo</label>
          </div>
          <div class="form-floating mb-1">
            <input type="email" name="email" id="email" class="form-control" placeholder="Digite seu E-mail" required>
            <label for="email">Digite seu E-mail</label>
          </div>
          <select class="form-select mb-1" aria-label="Assunto" name="assunto" required>
            <option selected>Selecione o assunto</option>
            <option value="1">Dúvidas</option>
            <option value="2">Críticas</option>
            <option value="3">Negócios</option>
            <option value="4">Outro</option>
          </select>
          <div class="form-floating">
            <textarea name="mensagemContato" id="mensagemContato" class="form-control" placeholder="Digite sua mensagem"
              style="height: 100px;" required></textarea>
            <label for="mensagemContato">Digite sua mensagem</label>
          </div>
          <hr class="my-2 text-warning">
          <div class="row">
            <div class="col-lg-6 mx-auto">
              <button type="submit" class="btn btn-warning rounded-0 w-100">Enviar mensagem</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="col-xl-4 mt-3">
      <div class="border border-warning bg-warning rounded p-3 h-100">
        <div class="fs-3 text-center fonte-2 bg-white rounded-1 p-2">Encontre</div>
        <hr class="my-2">
        <div class="row">
          <div class="col-12">
            <div class="border bg-white border-black border-opacity-25 p-3 rounded mb-1">
              <div class="fs-4 fonte-2">Contato</div>
              <hr class="my-2">
              <p class="mb-0"><i class="bi bi-telephone-fill text-success"></i> (12) 3521-8500</p>
              <p class="mb-0"><a href="mailto:contato@sosanimal.org" class="text-decoration-none"><i
                    class="bi bi-envelope-fill text-primary"></i> contato@sosanimal.org</a></p>
            </div>
            <div class="border bg-white border-black border-opacity-25 p-3 rounded">
              <div class="fs-4 fonte-2">Onde estamos</div>
              <hr class="my-2">
              <p class="mb-0">Rua Suíça, 1255</p>
              <p class="mb-0">Santana, Pindamonhangaba - SP, 12403-610</p>
              <hr class="my-2">
              <div class="text-center rounded border border-5 border-warning">
                <iframe class="rounded "
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1092.525058695679!2d-45.446599491398494!3d-22.920686786326588!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ccefdec6e70eef%3A0xa6fed360282c1ca7!2sSenac%20Pindamonhangaba!5e0!3m2!1spt-BR!2sbr!4v1701806796203!5m2!1spt-BR!2sbr"
                  class="ratio ratio-16x9" height="300" style="width: 100% !important;border:0;" allowfullscreen=""
                  loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>