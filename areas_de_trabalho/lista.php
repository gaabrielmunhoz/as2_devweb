<?php
session_start();
if (!isset($_SESSION["login_usuario"])) {
  header("Location: ../login/index.html");
  exit();
}

include "../banco_de_dados/conecta_bd.php";

$id_lista = intval($_GET["id_lista"]);
$id_usuario = $_SESSION["id_usuario"];

$sql = "SELECT * FROM listas WHERE id_lista = ? AND id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_lista, $id_usuario);
$stmt->execute();
$lista = $stmt->get_result()->fetch_assoc();

if (!$lista) {
  echo "Lista não encontrada.";
  exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title><?php echo $lista['nome_lista']; ?> | ToDoTasks</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    .coluna {
      background-color: #f4f4f4;
      border-radius: 10px;
      padding: 15px;
      min-height: 300px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .cartao {
      background-color: white;
      padding: 10px 12px;
      margin-bottom: 10px;
      border-radius: 5px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
      position: relative;
      transition: 0.2s;
    }

    .checkbox-task {
      position: absolute;
      left: 10px;
      top: 50%;
      transform: translateY(-50%);
    }

    .btn-arquivar {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      background-color: transparent;
      border: none;
      color: #dc3545;
      font-size: 1.2rem;
    }

    .titulo-coluna {
      font-weight: bold;
      color: black;
      margin-bottom: 15px;
    }

    .texto-tarefa {
      margin-left: 35px;
      margin-right: 35px;
    }

    .btn-verde {
      background-color: #00C820;
      color: white;
    }
    .btn-verde:hover {
      background-color: #00b01c;
      color: white;
    }

    .btn-outline-success {
      border-color: #00C820;
      color: #00C820;
    }

    .btn-outline-success:hover {
      background-color: #00C820;
      color: white;
    }
  </style>
</head>
<body class="bg-light">

<div class="container text-center mt-2 mb-4">
  <img src="../imagens/logoToDoTasks.png" class="img-fluid mx-auto d-block" width="150" alt="Logo">
</div>

<div class="container-fluid p-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2><?php echo $lista['nome_lista']; ?></h2>
    <a href="../areas_de_trabalho/areas_de_trabalho.php" class="btn btn-outline-success">← Voltar</a>
  </div>

  <div class="row mb-5">
    <div class="col-md-6 mb-4">
      <div class="coluna">
        <div class="titulo-coluna">Pendentes</div>
        <div id="pendentes">
          <?php
          $sql = "SELECT * FROM tarefa WHERE id_lista = ? AND status_tarefa = 'pendente' AND tarefa_arquivada = 0";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("i", $id_lista);
          $stmt->execute();
          $result = $stmt->get_result();
          while ($tarefa = $result->fetch_assoc()) {
            echo "
              <div class='cartao' id='tarefa_{$tarefa['id_tarefa']}'>
                <input type='checkbox' class='checkbox-task' onclick='moverTarefa({$tarefa['id_tarefa']}, \"concluida\")'>
                <span class='texto-tarefa'>{$tarefa['titulo_tarefa']}</span>
              </div>
            ";
          }
          ?>
        </div>
      </div>
    </div>

    <div class="col-md-6 mb-4">
      <div class="coluna">
        <div class="titulo-coluna">Concluídas</div>
        <div id="concluidas">
          <?php
          $sql = "SELECT * FROM tarefa WHERE id_lista = ? AND status_tarefa = 'concluida' AND tarefa_arquivada = 0";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("i", $id_lista);
          $stmt->execute();
          $result = $stmt->get_result();
          while ($tarefa = $result->fetch_assoc()) {
            echo "
              <div class='cartao text-muted' id='tarefa_{$tarefa['id_tarefa']}'>
                <input type='checkbox' class='checkbox-task' checked onclick='moverTarefa({$tarefa['id_tarefa']}, \"pendente\")'>
                <span class='texto-tarefa'><s>{$tarefa['titulo_tarefa']}</s></span>
                <button class='btn btn-outline-danger btn-sm btn-arquivar' onclick='arquivarTarefa({$tarefa['id_tarefa']})' title='Arquivar'>arquivar</button>
              </div>
            ";
          }
          ?>
        </div>
      </div>
    </div>
  </div>

<div class="container">
  <form id="formNovaTarefa" class="form-inline justify-content-center">
    <input type="hidden" name="id_lista" value="<?php echo $id_lista; ?>">
    <input type="text" name="titulo_tarefa" class="form-control mr-2 mb-2" placeholder="Nova tarefa" required>
    <button type="submit" class="btn btn-verde mb-2 mr-2">Adicionar</button>
  </form>

  <div class="text-center mt-2">
    <button type="button" class="btn btn-outline-danger mb-4" onclick="apagarLista()">Apagar área de trabalho</button>
  </div>
</div>

<script>
  $('#formNovaTarefa').on('submit', function(e) {
    e.preventDefault();
    $.post('nova_tarefa.php', $(this).serialize(), function(retorno) {
      $('#pendentes').append(`
        <div class='cartao' id='tarefa_${retorno.id}'>
          <input type='checkbox' class='checkbox-task' onclick='moverTarefa(${retorno.id}, "concluida")'>
          <span class='texto-tarefa'>${retorno.titulo}</span>
        </div>
      `);
      $('input[name="titulo_tarefa"]').val('');
    }, 'json');
  });

  function moverTarefa(id_tarefa, novo_status) {
    $.post('mover_tarefa.php', { id_tarefa, status: novo_status }, function() {
      location.reload();
    });
  }

  function arquivarTarefa(id_tarefa) {
    $.post('arquivar_tarefa.php', { id_tarefa }, function() {
      $('#tarefa_' + id_tarefa).fadeOut(300, function() {
        $(this).remove();
      });
    });
  }

  function apagarLista() {
  if (confirm("Tem certeza que deseja apagar esta área de trabalho? Todas as tarefas também serão apagadas!")) {
    console.log("Enviando requisição para excluir_area_trabalho.php");
    $.post('excluir_area_trabalho.php', { id_lista: <?php echo $id_lista; ?> }, function(retorno) {
      console.log("Resposta:", retorno);
      if (retorno.trim() === 'ok') {
        alert("Área de trabalho apagada com sucesso!");
        window.location.href = '../areas_de_trabalho/areas_de_trabalho.php';
      } else {
        alert("Erro ao apagar a área de trabalho.");
      }
    }).fail(function(jqXHR, textStatus, errorThrown) {
      console.error("Erro na requisição:", textStatus, errorThrown);
      alert("Erro ao conectar com o servidor.");
    });
  }
}
</script>

</body>
</html>
