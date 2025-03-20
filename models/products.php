<?php
class Product
{
  private $conn;
  private $table_name = "products";

  // Proprietà di un libro
  public $Name;
  public $Co2_Spared;

  // Costruttore
  public function __construct($db)
  {
    $this->conn = $db;
  }

  // Leggere i libri dal database
  function read()
  {
    // Query per selezionare tutti i libri
    $query = "SELECT Name, Co2_Spared FROM " . $this->table_name;

    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt;
  }

  // Metodo per creare un nuovo libro
  function create()
  {
    $query = "INSERT INTO " . $this->table_name . " VALUES (:name, :co2_spared)";
    $stmt = $this->conn->prepare($query);

    // Sanitizzazione degli input
    $this->Name = htmlspecialchars(strip_tags($this->Name));
    $this->Co2_Spared = htmlspecialchars(strip_tags($this->Co2_Spared));

    // Binding dei parametri
    $stmt->bindParam(":name", $this->Name);
    $stmt->bindParam(":co2_spared", $this->Co2_Spared);

    // Esecuzione della query
    if ($stmt->execute()) {
      return true;
    }

    return false;
  }

  // Metodo per aggiornare un libro esistente
  function update()
  {
    $query = "UPDATE " . $this->table_name . " SET Name=:name, Co2_spared=:co2_spared WHERE Name = :name";
    $stmt = $this->conn->prepare($query);

    // Sanitizzazione degli input
    $this->Name = htmlspecialchars(strip_tags($this->Name));
    $this->Co2_Spared = htmlspecialchars(strip_tags($this->Co2_Spared));

    // Binding dei parametri
    $stmt->bindParam(":name", $this->Name);
    $stmt->bindParam(":co2_spared", $this->Co2_Spared);

    // Esecuzione della query
    if ($stmt->execute()) {
      return true;
    }

    return false;
  }

  // Metodo per cancellare un libro
  function delete()
  {
    $query = "DELETE FROM " . $this->table_name . " WHERE Name = ?";
    $stmt = $this->conn->prepare($query);

    // Sanitizzazione dell'input
    $this->Name = htmlspecialchars(strip_tags($this->Name));

    // Binding del parametro
    $stmt->bindParam(1, $this->Name);

    // Esecuzione della query
    if ($stmt->execute()) {
      return true;
    }

    return false;
  }
}
