<?php
include_once("./config/conection.php");
include_once("./templates/header.php");

if (isset($_SESSION["user"]) && is_array($_SESSION["user"])) {

  $nome = $_SESSION["user"][0];
  $adm  = $_SESSION["user"][1];
  $id = $_SESSION["user"][2];
} else {
  echo "<script>window.location = './account/login.php?msg'</script>";
}

?>
    <div class="container mt-4 ">
      <section class="agendamento  ">
        <div id="top" class=" d-sm-flex  justify-content-between">

          <?php
          $conexao = new Conexao();
          $query = $conexao->conectar()->prepare("SELECT * FROM clientes_agenda WHERE utilizador_id = :utilizador_id");
          $query->bindParam(":utilizador_id", $id);
          $query->execute();

          function diasDatas($data_inicial, $data_final)
          {
            $diferenca = strtotime($data_final) - strtotime($data_inicial);
            $dias = floor($diferenca / (60 * 60 * 24));
            if($dias < 0){
              echo "<p class=' text-danger'>Agage a marcação porque ja foi realizada</p>";
            }
            if ($dias == 0) {
              echo "<p class='text-black'>A sua marcação é hoje</p>";
            } else if($dias > 0){
              echo "Faltam: " . $dias . " dias";
            }
          }

          if ($query->rowCount()) {
            $agendas = $query->fetchAll();
          ?>

            <h3>Agendamentos (<?= count($agendas) ?>)</h3>
            <h3 class="h3_agenda" style="margin-right: 70px;"><a style="text-decoration: none;color:#51b3ec;" href="#marcaragendamento" data-bs-toggle="modal" data-bs-target="#addAgendaModal"><i class="fa-solid fa-circle-plus"></i> Marcar agendamento</a></h3>
        </div>

        <div class="row card_agendamento">
          <div class="card-group ">

            <?php foreach ($agendas as $agenda) : ?>
              <div class="col-md-4 mt-1">

                <div class="card me-1 h-100 ">
                  <div class="card-body">
                    <h5 class="card-title"><?= $agenda["titulo"] ?></h5>
                    <p class="card-text">Descrição: <?= $agenda["descricao"] ?></p>
                    <p class="card-text">Data: <?= date("d/m/Y", strtotime($agenda["data"])) ?></p>
                    <p class="card-text">Hora: <?= date("H:i", strtotime($agenda["hora"])) ?></p>
                    <small class="text-muted d-block"><?php diasDatas(date("Y/m/d"), ($agenda["data"])); ?></small><br>

                    <button onclick="editarAgenda(<?= $agenda['id'] ?>)" id="<?= $agenda["id"] ?>" class="btn btn-primary">Modificar</button>
                    <a href="?delete=<?= $agenda["titulo"] ?>" class="btn btn-danger btn_delete_agenda" delete="<?= $agenda["id"] ?>">Anular</a>

                  </div>
                  <div class="card-footer">
                    <small class="text-muted">Você pode editar as marcações antes de 72h antes</small>
                  </div>
                </div>

              </div>
            <?php endforeach; ?>
          </div>
        </div>

      <?php } else { ?>

        <div class="d-flex justify-content-between">
          <h3>Meus Agendamentos (0)</h3>
          <h3 style="margin-right: 70px;"><a style="text-decoration: none;color:#51b3ec;" href="#marcaragendamento" data-bs-toggle="modal" data-bs-target="#addAgendaModal"><i class="fa-solid fa-circle-plus"></i>Marcar agendamento</a></h3>
        </div>

      <?php } ?>

      </section>
    </div>
  <!-- MODAIS ----------------------------------MODAIS -->


  <!-- MODAL DE MARCAR AGENDAMENTO -->

  <div class="modal  modal-xl fade" id="addAgendaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Marcar Agendamento</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="formAgenda">
            <input type="hidden" id="utilizador_id" value="<?= $id ?>" class="form-control">

            <div class="mb-3">
              <label for="titulo" class="col-form-label">Titilo:</label>
              <input type="text" id="titulo" class="form-control">
            </div>
            <div class="mb-3">
              <label for="data" class="col-form-label">Data:</label>
              <input type="date" class="form-control" id="data">
            </div>
            <div class="mb-3">
              <label for="hora" class="col-form-label">Hora:</label>
              <input type="time" id="hora">
            </div>
            <div class="mb-3">
              <label for="message-text" class="col-form-label">Dados do Agendamento:</label>
              <textarea rows="4" class="form-control" id="message-text"></textarea>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
              <button type="submit" id="btn_agendar" class="btn btn-primary">Marcar</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>



  <!-- FIM DO MODAL DE MARCAR AGENDAMENTO -->

  
    <!--MODAL DE EDITAR AGENDAMENTO -->
    <div class="modal modal-lg fade" id="editAgenda" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Agendamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditAgenda">
                        <input type="hidden" id="utilizador_id" class="form-control">

                        <div class="mb-3">
                            <label for="titulo" class="col-form-label">Titilo:</label>
                            <input type="text" id="editTitulo" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="data" class="col-form-label">Data:</label>
                            <input type="date" class="form-control" id="editData">
                        </div>
                        <div class="mb-3">
                            <label for="hora" class="col-form-label">Hora:</label>
                            <select class="form-control" name="" id="editHora">
                                <option value="08:00">08:00</option>
                                <option value="08:30">08:30</option>
                                <option value="09:00">09:00</option>
                                <option value="09:30">09:30</option>
                                <option value="10:00">10:00</option>
                                <option value="10:30">10:30</option>
                                <option value="11:00">11:00</option>
                                <option value="11:30">11:30</option>
                                <option value="13:00">13:00</option>
                                <option value="13:30">13:30</option>
                                <option value="14:00">14:00</option>
                                <option value="14:30">14:30</option>
                                <option value="15:00">15:00</option>
                                <option value="15:30">15:30</option>
                                <option value="16:00">16:00</option>
                                <option value="16:30">16:30</option>
                                <option value="17:00">17:00</option>
                                <option value="17:30">17:30</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Dados do Agendamento:</label>
                            <textarea rows="4" class="form-control" id="edit-message-text"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" id="btn_edit_agendar" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!--FIM DO MODAL DE EDITAR AGENDAMENTO -->


  <!--FIM DO MODAL DE EDITAR AGENDAMENTO -->


  <script src="./js/jquery.js"></script>
  <script src="./js/sweetealert2.js"></script>
  <script src="./js/Ajax.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script>

   async function editarAgenda(id) {
      const dados = await fetch("./modalEditAgenda.php?id=" + id)
      var resposta = await dados.json();
      console.log(resposta)
      console.log(resposta["erro"])
    
    if(resposta["erro"] == true){

      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: resposta["msg"],
      });

    }else{
      var agendas = new Array();
      agendas.push(resposta["dados"][0])
       var edit_titulo = agendas[0].titulo
       var edit_data = agendas[0].data
       var edit_descricao = agendas[0].descricao
       var edit_hora = agendas[0].hora
      

      var ModalEditAgenda = new bootstrap.Modal(document.getElementById("editAgenda"))
      ModalEditAgenda.show();
      document.querySelector("#editTitulo").value = edit_titulo;
      $("#editHora option:selected").text(edit_hora)
      document.querySelector("#editData").value = edit_data;
      document.querySelector("#edit-message-text").value = edit_descricao;
      $("#btn_edit_agendar").attr("edit_id",id)
     // document.getElementById("editTitulo").value = 
    }

      };

    
  </script>

</body>

</html>