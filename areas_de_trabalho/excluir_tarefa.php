<?php
session_start();
if (!isset($_SESSION["login_usuario"])) {
  http_response_code(403);
  exit();
}

if (!isset($_POST["id_tarefa"])) {
  http_response_code(400); 
  exit();
}

include "../banco_de_dados/conecta_bd.php";

$id_tarefa = intval($_POST["id_tarefa"]);

$sql = "DELETE tarefa 
        FROM tarefa 
        JOIN listas ON tarefa.id_lista = listas.id_lista 
        WHERE tarefa.id_tarefa = ? AND listas.id_usuario = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_tarefa, $_SESSION["id_usuario"]);

if ($stmt->execute()) {
  echo "Tarefa excluída com sucesso.";
} else {
  http_response_code(500);
  echo "Erro ao excluir.";
}
?>
