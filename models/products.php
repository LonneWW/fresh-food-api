<?php

class Product
{
  public function readAll()
  {
    $query = "SELECT Name, Co2_Spared FROM products";
    return QueryBuilder::query($query);
  }

  public function create($params)
  {
    $query = "INSERT INTO products VALUES (:name, :co2_spared)";
    $mappedParamsArray = [
      ':name'         => $params['name'],
      ':co2_spared' => $params['co2_spared'],

    ];
    return QueryBuilder::query($query, $mappedParamsArray);
  }

  public function update($params)
  {
    $query = "UPDATE products SET Name=:name, Co2_spared=:co2_spared WHERE Name = :name";
    $mappedParamsArray = [
      ':name'         => $params['name'],
      ':co2_spared' => $params['co2_spared'],

    ];
    return QueryBuilder::query($query, $mappedParamsArray);
  }

  public function delete($name)
  {
    $name = "'" . $name . "'";
    $query = "DELETE FROM products WHERE Name = " . $name;
    return QueryBuilder::query($query);
  }
}
