<?php
class Order
{
  private $conn;
  private $table_name = "orders";

  // Proprietà di un libro
  public $Id;
  public $Order_Date;
  public $Destination_Country;
  public $Product_Name;
  public $Product_Quantity;


  // Costruttore
  public function __construct($db)
  {
    $this->conn = $db;
  }

  // Leggere i libri dal database
  function read()
  {
    // Query per selezionare tutti i libri
    $query = "SELECT Id, Order_Date, Destination_Country, Product_Name, Product_Quantity FROM " . $this->table_name;

    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt;
  }

  //Leggere il risparmio totale di Co2
  function readSpareCo2($filter = '')
  {
    $query = "SELECT Id, Order_Date, Destination_Country, Product_Name, Product_Quantity, Co2_Spared as Co2_Spared_Per_Item, (Product_Quantity * Co2_Spared) AS Total_Co2_Spared FROM " . $this->table_name . " INNER JOIN products ON product_name = name";

    if ($filter) {
      $query .= ' WHERE ' . $filter;
    };

    echo $query;

    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt;
  }

  //Filtrare la lettura del risparmio totale di Co2
  function filterSpareCo2($column, $filter)
  {
    $condition = ' ';

    if ($column == 'Order_Date') {
      $condition .= $column . ' BETWEEN "' . $filter[0] . '" AND "' . $filter[1] . '"';
    } else {
      $condition = $column . ' = "' . $filter . '"';
    }

    return $this->readSpareCo2($condition);
  }

  // Metodo per creare un nuovo libro
  function create()
  {
    $query = "INSERT INTO " . $this->table_name . " (order_date, destination_country, product_name, product_quantity) VALUES (:order_date, :destination_country, :product_name, :product_quantity)";
    $stmt = $this->conn->prepare($query);

    // Sanitizzazione degli input
    $this->Order_Date = htmlspecialchars(strip_tags($this->Order_Date));
    $this->Destination_Country = htmlspecialchars(strip_tags($this->Destination_Country));
    $this->Product_Name = htmlspecialchars(strip_tags($this->Product_Name));
    $this->Product_Quantity = htmlspecialchars(strip_tags($this->Product_Quantity));

    // Binding dei parametri
    $stmt->bindParam(":order_date", $this->Order_Date);
    $stmt->bindParam(":destination_country", $this->Destination_Country);
    $stmt->bindParam(":product_name", $this->Product_Name);
    $stmt->bindParam(":product_quantity", $this->Product_Quantity);

    // Esecuzione della query
    if ($stmt->execute()) {
      return true;
    }

    return false;
  }

  // Metodo per aggiornare un libro esistente
  function update()
  {
    $query = "UPDATE " . $this->table_name . " SET Order_Date=:order_date, Destination_Country=:destination_country, Product_Name=:product_name, Product_Quantity=:product_quantity WHERE Id = :Id";
    $stmt = $this->conn->prepare($query);

    // Sanitizzazione degli input
    $this->Id = htmlspecialchars(strip_tags($this->Id));
    $this->Order_Date = htmlspecialchars(strip_tags($this->Order_Date));
    $this->Destination_Country = htmlspecialchars(strip_tags($this->Destination_Country));
    $this->Product_Name = htmlspecialchars(strip_tags($this->Product_Name));
    $this->Product_Quantity = htmlspecialchars(strip_tags($this->Product_Quantity));

    // Binding dei parametri
    $stmt->bindParam(":Id", $this->Id);
    $stmt->bindParam(":order_date", $this->Order_Date);
    $stmt->bindParam(":destination_country", $this->Destination_Country);
    $stmt->bindParam(":product_name", $this->Product_Name);
    $stmt->bindParam(":product_quantity", $this->Product_Quantity);
    // Esecuzione della query
    if ($stmt->execute()) {
      return true;
    }

    return false;
  }

  // Metodo per cancellare un libro
  function delete()
  {
    $query = "DELETE FROM " . $this->table_name . " WHERE Id = ?";
    $stmt = $this->conn->prepare($query);

    // Sanitizzazione dell'input
    $this->Id = htmlspecialchars(strip_tags($this->Id));

    // Binding del parametro
    $stmt->bindParam(1, $this->Id);

    // Esecuzione della query
    if ($stmt->execute()) {
      return true;
    }

    return false;
  }
}
