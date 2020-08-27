<?php
header("content-type:text/html; charset=utf-8");
session_start();

$cityName = $_SESSION['selectCity'];

$AuthCode = "CWB-378522C1-C8C0-4B22-AD32-584BE424FDB3";
$datastore = "F-C0032-001"; // 一般天氣預報-今明 36 小時天氣預報

$uri = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/" . $datastore .
  "?Authorization=" . $AuthCode .
  "&format=JSON" . 
  "&locationName=". urlencode($cityName) . 
  "&sort=time"; 

// 打api抓氣象資料
$json = file_get_contents($uri);
$obj = json_decode($json);

$weatherElement = $obj->records->location[0]->weatherElement; //擷取需要使用的資料就好
unset($json, $obj);

$Wx = array();
$PoP = array();
$MinT = array();
$MaxT = array();
$CI = array();
$startTime = array();
$endTime = array();

// 將資料存放到各個陣列
for ($i = 0; $i < count($weatherElement); $i++) {
    $elementName = $weatherElement[$i]->elementName;
    for ($j = 0; $j < count($weatherElement[$i]->time); $j++) {
        if (count($startTime) != count($weatherElement[$i]->time)) { // 判斷時間已達到足夠的量
            array_push($startTime, $weatherElement[$i]->time[$j]->startTime);
            array_push($endTime, $weatherElement[$i]->time[$j]->endTime);
        }
        $parameterName = $weatherElement[$i]->time[$j]->parameter->parameterName;
        switch ($elementName) {
            case "Wx":
                array_push($Wx, $parameterName);
                break;
            case "PoP":
                array_push($PoP, $parameterName);
                break;
            case "MinT":
                array_push($MinT, $parameterName);
                break;
            case "MaxT":
                array_push($MaxT, $parameterName);
                break;
            case "CI":
                array_push($CI, $parameterName);
                break;
        }
    }
}

// 啟動與mysql連結
$link = @mysqli_connect("localhost", "root", "root", null, 8889) or die(mysqli_connect_error()); // 若是XAMPP就沒有密碼
mysqli_query($link, "set names utf8");
mysqli_select_db($link, "weatherDB");
$sqlCommand = "";

// 存進DB
for ($i = 0; $i < count($startTime); $i++) {
    $sqlCommand = "INSERT INTO `realTimeWeather` (`cityName`, `startTime`, `endTime`, `Wx`, `PoP`, `MinT`, `MaxT`, `CI`) VALUES ('$cityName', '$startTime[$i]', '$endTime[$i]', '$Wx[$i]', '$PoP[$i]', '$MinT[$i]', '$MaxT[$i]', '$CI[$i]')";
    mysqli_query($link, $sqlCommand);
}
mysqli_close($link);
?>