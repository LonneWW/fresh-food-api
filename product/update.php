<?php
// Impostazione degli header HTTP
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Inclusione dei file necessari
include_once '../config/database.php';
include_once '../models/products.php';

// Creazione dell'oggetto Database e connessione al database
$database = new Database();
$db = $database->getConnection();

// Creazione dell'oggetto Product
$product = new Product($db);

// Recupero dei dati inviati con il POST
$data = json_decode(file_get_contents("php://input"));

// Verifica se tutti i campi necessari sono presenti
if (!empty($data->Name) && !empty($data->Co2_Spared)) {
  $product->Name = $data->Name;
  $product->Co2_Spared = $data->Co2_Spared;


  // Aggiornamento del Product
  if ($product->update()) {
    http_response_code(200);
    echo json_encode(array("message" => "Prodotto aggiornato correttamente."));
  } else {
    http_response_code(503);
    echo json_encode(array("message" => "Impossibile aggiornare il prodotto."));
  }
} else {
  http_response_code(400);
  echo json_encode(array("message" => "Impossibile aggiornare il prodotto, dati incompleti."));
}
