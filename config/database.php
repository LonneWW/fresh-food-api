<?php
class Database
{
  // Credenziali del database
  private $host = "127.0.0.1";
  private $db_name = "fresh_food_db";
  private $username = "root";
  private $password = "";
  public $conn;

  // Connessione al database
  public function getConnection()
  {
    $this->conn = null;
    try {
      $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
      $this->conn->exec("set names utf8");
    } catch (PDOException $exception) {
      echo "Errore di connessione: " . $exception->getMessage();
    }
    return $this->conn;
  }
}
