<?php

require 'Connection.php';

class QueryBuilder
{
  protected static $pdo;
  public function __construct()
  {
    self::$pdo = Connection::make();
  }
  public static function returnPdo()
  {
    return self::$pdo;
  }
  public static function query($query, $params = [])
  {
    try {
      $stmt = self::$pdo->prepare($query);
      $stmt->execute($params);
      return $stmt->fetchAll(PDO::FETCH_OBJ);
    } catch (Exception $e) {
      die($e->getMessage());
    };
  }
}
