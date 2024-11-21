<?php

namespace Roma\Task6;

use PDO;
use InvalidArgumentException;

class User
{
  private array $db = [
    "host" => "127.0.0.1",
    "db" => "lab6",
    "user" => "root",
    "passwd" => "ROOT",
    "charset" => "utf8"
  ];

  private string $dsn;
  private array $opt = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
  ];
  private PDO $pdo;

  public function __construct()
  {
    $this->dsn = "mysql:host={$this->db['host']};dbname={$this->db['db']};charset={$this->db['charset']}";
    $this->pdo = new PDO($this->dsn, $this->db['user'], $this->db['passwd'], $this->opt);
  }

  public function showAllData(): array
  {
    $sql = "SELECT * FROM Users";
    $stmt = $this->pdo->query($sql);
  
    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
  }

  public function addUser(string $name, string $email): void
  {
    try {
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new InvalidArgumentException("Invalid email format");
      }
      $sql = "INSERT INTO Users (name, email) VALUES ('$name', '$email')";
      $this->pdo->query($sql);
    } catch (InvalidArgumentException $e) {
      print ($e->getMessage()) . PHP_EOL;
    }
  }

  public function deleteUser(int $id): void
  {
    $sql = "DELETE FROM Users WHERE id = $id";
    $this->pdo->query($sql);
  }

  public function getUserById(int $id): array
  {
    $sql = "SELECT id, name, email from Users WHERE id = $id";
    $stmt = $this->pdo->query($sql);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function updateUser(int $id, string $name, string $email): void
  {
    try {
      $user = $this->getUserById($id);

      if (!$user) {
        throw new InvalidArgumentException("User is not found!");
      }

      $sql = "UPDATE Users SET name = '$name', email = '$email' WHERE id = $id";
      $this->pdo->query($sql);
    } catch (InvalidArgumentException $e) {
      print($e->getMessage());
    }
  }
  public function searchUsers(string $str): array
  {
    $sql = "SELECT * FROM Users";

    if (trim($str) != "") {
      $stmt = $this->pdo->query($sql . " WHERE name LIKE '%$str%' OR email LIKE '%$str%'");

      return $stmt->fetchAll();
    }

    return $this->showAllData();
  }
}
