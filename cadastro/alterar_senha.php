<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Alterar senha | ToDoTasks</title>
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
  $nova_senha = $_POST["nova_senha"];
  $confirmar_senha = $_POST["confirmar_senha"];

  $sql = "SELECT senha_usuario FROM usuarios WHERE id_usuario = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "i", $id_usuario);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $senha_no_banco);
  mysqli_stmt_fetch($stmt);
  mysqli_stmt_close($stmt);

  if (password_verify($senha_atual, $senha_no_banco) && $nova_senha === $confirmar_senha) {
    $nova_senha_criptografada = password_hash($nova_senha, PASSWORD_DEFAULT);
    $sql_update = "UPDATE usuarios SET senha_usuario = ? WHERE id_usuario = ?";
    $stmt_update = mysqli_prepare($conn, $sql_update);
    mysqli_stmt_bind_param($stmt_update, "si", $nova_senha_criptografada, $id_usuario);
    mysqli_stmt_execute($stmt_update);
    mysqli_stmt_close($stmt_update);
    header("Location: ../menu/menu.php");
    exit();
  } else {
    echo '<div class="container mt-3"><div class="alert alert-danger text-center">Senha atual incorreta ou confirmação inválida.</div></div>';
  }
}
?>

<div class="container text-center mt-2 mb-4">
  <img src="../imagens/logoToDoTasks.png" class="img-fluid mx-auto d-block" width="150" alt="Logo">
</div>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
  <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
    <h4 class="text-center mb-4">Alterar senha</h4>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id_usuario=' . $id_usuario; ?>" id="editarCadastro">
      <div class="form-group">
        <label for="senha_atual">Senha atual</label>
        <input type="password" class="form-control" id="senha_atual" name="senha_atual" required>
      </div>

      <div class="form-group">
        <label for="nova_senha">Nova senha</label>
        <input type="password" class="form-control" id="nova_senha" name="nova_senha" required>
      </div>

      <div class="form-group">
        <label for="confirmar_senha">Nova senha</label>
        <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" required>
      </div>

      <div class="text-center mt-3">
        <button type="submit" class="btn btn-verde btn-block" onclick="return confirm('Confirmar alteração de senha?')">Confirmar Alteração</button>
      </div>

      <div class="text-center mt-3">
        <a href="../menu/menu.php" class="btn btn-roxo btn-block" onclick="return confirm('Deseja cancelar a alteração de senha?')">Cancelar</a>
      </div>

    </form>
  </div>
</div>

</body>
</html>
