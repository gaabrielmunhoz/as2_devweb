<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Cadastro | ToDoTasks</title>
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
      color: #00C820;
    }
    .btn-verde:hover {
      background-color: #00b01c;
      color: white;
    }
  </style>
</head>
<body class="bg-light">

<?php
include "../banco_de_dados/conecta_bd.php";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome_usuario = $_POST['nome_usuario'] ?? '';
    $login_usuario = $_POST['login_usuario'] ?? '';
    $senha_usuario = $_POST['senha_usuario'] ?? '';
    $sql_check = "SELECT * FROM usuarios WHERE login_usuario = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "s", $login_usuario);
    mysqli_stmt_execute($stmt_check);
    $resultado_check = mysqli_stmt_get_result($stmt_check);
    if (mysqli_fetch_assoc($resultado_check)){
        header("Location: ../login/erro.php?tipo=email");
        exit();
    }
    $senha_criptografada = password_hash($senha_usuario, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nome_usuario, login_usuario, senha_usuario) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $nome_usuario, $login_usuario, $senha_criptografada);

    if (mysqli_stmt_execute($stmt)){
        header("Location: ../cadastro/sucesso_cadastro.php");
        exit();
    } else {
        header("Location: ../login/erro.php?tipo=erro");
        exit();
    }

}
?>

</body>
</html>
