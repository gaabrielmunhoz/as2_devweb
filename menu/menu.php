<?php
session_start();

// Redireciona se não estiver logado
if (!isset($_SESSION["login_usuario"])) {
  header("Location: ../login/index.html");
  exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Menu | ToDoTasks</title>
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
    <h5 class="mt-3">Bem-vindo(a), <?php echo $_SESSION["nome_usuario"]; ?>!</h5>
  </div>

  <div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
        <h4 class="text-center mb-4">Menu</h4>
        <div class="text-center mt-3">
            <a href="#" class="btn btn-outline-verde btn-block mb-2">Áreas de trabalho</a>
            <a href="#" class="btn btn-outline-roxo btn-block mb-2">Tarefas arquivadas</a>
            <a href="#" class="btn btn-outline-verde btn-block mb-2">Editar perfil</a>
            <a href="../login/script_logout.php" class="btn btn-outline-roxo btn-block mb-2" onclick="return confirm('Tem certeza que deseja encerrar a sessão?')">Sair</a>
        </div>
    </div>
  </div>

</body>
</html>
