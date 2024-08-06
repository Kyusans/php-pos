<?php
include "headers.php";

class Sales
{

  function saveTransaction($json)
  {
    // {"master":{"userId":1,"cashTendered":1000,"change":1000,"totalAmount":1000},"detail":[{"productId":1001,"quantity":10,"price":1000}, {"productId":1002,"quantity":10,"price":1000}]}
    include "connection.php";
    $json = json_decode($json, true);
    $master = $json["master"];
    $detail = $json["detail"];
    $date = getCurrentDate();
    try {
      $conn->beginTransaction();
      $sql = "INSERT INTO tbl_sales (sale_userId, sale_cashTendered, sale_change, sale_totalAmount, sale_date) 
        VALUES(:userId, :cashTendered, :change, :totalAmount, :date)";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(":userId", $master["userId"]);
      $stmt->bindParam(":cashTendered", $master["cashTendered"]);
      $stmt->bindParam(":change", $master["change"]);
      $stmt->bindParam(":totalAmount", $master["totalAmount"]);
      $stmt->bindParam(":date", $date);
      $stmt->execute();

      if ($stmt->rowCount() > 0) {
        $saleId = $conn->lastInsertId();
        $sql = "INSERT INTO tbl_sale_item(sale_item_saleId, sale_item_productId, sale_item_quantity, sale_item_price) 
          VALUES(:saleId, :productId, :quantity, :price)";
        foreach ($detail as $item) {
          $stmt = $conn->prepare($sql);
          $stmt->bindParam(":saleId", $saleId);
          $stmt->bindParam(":productId", $item["productId"]);
          $stmt->bindParam(":quantity", $item["quantity"]);
          $stmt->bindParam(":price", $item["price"]);
          $stmt->execute();
        }
        $conn->commit();
        return 1;
      }
    } catch (PDOException $e) {
      $conn->rollBack();
      return 0;
    }
  }

  function getZReport()
  {
    include "connection.php";
    try {
      $sql = "SELECT a.sale_id, d.user_fullname, a.sale_cashTendered, a.sale_change, a.sale_totalAmount, a.sale_date, 
      b.sale_item_productId, b.sale_item_quantity, b.sale_item_price, c.prod_name AS product_name FROM tbl_sales a 
      INNER JOIN tbl_sale_item b ON a.sale_id = b.sale_item_saleId 
      INNER JOIN tbl_products c ON b.sale_item_productId = c.prod_id 
      INNER JOIN tbl_users d ON a.sale_userId = d.user_id 
      WHERE a.sale_date = CURDATE() 
      ORDER BY a.sale_id, b.sale_item_productId";
      $stmt = $conn->prepare($sql);
      $stmt->execute();

      $sales = [];
      if ($stmt->rowCount() > 0) {
        $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rs as $row) {
          $saleId = $row['sale_id'];
          if (!isset($sales[$saleId])) {
            $sales[$saleId] = [
              'user_username' => $row['user_fullname'],
              'sale_cashTendered' => $row['sale_cashTendered'],
              'sale_change' => $row['sale_change'],
              'sale_totalAmount' => $row['sale_totalAmount'],
              'sale_date' => $row['sale_date'],
              'items' => []
            ];
          }
          $sales[$saleId]['items'][] = [
            'sale_item_productId' => $row['sale_item_productId'],
            'sale_item_quantity' => $row['sale_item_quantity'],
            'sale_item_price' => $row['sale_item_price'],
            'product_name' => $row['product_name']
          ];
        }
      }

      return json_encode(array_values($sales));
    } catch (PDOException $e) {
      return 0;
    }
  }

  function getZReportWithSelectedDate($json)
  {
    // {"date":"2024-08-06"}
    include "connection.php";
    $json = json_decode($json, true);
    try {
      $sql = "SELECT a.sale_id, d.user_fullname, a.sale_cashTendered, a.sale_change, a.sale_totalAmount, a.sale_date, 
      b.sale_item_productId, b.sale_item_quantity, b.sale_item_price, c.prod_name AS product_name FROM tbl_sales a 
      INNER JOIN tbl_sale_item b ON a.sale_id = b.sale_item_saleId 
      INNER JOIN tbl_products c ON b.sale_item_productId = c.prod_id 
      INNER JOIN tbl_users d ON a.sale_userId = d.user_id 
      WHERE DATE(a.sale_date) = :date 
      ORDER BY a.sale_date DESC";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(":date", $json["date"]);
      $stmt->execute();

      $sales = [];
      if ($stmt->rowCount() > 0) {
        $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rs as $row) {
          $saleId = $row['sale_id'];
          if (!isset($sales[$saleId])) {
            $sales[$saleId] = [
              'user_username' => $row['user_fullname'],
              'sale_cashTendered' => $row['sale_cashTendered'],
              'sale_change' => $row['sale_change'],
              'sale_totalAmount' => $row['sale_totalAmount'],
              'sale_date' => $row['sale_date'],
              'items' => []
            ];
          }
          $sales[$saleId]['items'][] = [
            'sale_item_productId' => $row['sale_item_productId'],
            'sale_item_quantity' => $row['sale_item_quantity'],
            'sale_item_price' => $row['sale_item_price'],
            'product_name' => $row['product_name']
          ];
        }
      }

      return json_encode(array_values($sales));
    } catch (PDOException $e) {
      return 0;
    }
  }

  function getShiftReport($json)
  {
    // {"userId":1}
    include "connection.php";
    $json = json_decode($json, true);
    try {
      $sql = "SELECT a.sale_id, d.user_fullname, a.sale_cashTendered, a.sale_change, a.sale_totalAmount, a.sale_date, 
      b.sale_item_productId, b.sale_item_quantity, b.sale_item_price, c.prod_name AS product_name FROM tbl_sales a 
      INNER JOIN tbl_sale_item b ON a.sale_id = b.sale_item_saleId 
      INNER JOIN tbl_products c ON b.sale_item_productId = c.prod_id 
      INNER JOIN tbl_users d ON a.sale_userId = d.user_id 
      WHERE d.user_id = :userId AND a.sale_date = CURDATE()
      ORDER BY a.sale_id, b.sale_item_productId";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(":userId", $json["userId"]);
      $stmt->execute();

      $sales = [];
      if ($stmt->rowCount() > 0) {
        $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rs as $row) {
          $saleId = $row['sale_id'];
          if (!isset($sales[$saleId])) {
            $sales[$saleId] = [
              'user_username' => $row['user_fullname'],
              'sale_cashTendered' => $row['sale_cashTendered'],
              'sale_change' => $row['sale_change'],
              'sale_totalAmount' => $row['sale_totalAmount'],
              'sale_date' => $row['sale_date'],
              'items' => []
            ];
          }
          $sales[$saleId]['items'][] = [
            'sale_item_productId' => $row['sale_item_productId'],
            'sale_item_quantity' => $row['sale_item_quantity'],
            'sale_item_price' => $row['sale_item_price'],
            'product_name' => $row['product_name']
          ];
        }
      }

      return json_encode(array_values($sales));
    } catch (PDOException $e) {
      return json_encode(['error' => $e->getMessage()]);
    }
  }
} //user

function getCurrentDate()
{
  $today = new DateTime("now", new DateTimeZone('Asia/Manila'));
  return $today->format('Y-m-d H:i:s');
}

$json = isset($_POST["json"]) ? $_POST["json"] : "0";
$operation = isset($_POST["operation"]) ? $_POST["operation"] : "0";

$sales = new Sales();

switch ($operation) {
  case "saveTransaction":
    echo $sales->saveTransaction($json);
    break;
  case "getZReport":
    echo $sales->getZReport();
    break;
  case "getShiftReport":
    echo $sales->getShiftReport($json);
    break;
  case "getZReportWithSelectedDate":
    echo $sales->getZReportWithSelectedDate($json);
    break;
  default:
    echo "Wala kay gi butang nga operation sa ubos HAHAHAHA bobo";
    break;
}
