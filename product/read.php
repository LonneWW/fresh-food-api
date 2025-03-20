<?php
// Impostazione degli header HTTP
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Inclusione dei file necessari
include_once '../config/database.php';
include_once '../models/products.php';

// Creazione dell'oggetto Database e connessione al database
$database = new Database();
$db = $database->getConnection();

// Creazione dell'oggetto Product
$product = new Product($db);

// Esecuzione della query per leggere i prodotti
$stmt = $product->read();
$num = $stmt->rowCount();

// Verifica se sono stati trovati prodotti
if ($num > 0) {
  $products_arr = array();
  $products_arr["elenco"] = array();

  // Recupero dei dati dei prodotti
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $product_item = array(
      "Name" => $Name,
      "Co2_Spared" => $Co2_Spared
    );
    array_push($products_arr["elenco"], $product_item);
  }

  // Codice di risposta 200 OK e ritorno dei dati
  http_response_code(200);
  echo json_encode($products_arr);
} else {
  // Nessun prodotto trovato, codice di risposta 404 Not Found
  http_response_code(404);
  echo json_encode(array("message" => "Nessun prodotto trovato in Prodotti."));
}
