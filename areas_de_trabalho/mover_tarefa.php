<?php
session_start();
include "../banco_de_dados/conecta_bd.php";

$id_tarefa = intval($_POST['id_tarefa']);
$novo_status = $_POST['status'];

$stmt = $conn->prepare("UPDATE tarefa SET status_tarefa = ? WHERE id_tarefa = ?");
$stmt->bind_param("si", $novo_status, $id_tarefa);
$stmt->execute();
?>