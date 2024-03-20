<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Verifica se todos os campos obrigatórios foram preenchidos
  if (!empty($_POST['txt_endereco']) && !empty($_POST['txt_descricao'])) {
    // Obtém os valores dos campos do formulário
    $endereco = $_POST['txt_endereco'];
    $telefone = !empty($_POST['txt_telefone']) ? $_POST['txt_telefone'] : NULL;
    $celular = !empty($_POST['txt_celular']) ? $_POST['txt_celular'] : NULL;
    $descricao = $_POST['txt_descricao'];

    // Verifica se os valores de telefone e celular são números
    if (!empty($telefone) && !is_numeric($telefone)) {
      $erro = "Por favor, insira um número válido para o telefone.";
    } elseif (!empty($celular) && !is_numeric($celular)) {
      $erro = "Por favor, insira um número válido para o celular.";
    } else {
      // Prepara e executa a inserção no banco de dados
      $sql = "INSERT INTO tbl_sos (sos_endereco, sos_telefone, sos_celular, sos_descricao, sos_date) VALUES (?, ?, ?, ?, NOW())";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssss", $endereco, $telefone, $celular, $descricao);
      $stmt->execute();

      $msg = "Sua denúncia foi enviada com sucesso e já está presente na página de S.O.S.";
    }
  } else {
    $erro = "Houve um problema ao enviar denuncia! Verifique se inseriu todos os dados corretamente.s";
  }
}
?>
<div class="container my-4">
  <div class="row g-1">
    <div class="col-lg-12 mb-2">

      <div class="text-center">
        <p>Aqui na S.O.S animal, cada voz conta e cada gesto faz a diferença. Aqui, nos esforçamos para ser
          uma ponte entre os animais em situações de risco e aqueles que desejam ajudar. É uma jornada de solidariedade
          e compaixão, mas também é uma realidade desafiadora.
        </p>

        <p>
          A demanda por assistência animal é constantemente alta, e embora nos esforcemos para atender a todas as
          necessidades, às vezes nos vemos diante de uma sobrecarga emocional e logística. No entanto, não permitimos
          que isso nos impeça de agir. Cada denúncia, cada compartilhamento, cada doação é uma luz de esperança para
          aqueles que não podem falar por si mesmos.
        </p>
        <p>
          Reconhecemos que ajudar todos os animais em perigo é uma tarefa monumental, e é por isso que contamos com
          você, nossa comunidade, para se juntar a nós nessa missão. Sua participação é crucial. Mesmo o menor gesto
          pode ter um impacto significativo na vida de um animal necessitado.
        </p>
        <p class="mb-0">
          Neste espaço, convidamos você a se envolver, a denunciar casos de abuso ou negligência, a compartilhar
          informações e a oferecer seu apoio.
        </p>

        <div class="bg-warning p-3 rounded-1 mt-4">
          <div class="bg-white rounded p-3 fs-5 fonte-2">
            Juntos, podemos fazer a diferença e criar um mundo mais seguro e compassivo para todas as criaturas que
            compartilham este planeta conosco.
          </div>
        </div>
        <hr class="text-warning my-2">
        <button type="button" class="btn btn-warning rounded-1 w-100" data-bs-toggle="modal" data-bs-target="#addsos">
          Denunciar
        </button>
      </div>
    </div>

    <?php

    $sql = "SELECT * FROM tbl_sos ORDER BY sos_id DESC LIMIT 10";
    $query = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($query)) {

      $dia = date("d/m/Y", strtotime($row['sos_date']));
      $hora = date("H:m", strtotime($row['sos_date']));
      ?>
      <div class="col-lg-6">
        <div class="border rounded-1 p-3 h-100 d-flex align-items-center">
          <div class="row">
            <div class="col-lg-3 col-4 d-flex align-items-center">
              <div
                class="d-flex justify-content-center align-items-center flex-column border border-danger rounded text-white bg-danger p-3 w-100">
                <div class="fs-3 text-white fw-bold">S.O.S</div>
                <small data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Tooltip on right"
                  class="border-top">
                  <?= $dia; ?>
                </small>
                <small>
                  <?= $hora; ?>
                </small>
              </div>
            </div>
            <div class="col-lg-9 col-8">
              <p class="mb-0">
                <?= $row['sos_descricao']; ?>
              </p>
              <hr class="my-2 text-danger">
              <p class="mb-0">
                <b>Endereço: </b>
                <?= $row['sos_endereco']; ?>
              </p>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</div>


<!-- Modal Adicionar Denuncia-->
<div class="modal fade" id="addsos" tabindex="-1" aria-labelledby="addsosLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addsosLabel">Denunciar</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST">
        <div class="modal-body">
          <p class="mb-0">Preencha os campos abaixo para realizar uma denuncia. Todos os campos com <span
              class="text-danger">*</span> são obrigatórios.</p>
          <hr class="text-warning my-2">
          <div class="row g-1">
            <div class="col-lg-12">
              <div class="form-floating">
                <input type="text" name="txt_endereco" id="txt_endereco" class="form-control"
                  placeholder="Digite o endereço completo" required>
                <label for="txt_endereco">Digite o endereço completo<span class="text-danger">*</span></label>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-floating">
                <input type="text" maxlength="10" size="10" name="txt_telefone" id="txt_telefone" class="form-control"
                  placeholder="Digite um telefone para contato (opcional)">
                <label for="txt_telefone">Digite um telefone para contato (opcional)</label>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-floating">
                <input type="text" maxlength="11" size="11" name="txt_celular" id="txt_celular" class="form-control"
                  placeholder="Digite um celular para contato (opcional)">
                <label for="txt_celular">Digite um celular para contato (opcional)</label>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="form-floating">
                <textarea name="txt_descricao" id="txt_descricao" class="form-control" cols="10" rows="10"
                  placeholder="Adicione uma descrição do animal e seu local aproximado" style="height:10vh"
                  required></textarea>
                <label for="txt_descricao">Adicione uma descrição do animal e seu local aproximado <span
                    class="text-danger">*</span></label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-warning rounded-0">Adicionar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  let telefone = document.getElementById("txt_celular").value;
  console.log(telefone)
</script>