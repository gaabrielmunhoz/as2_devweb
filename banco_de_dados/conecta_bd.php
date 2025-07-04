<?php
$server = "localhost";
$user = "root";
$password = "";
$bd = "ToDoTasks";

function mensagem($texto, $tipo){
    echo "<div class='alert alert-$tipo' role='alert' style='max-width:500px;margin:20px auto;'>$texto</div>";
}

$conn = mysqli_connect($server, $user, $password, $bd);

if (!$conn){
    die("Erro na conexão com o banco: " .mysqli_connect_error());
}

?>