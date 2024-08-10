<?php

/**
 * @file
 * Manages database connection using PDO.
 */

/**
 * Database class handles the connection to the database through PDO.
 */
class Database {
  /**
   * @var PDO|null 
   *   Holds the PDO connection object.
   */
  private ?PDO $pdo = NULL;

  /**
   * Database connection initialiization.
   */
  public function __construct()
  {
    $this->connect();
  }

  /**
   * Establishes a PDO connection to the database.
   *
   * @throws PDOException 
   *   If connection fails.
   */
  private function connect() {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
    $options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    try {
      $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    } 
    catch (PDOException $exception) {
      die('Connection failed: ' . $exception->getMessage());
    }
  }

  /**
   * Retrieves the PDO connection object.
   *
   * @return PDO 
   *   The PDO connection object.
   */
  public function getPDO(): PDO {
    return $this->pdo;
  }
}
