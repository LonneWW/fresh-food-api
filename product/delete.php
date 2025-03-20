<?php
// Headers per la gestione delle richieste HTTP
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/products.php';

// Connessione al database
$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

// Acquisizione dei dati inviati in formato JSON
$data = json_decode(file_get_contents("php://input"));

// Assegnazione dell'Name all'oggetto Product
$product->Name = $data->Name;

// Tentativo di eliminazione del product dal database
if (!empty($data->Name)) {
  if ($product->delete()) {
    http_response_code(200);
    echo json_encode(array("risposta" => "Il prodotto è stato eliminato"));
  } else {
    http_response_code(503);
    echo json_encode(array("risposta" => "Impossibile eliminare il prodotto."));
  }
} else {
  echo 'Nome del prodotto non impostato';
}
