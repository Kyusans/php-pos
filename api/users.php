<?php
include "headers.php";

class User
{

  function login($json)
  {
    // {"username":"joe","password":"joe"}
    include "connection.php";
    $data = json_decode($json, true);
    $sql = "SELECT * FROM tbl_users WHERE user_username = :username AND BINARY user_password = :password";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":username", $data["username"]);
    $stmt->bindParam(":password", $data["password"]);
    $stmt->execute();
    return $stmt->rowCount() > 0 ? json_encode($stmt->fetch(PDO::FETCH_ASSOC)) : 0;
  }

  function getBeginningBalance(){
    include "connection.php";
    $sql = "SELECT * FROM tbl_beginning_balance";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->rowCount() > 0 ? json_encode($stmt->fetch(PDO::FETCH_ASSOC)) : 0;
  }

  function updateBeginningBalance($json){
    // {"amount":500}
    include "connection.php";
    $data = json_decode($json, true);
    $sql = "UPDATE tbl_beginning_balance SET beginning_balance = :amount";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":amount", $data["amount"]);
    $stmt->execute();
    return $stmt->rowCount() > 0 ? 1 : 0;
  }

  function getAllCashiers(){
    include "connection.php";
    $sql = "SELECT * FROM tbl_users WHERE user_level = 'user'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->rowCount() > 0 ? json_encode($stmt->fetchAll(PDO::FETCH_ASSOC)) : 0;
  }
} //user

function recordExists($value, $table, $column)
{
  include "connection.php";
  $sql = "SELECT COUNT(*) FROM $table WHERE $column = :value";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(":value", $value);
  $stmt->execute();
  $count = $stmt->fetchColumn();
  return $count > 0;
}

$json = isset($_POST["json"]) ? $_POST["json"] : "0";
$operation = isset($_POST["operation"]) ? $_POST["operation"] : "0";

$user = new User();

switch ($operation) {
  case "login":
    echo $user->login($json);
    break;
  case "getBeginningBalance":
    echo $user->getBeginningBalance();
    break;
  case "updateBeginningBalance":
    echo $user->updateBeginningBalance($json);
    break;
  case "getAllCashiers":
    echo $user->getAllCashiers();
    break;
  default:
    echo "Wala kay gi butang nga operation sa ubos HAHAHAHA bobo";
    break;
}
