<?php
// Impostazione degli header HTTP
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Inclusione dei file necessari
include_once '../config/database.php';
include_once '../models/orders.php';

// Creazione dell'oggetto Database e connessione al database
$database = new Database();
$db = $database->getConnection();

// Creazione dell'oggetto Order
$order = new Order($db);

// Recupero dei dati inviati con il POST
$data = json_decode(file_get_contents("php://input"));

$stmt;
$num = 0;


if (!empty($data->column)) {
  if (!empty($data->filter)) {
    $stmt = $order->filterSpareCo2($data->column, $data->filter);
    echo 'Qui';
  } else {
    $stmt = $order->readSpareCo2();
    echo 'Qua';
  }
  $num = $stmt->rowCount();
} else {
  http_response_code(400);
  echo json_encode(array("message" => "Impossibile effettuare la ricerca, dati incompleti."));
}



// Verifica se sono stati trovati ordini
if ($num > 0) {
  $orders_arr = array();
  $orders_arr["elenco"] = array();

  // Recupero dei dati dei libri
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $order_item = array(
      "Id" => $Id,
      "Order_Date" => $Order_Date,
      "Destination_Country" => $Destination_Country,
      "Product_Name" => $Product_Name,
      "Product_Quantity" => $Product_Quantity,
    );
    array_push($orders_arr["elenco"], $order_item);
  }

  // Codice di risposta 200 OK e ritorno dei dati
  http_response_code(200);
  echo json_encode($orders_arr);
} else {
  // Nessun ordine trovato, codice di risposta 404 Not Found
  http_response_code(404);
  echo json_encode(array("message" => "Nessun ordine trovato in Ordini."));
}
