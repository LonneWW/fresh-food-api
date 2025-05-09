<?php
class Order
{
  public function read()
  {
    $query = "SELECT Id, Order_Date, Destination_Country, Product_Name, Product_Quantity FROM orders";
    return QueryBuilder::query($query);
  }

  public function readSpareCo2($params = [])
  {
    $query = "SELECT Id, Order_Date, Destination_Country, Product_Name, Product_Quantity, Co2_Spared as Co2_Spared_Per_Item, (Product_Quantity * Co2_Spared) AS Total_Co2_Spared FROM orders INNER JOIN products ON product_name = name";
    return QueryBuilder::query($query, $params);
  }

  public function filterSpareCo2($params)
  {
    $query = "SELECT Id, Order_Date, Destination_Country, Product_Name, Product_Quantity, Co2_Spared as Co2_Spared_Per_Item, (Product_Quantity * Co2_Spared) AS Total_Co2_Spared FROM orders INNER JOIN products ON product_name = name";

    $condition = ' WHERE ';
    $column = array_keys($params)[0];
    $filter = array_values($params)[0];
    if ($column == 'order_date') {
      $condition .= $column . ' BETWEEN "' . $filter[0] . '" AND "' . $filter[1] . '"';
    } else {
      $condition .= $column . ' = "' . $filter . '"';
    }
    return QueryBuilder::query($query);
  }

  public function checkProductExistance($name)
  {
    $name = "'" . $name . "'";
    $query = "SELECT Name, Co2_Spared FROM products WHERE Name = " . $name;
    return QueryBuilder::query($query);
  }

  public function delete($id)
  {
    $query = "DELETE FROM orders WHERE Id =" . $id;
    return QueryBuilder::query($query);
  }
  public function create($params)
  {
    $query = "INSERT INTO orders (order_date, destination_country, product_name, product_quantity) VALUES (:order_date, :destination_country, :product_name, :product_quantity)";
    $mappedParamsArray = [
      ':order_date'         => $params['order_date'],
      ':destination_country' => $params['destination_country'],
      ':product_name'       => $params['product_name'],
      ':product_quantity'   => $params['product_quantity']
    ];
    return QueryBuilder::query($query, $mappedParamsArray);
  }

  public function update($params)
  {
    $query = "UPDATE orders SET Order_Date=:order_date, Destination_Country=:destination_country, Product_Name=:product_name, Product_Quantity=:product_quantity WHERE Id = :id";
    $mappedParamsArray = [
      ':order_date'         => $params['order_date'],
      ':destination_country' => $params['destination_country'],
      ':product_name'       => $params['product_name'],
      ':product_quantity'   => $params['product_quantity'],
      ':id' => $params['id'],
    ];
    return QueryBuilder::query($query, $mappedParamsArray);
  }
}
