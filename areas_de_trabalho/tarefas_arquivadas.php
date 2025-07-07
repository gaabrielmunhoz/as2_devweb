<?php
session_start();
if (!isset($_SESSION["login_usuario"])) {
  header("Location: ../login/index.html");
  exit();
}

include "../banco_de_dados/conecta_bd.php";

$id_usuario = $_SESSION["id_usuario"];

$sql = "SELECT tarefa.* FROM tarefa JOIN listas ON tarefa.id_lista = listas.id_lista WHERE tarefa.tarefa_arquivada = 1 AND listas.id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Tarefas Arquivadas | ToDoTasks</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    .cartao {
      background-color: white;
      padding: 10px 12px;
      margin-bottom: 10px;
      border-radius: 5px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
      position: relative;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .btn-verde {
      background-color: #00C820;
      color: white;
    }
    .btn-verde:hover {
      background-color: #00b01c;
      color: white;
    }
  </style>
</head>
<body class="bg-light">

<div class="container text-center mt-4 mb-4">
  <img src="../imagens/logoToDoTasks.png" class="img-fluid mx-auto d-block" width="150" alt="Logo">
  <h2 class="mt-3">Tarefas Arquivadas</h2>
  <a href="../menu/menu.php" class="btn btn-outline-success mb-4">← Voltar</a>
</div>

<div class="container mb-5">
  <?php
  if ($result->num_rows > 0) {
    while ($tarefa = $result->fetch_assoc()) {
      echo "<div class='cartao' id='tarefa_{$tarefa['id_tarefa']}'>
        <span><em>{$tarefa['titulo_tarefa']}</em></span>
        <div>
          <button class='btn btn-outline-primary btn-sm mr-2' onclick='desarquivarTarefa({$tarefa['id_tarefa']})'>Desarquivar</button>
          <button class='btn btn-outline-danger btn-sm' onclick='confirmarExclusao({$tarefa['id_tarefa']})'>Excluir</button>
        </div>
      </div>";
    }
  } else {
    echo "<p class='text-center'>Nenhuma tarefa arquivada encontrada.</p>";
  }
  ?>
</div>

<script>
  function confirmarExclusao(id) {
    if (confirm("Tem certeza que deseja excluir esta tarefa? Essa ação não pode ser desfeita.")) {
      $.post('excluir_tarefa.php', { id_tarefa: id }, function () {
        $('#tarefa_' + id).fadeOut(300, function () {
          $(this).remove();
        });
      });
    }
  }

  function desarquivarTarefa(id) {
    $.post('desarquivar_tarefa.php', { id_tarefa: id }, function () {
      $('#tarefa_' + id).fadeOut(300, function () {
        $(this).remove();
      });
    });
  }
</script>

</body>
</html>
