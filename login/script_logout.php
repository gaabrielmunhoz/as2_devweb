<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Logout | ToDoTasks</title>
  <meta http-equiv="refresh" content="3;url=../login/index.html">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
</head>
<body class="bg-light d-flex justify-content-center align-items-center" style="height: 100vh;">
  <div class="text-center">
    <div class="spinner-border text-success mb-3" role="status">
      <span class="sr-only">Carregando...</span>
    </div>
    <h4>Fazendo o logout.</h4>
    <p>Redirecionando para a página de login...</p>
  </div>
</body>
</html>
