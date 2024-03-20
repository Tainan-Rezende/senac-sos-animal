<p class="mb-0">
  Suas informações de cadastro
</p>
<fieldset class="p-3 rounded border border-warning mt-2">
  <div class="row g-2">
    <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 d-flex justify-content-center">
      <div class="foto_usuario rounded" style="background-image: url(<?php echo $base_url.$usuario['foto']; ?>);"></div>
    </div>
    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 d-flex justify-content-center align-items-center">
      <table class="table table-hover w-100">
        <tr>
          <td class="w-25"><b class="text-warning">Nome: </b> </td>
          <td><?= ucfirst($usuario['nome']); ?></td>
        </tr>
        <tr>
          <td class="w-25"><b class="text-warning">Sobrenome: </b> </td>
          <td><?= ucfirst($usuario['sobrenome']); ?></td>
        </tr>
        <tr>
          <td class="w-25"><b class="text-warning">E-mail: </b> </td>
          <td><?= ucfirst($usuario['email']); ?></td>
        </tr>
      </table>
    </div>

  </div>


</fieldset>