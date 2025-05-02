<?php
require_once __DIR__ . '../../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

class Connection
{
  public static function make()
  {
    try {
      return new PDO(
        "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'],
        $_ENV['DB_USER'],
        $_ENV['DB_PASS']
      );
    } catch (PDOException $exception) {
      die("Errore di connessione: " . $exception->getMessage());
    }
  }
}
