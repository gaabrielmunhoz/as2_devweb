<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Excluir conta | ToDoTasks</title>
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
  </style>
</head>
<body class="bg-light">

<?php
session_start();
if (!isset($_SESSION["login_usuario"])) {
  header("Location: ../login/index.html");
  exit();
}
include "../banco_de_dados/conecta_bd.php";
$id_usuario = $_SESSION['id_usuario'] ?? '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $senha_atual = $_POST["senha_atual"]; 

  $sql = "SELECT senha_usuario FROM usuarios WHERE id_usuario = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "i", $id_usuario);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $senha_no_banco);
  mysqli_stmt_fetch($stmt);
  mysqli_stmt_close($stmt);

  if (password_verify($senha_atual, $senha_no_banco)) {
    $sql_delete = "DELETE FROM usuarios WHERE id_usuario = ?";
    $stmt_delete = mysqli_prepare($conn, $sql_delete);
    mysqli_stmt_bind_param($stmt_delete, "i", $id_usuario);
    mysqli_stmt_execute($stmt_delete);
    mysqli_stmt_close($stmt_delete);
    session_destroy();
    header("Location: ../cadastro/sucesso_exclusao.php");
    exit();
  } else {
    echo '<div class="container mt-3"><div class="alert alert-danger text-center">Senha incorreta.</div></div>';
  }
}
?>

<div class="container text-center mt-2 mb-4">
  <img src="../imagens/logoToDoTasks.png" class="img-fluid mx-auto d-block" width="150" alt="Logo">
</div>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
  <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
    <h4 class="text-center mb-4">Excluir conta</h4>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="excluirConta">
      <div class="form-group">
        <label for="senha_atual">Confirme sua senha</label>
        <input type="password" class="form-control" id="senha_atual" name="senha_atual" required>
      </div>

      <div class="text-center mt-3">
        <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Tem certeza que deseja excluir sua conta? Essa ação é IRREVERSÍVEL')">Excluir conta</button>
      </div>

      <div class="text-center mt-3">
        <a href="../menu/menu.php" class="btn btn-verde btn-block">Cancelar</a>
      </div>

    </form>
  </div>
</div>

</body>
</html>
