<?php
session_start();
if (!isset($_SESSION["login_usuario"])) {
  http_response_code(403);
  exit();
}

include "../banco_de_dados/conecta_bd.php";

$id_lista = intval($_POST["id_lista"]);
$id_usuario = $_SESSION["id_usuario"];


$sql_verifica = "SELECT id_lista FROM listas WHERE id_lista = ? AND id_usuario = ?";
$stmt = $conn->prepare($sql_verifica);
$stmt->bind_param("ii", $id_lista, $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  http_response_code(404);
  echo "lista_nao_encontrada";
  exit();
}


$sql_tarefas = "DELETE FROM tarefa WHERE id_lista = ?";
$stmt = $conn->prepare($sql_tarefas);
$stmt->bind_param("i", $id_lista);
$stmt->execute();


$sql_lista = "DELETE FROM listas WHERE id_lista = ? AND id_usuario = ?";
$stmt = $conn->prepare($sql_lista);
$stmt->bind_param("ii", $id_lista, $id_usuario);

if ($stmt->execute()) {
  echo "ok";
} else {
  http_response_code(500);
  echo "erro";
}
?>