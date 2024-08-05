<?php
  include "headers.php";

  class Products
  {

    function getAllProduct()
    {
      include "connection.php";
      $sql = "SELECT * FROM tbl_products";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $result ? json_encode($result) : 0;
    }

    function updatePrice($json){
      // {"id":1001,"price":1000}
      include "connection.php";
      $data = json_decode($json, true);
      $sql = "UPDATE tbl_products SET product_price = :price WHERE product_id = :id";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(":price", $data["price"]);
      $stmt->bindParam(":id", $data["id"]);
      $stmt->execute();
      $result = $stmt->rowCount();
      return $result ? json_encode($result) : 0;
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

  $product = new Products();

  switch ($operation) {
    case "getAllProduct":
      echo $product->getAllProduct();
      break;
    case "updatePrice":
      echo $product->updatePrice($json);
      break;
  }
