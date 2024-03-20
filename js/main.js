// Função para atualizar as opções do datalist de raça
function atualizarRacas() {
  // Obtém o valor selecionado no datalistPets
  var categoriaSelecionada = document.getElementById('petCategoria').value;

  // Faz a requisição AJAX para buscar as raças correspondentes à categoria selecionada
  var xhr = new XMLHttpRequest();
  xhr.open('GET', './inc/buscar_racas.php?categoria=' + categoriaSelecionada, true);
  xhr.onload = function () {
    if (xhr.status === 200) {
      // Limpa as opções atuais do datalistRaca
      document.getElementById('datalistRaca').innerHTML = '';

      // Adiciona as novas opções ao datalistRaca
      var racas = JSON.parse(xhr.responseText);
      racas.forEach(function (raca) {
        var option = document.createElement('option');
        option.value = raca;
        document.getElementById('datalistRaca').appendChild(option);
      });
    }
  };
  xhr.send();
}
