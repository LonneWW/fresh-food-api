<?php
require './models/orders.php';
//da fixare chiamate con filtri e parametri
echo 'ordersController';
class ordersController
{
  protected $order;
  protected $product;
  public function __construct()
  {
    $this->order = new Order;
    $this->product = new Product;
  }
  public function readAll()
  {
    $orders = $this->order->read();
    http_response_code(200);
    echo json_encode($orders);
  }

  public function readSpareCo2()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    if (count($data) !== 1) {
      throw new Exception("Troppi parametri per filtrare il risultato.");
    }
    $orders = $this->order->filterSpareCo2($data);
    http_response_code(200);
    echo json_encode($orders);
  }

  public function deleteOrder($params)
  {
    if (!isset($params['id'])) {
      throw new Exception("Parametro 'id' mancante.");
    }
    $id = $params['id'];
    try {
      $this->order->delete($id);
      http_response_code(200);
      echo json_encode($this->readAll());
    } catch (InvalidArgumentException $e) {
      http_response_code(400);
      echo json_encode(['error' => $e->getMessage()]);
    } catch (Exception $e) {
      http_response_code(500);
      echo json_encode(['error' => 'An error occurred']);
    }
  }

  public function createOrder()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    $requiredFields = [
      'order_date',
      'destination_country',
      'product_name',
      'product_quantity'
    ];

    foreach ($requiredFields as $field) {
      if (!isset($data[$field]) || empty(trim($data[$field]))) {
        throw new Exception("Il campo '{$field}' è obbligatorio e non può essere vuoto.");
      }
    }

    $productExistance = $this->order->checkProductExistance($data['product_name']);
    var_dump($productExistance);

    if (!$productExistance) {
      throw new Exception("Prodotto assente nel database.");
    }

    try {
      $this->order->create($data);
      http_response_code(200);
      echo json_encode($this->readAll());
    } catch (InvalidArgumentException $e) {
      http_response_code(400);
      echo json_encode(['error' => $e->getMessage()]);
    } catch (Exception $e) {
      http_response_code(500);
      echo json_encode(['error' => 'An error occurred']);
    }
  }

  public function updateOrder($params)
  {
    if (!isset($params['id'])) {
      throw new Exception("Parametro 'id' mancante.");
    }
    $id = $params['id'];
    $data = json_decode(file_get_contents('php://input'), true);

    $data['id'] = (int)$id;

    $requiredFields = [
      'order_date',
      'destination_country',
      'product_name',
      'product_quantity',
      'id',
    ];

    foreach ($requiredFields as $field) {
      if (!isset($data[$field]) || empty(trim($data[$field]))) {
        throw new Exception("Il campo '{$field}' è obbligatorio e non può essere vuoto.");
      }
    }
    try {
      $this->order->update($data);
      http_response_code(200);
      echo json_encode($this->readAll());
    } catch (InvalidArgumentException $e) {
      http_response_code(400);
      echo json_encode(['error' => $e->getMessage()]);
    } catch (Exception $e) {
      http_response_code(500);
      echo json_encode(['error' => 'An error occurred']);
    }
  }
}
