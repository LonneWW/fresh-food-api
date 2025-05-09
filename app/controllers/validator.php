<?php
class Validator
{
  public static function validateId($id)
  {
    if (!isset($id)) {
      throw new InvalidArgumentException('missing ID');
    }
    if (!is_numeric($id)) {
      throw new InvalidArgumentException('invalid ID, it must be a number');
    }
  }

  public static function validateOrder($data)
  {
    $requiredFields = [
      'order_date',
      'destination_country',
      'product_name',
      'product_quantity'
    ];

    foreach ($requiredFields as $field) {
      if (!isset($data[$field]) || empty(trim($data[$field]))) {
        throw new Exception("The field '{$field}' is required and cannot be empty.");
      }
    }
  }

  public static function validateName($name)
  {
    if (!isset($name)) {
      throw new Exception("Parameter 'name' missing.");
    }
  }

  public static function validateProduct($data)
  {
    $requiredFields = [
      'name',
      'co2_spared',
    ];

    foreach ($requiredFields as $field) {
      if (!isset($data[$field]) || empty(trim($data[$field]))) {
        throw new Exception("The field '{$field}' is required and cannot be empty.");
      }
    }
  }
}
