<?php
session_start();
include "../banco_de_dados/conecta_bd.php";

$id_tarefa = intval($_POST['id_tarefa']);

$stmt = $conn->prepare("UPDATE tarefa SET tarefa_arquivada = 1 WHERE id_tarefa = ?");
$stmt->bind_param("i", $id_tarefa);
$stmt->execute();
?>