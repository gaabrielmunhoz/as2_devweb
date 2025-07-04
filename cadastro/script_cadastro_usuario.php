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

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome_usuario = $_POST['nome_usuario'] ?? '';
    $login_usuario = $_POST['login_usuario'] ?? '';
    $senha_usuario = $_POST['senha_usuario'] ?? '';
    $senha_criptografada = password_hash($senha_usuario, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nome_usuario, login_usuario, senha_usuario) VALUES ('$nome_usuario', '$login_usuario', '$senha_criptografada')";

    if (mysqli_query($conn, $sql)){
        echo "<div class='alert alert-success text-center mt-4'>Usuário cadastrado com sucesso!</div>";
        echo "<div class='text-center'><a href='../login/index.html' class='btn btn-roxo mt-3'>Voltar para página inicial</a></div>";
    } else {
        echo "<div class='alert alert-danger text-center mt-4'>Erro ao cadastrar usuário: " . mysqli_error($conn) . "</div>";
        echo "<div class='text-center'><a href='../login/index.html' class='btn btn-roxo mt-3'>Voltar para página inicial</a></div>";
    }

    mysqli_close($conn);
} else {
    header("Location: ../cadastro/cadastro.html");
    exit;
}
?>

</body>
</html>
