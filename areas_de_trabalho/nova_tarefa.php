<?php
session_start();
include "../banco_de_dados/conecta_bd.php";

$titulo = $_POST['titulo_tarefa'];
$id_lista = intval($_POST['id_lista']);

$stmt = $conn->prepare("INSERT INTO tarefa (id_lista, titulo_tarefa) VALUES (?, ?)");
$stmt->bind_param("is", $id_lista, $titulo);
$stmt->execute();

echo json_encode(['id' => $stmt->insert_id, 'titulo' => $titulo]);

?>