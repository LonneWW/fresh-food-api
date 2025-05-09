<?php
require './models/orders.php';
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
    $data = $_GET;
    var_dump($_GET);
    if (count($data) > 1) {
      throw new Exception("Too many query fields.");
    }
    $orders = $this->order->filterSpareCo2($data);
    http_response_code(200);
    echo json_encode($orders);
  }

  public function deleteOrder($params)
  {
    $id = $params['id'];
    Validator::validateId($id);
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
    Validator::validateOrder($data);

    $productExistance = $this->order->checkProductExistance($data['product_name']);
    if (!$productExistance) {
      throw new Exception("{$data['product_name']} is not available in the database.");
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
    Validator::validateId($id);
    Validator::validateOrder($data);
    $data['id'] = (int)$id;
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
