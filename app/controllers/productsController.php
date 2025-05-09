<?php
require './models/products.php';
require './validator.php';
class ProductsController
{
  protected $product;
  public function __construct()
  {
    $this->product = new Product;
  }
  public function readAll()
  {
    $products = $this->product->readAll();
    http_response_code(200);
    var_dump($products);
  }

  public function deleteProduct($params)
  {
    $name = $params['name'];
    Validator::validateName($name);
    try {
      $this->product->delete($name);
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

  public function createProduct()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    Validator::validateProduct($data);
    try {
      $this->product->create($data);
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

  public function updateProduct($params)
  {
    $data = json_decode(file_get_contents('php://input'), true);
    $data['name'] = $params['name'];
    Validator::validateProduct($data);
    try {
      $this->product->update($data);
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
