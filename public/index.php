<?php
session_start();

require_once "../src/require.php";

$db = new Database();
$pdo = $db->getPDO();
$fetcher = new CurrencyRateFetcher();
$rates = $fetcher->getRates();
$currencies = $fetcher->getCurrencies();
$converter = new CurrencyConverter($rates);

$selectedFrom = $_SESSION["selectedFrom"] ?? "PLN";
$selectedTo = $_SESSION["selectedTo"] ?? "PLN";
$amount = $_POST["amount"] ?? 100;
$errorMsg = "";

if (isset($_POST["clear_history"])) {
  $_SESSION["conversions"] = [];
}

if (!isset($_SESSION["conversions"])) {
  $_SESSION["conversions"] = [];
}

if (isset($_POST["convert"])) {
  if (empty($amount) || $amount <= 0) {
    $errorMsg = "Proszę wprowadzić kwotę większą od zera.";
  } 
  else {
    $_SESSION["selectedFrom"] = $_POST["from"];
    $_SESSION["selectedTo"] = $_POST["to"];

    $result = $converter->convert(
      $amount,
      $_SESSION["selectedFrom"],
      $_SESSION["selectedTo"]
    );
    $stmt = $pdo->prepare(
      "INSERT INTO conversions (from_currency, to_currency, amount, converted_amount, conversion_rate) VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->execute([
      $_SESSION["selectedFrom"],
      $_SESSION["selectedTo"],
      $amount,
      $result,
      $result / $amount,
    ]);

    $conversion = [
      "from_currency" => $_SESSION["selectedFrom"],
      "to_currency" => $_SESSION["selectedTo"],
      "amount" => $amount,
      "converted_amount" => $result,
      "conversion_rate" => $result / $amount,
      "timestamp" => date("Y-m-d H:i:s"),
    ];

    array_unshift($_SESSION["conversions"], $conversion);
    $_SESSION["conversions"] = array_slice($_SESSION["conversions"], 0, 10);

    header("Location: index.php");
    
    exit();
  }
}

include "../templates/currency_exchange_template.php";
