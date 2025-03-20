<?php
// Headers per la gestione delle richieste HTTP
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/orders.php';

// Connessione al database
$database = new Database();
$db = $database->getConnection();

$order = new Order($db);

// Acquisizione dei dati inviati in formato JSON
$data = json_decode(file_get_contents("php://input"));

// Assegnazione dell'Id all'oggetto Order
$order->Id = $data->Id;

// Tentativo di eliminazione dell'ordine dal database
if (!empty($data->Id)) {
  if ($order->delete()) {
    http_response_code(200);
    echo json_encode(array("risposta" => "L'ordine è stato eliminato."));
  } else {
    http_response_code(503);
    echo json_encode(array("risposta" => "Impossibile eliminare l'ordine."));
  }
} else {
  echo 'Id ordine non impostato';
}
