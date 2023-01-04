<?php

namespace src\inc;

class connection
{
  private $host;
  private $dbname;
  private $user_name;
  private $password;
  public $table_name;
  public $pdo;

  public function __construct(
    $host = 'localhost',
    $dbname =
    'login_system_application',
    $user_name = 'root',
    $password = '',
    $table_name = 'users'
  )
  {
    $this->host = $host;
    $this->dbname = $dbname;
    $this->user_name = $user_name;
    $this->password = $password;
    $this->table_name = $table_name;

    try {
      $this->pdo = new \PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user_name, $password, [
          \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
          \PDO::ATTR_EMULATE_PREPARES => false,
          \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
      ]);
    } catch (\PDOException $e) {
      die(print_r($e->getMessage()));
    }
  }
}