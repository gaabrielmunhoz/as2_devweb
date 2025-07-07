<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login/index.html");
    exit();
}
include "../banco_de_dados/conecta_bd.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["criar_lista"])) {
    $nome_lista = $_POST["nome_lista"];
    $id_usuario = $_SESSION["id_usuario"];
    $descricao_lista = $_POST["descricao_lista"];
    $stmt = $conn->prepare("INSERT INTO listas (id_usuario, nome_lista, descricao_lista) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $id_usuario, $nome_lista, $descricao_lista);

    if ($stmt->execute()) {
        header("Location: ../areas_de_trabalho/areas_de_trabalho.php");
        exit();
    } else {
        echo "Erro ao criar lista: " . $conn->error;
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Criar área de Trabalho | ToDoTasks</title>
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
        <h4 class="text-center mb-4">Criar Nova área de trabalho</h4>
        <div class="mt-3">
            <form method="post" action="../areas_de_trabalho/criar_area_de_trabalho.php">
                <div class="form-group">
                    <label for="nome_usuario">Nomeie a nova área de trabalho</label>
                    <input type="text" name="nome_lista" class="form-control" placeholder="Nome da nova área" required>
                </div>
                <div class="form-group">
                    <label for="nome_usuario">Descrição (Opcional)</label>
                    <input type="text" name="descricao_lista" class="form-control" placeholder="Descrição">
                </div>
                <button type="submit" name="criar_lista" class="btn btn-verde btn-block">Criar</button>
                <div class="text-center mt-3">
                    <a href="../areas_de_trabalho/areas_de_trabalho.php" class="btn btn-danger btn-block">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
  </div>

</body>
</html>
