<?php
// Impostazione degli header HTTP
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

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

if (!empty($data->Id) && !empty($data->Order_Date) && !empty($data->Destination_Country) && !empty($data->Product_Name) && !empty($data->Product_Quantity)) {
  $order->Id = $data->Id;
  $order->Order_Date = $data->Order_Date;
  $order->Destination_Country = $data->Destination_Country;
  $order->Product_Name = $data->Product_Name;
  $order->Product_Quantity = $data->Product_Quantity;

  // Aggiornamento dell'ordine
  if ($order->update()) {
    http_response_code(200);
    echo json_encode(array("message" => "Ordine aggiornato correttamente."));
  } else {
    http_response_code(503);
    echo json_encode(array("message" => "Impossibile aggiornare l'ordine."));
  }
} else {
  http_response_code(400);
  echo json_encode(array("message" => "Impossibile aggiornare l'ordine, dati incompleti."));
}
