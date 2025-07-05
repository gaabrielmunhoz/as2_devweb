<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Editar Perfil | ToDoTasks</title>
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
$id_usuario = $_POST['id_usuario'] ?? $_GET['id_usuario'] ?? '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $novo_nome = $_POST["nome_usuario"];
  $novo_login = $_POST["login_usuario"];

  $sql_update = "UPDATE usuarios SET nome_usuario = ?, login_usuario = ? WHERE id_usuario = ?";
  $stmt = mysqli_prepare($conn, $sql_update);
  mysqli_stmt_bind_param($stmt, "ssi", $novo_nome, $novo_login, $id_usuario);

  if (mysqli_stmt_execute($stmt)) {
    $_SESSION["nome_usuario"] = $novo_nome;
    $_SESSION["login_usuario"] = $novo_login;
    header("Location: ../menu/menu.php");
    exit();
  } else {
    header("Location: ../cadastro/editar_cadastro.php?id_usuario=" . $id_usuario);
    exit();
  }
}

$sql = "SELECT * FROM usuarios WHERE id_usuario = $id_usuario";
$dados = mysqli_query($conn, $sql);
$linhas = mysqli_fetch_assoc($dados);
?>

<div class="container text-center mt-2 mb-4">
  <img src="../imagens/logoToDoTasks.png" class="img-fluid mx-auto d-block" width="150" alt="Logo">
</div>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
  <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
    <h4 class="text-center mb-4">Edição de perfil</h4>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id_usuario=' . $id_usuario; ?>" id="editarCadastro">
      <div class="form-group">
        <label for="nome_usuario">Editar nome</label>
        <input type="text" class="form-control" id="nome_usuario" name="nome_usuario" placeholder="Digite seu nome" required value="<?php echo $linhas['nome_usuario'] ?>">
      </div>

      <div class="form-group">
        <label for="login_usuario">Editar email</label>
        <input type="email" class="form-control" id="login_usuario" name="login_usuario" placeholder="Digite seu e-mail" required value="<?php echo $linhas['login_usuario'] ?>">
      </div>

      <div class="text-center mt-3">
        <a href="../cadastro/alterar_senha.php" class="btn btn-roxo btn-block">Alterar senha</a>
      </div>

      <div class="text-center mt-3">
        <button type="submit" class="btn btn-verde btn-block" onclick="return confirm('Tem certeza que deseja alterar essas informações?')">Confirmar Alterações</button>
      </div>

      <div class="text-center mt-3">
        <a href="../menu/menu.php" class="btn btn-roxo btn-block">Cancelar alterações</a>
      </div>

      <div class="text-center mt-3">
        <a href="../cadastro/excluir_conta.php" class="btn btn-outline-danger btn-block">Excluir conta</a>
      </div>
    </form>
  </div>
</div>

</body>
</html>
