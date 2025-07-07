<?php
session_start();
if (!isset($_SESSION["login_usuario"])) {
  header("Location: ../login/index.html");
  exit();
}

include "../banco_de_dados/conecta_bd.php";

$id_usuario = $_SESSION['id_usuario'];
$sql = "SELECT id_lista, nome_lista FROM listas WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Áreas de Trabalho | ToDoTasks</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
  <style>
    .btn-roxo {
      background-color: #DA61F8;
      color: white;
    }
    .btn-roxo:hover {
      background-color: #c44de3;
      color: white;
    }

    .btn-verde {
      background-color: #00C820;
      color: white;
    }
    .btn-verde:hover {
      background-color: #00b01c;
      color: white;
    }
    .btn-outline-verde {
  border: 2px solid #00C820;
  color: #00C820;
  background-color: transparent;
  }

    .btn-outline-verde:hover {
      background-color: #00C820;
      color: white;
    }

    .btn-outline-roxo {
      border: 2px solid #DA61F8;
      color: #DA61F8;
      background-color: transparent;
    }

    .btn-outline-roxo:hover {
      background-color: #DA61F8;
      color: white;
    }
  </style>
</head>
<body class="bg-light">

  <div class="container text-center mt-2 mb-4">
    <img src="../imagens/logoToDoTasks.png" class="img-fluid mx-auto d-block" width="150" alt="Logo">
  </div>

  <div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
        <h4 class="text-center mb-4">Áreas de trabalho</h4>
        <div class="text-center mt-3">
            <a href="../areas_de_trabalho/criar_area_de_trabalho.php" class="btn btn-outline-verde btn-block">Criar</a>
            <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<a href='../areas_de_trabalho/lista.php?id_lista={$row['id_lista']}' class='btn btn-roxo btn-block mb-2'>{$row['nome_lista']}</a>";
                }
            ?>
        </div>
        <div class="text-center">
            <a href="../menu/menu.php" class="btn btn-outline-verde btn-block mb-2">Voltar</a>
        </div>
    </div>
  </div>

</body>
</html>
