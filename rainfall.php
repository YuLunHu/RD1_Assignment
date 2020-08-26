<?php
header("content-type:text/html; charset=utf-8");

$cityName = $_GET["city"]; // GET被選擇的城市

$AuthCode = "CWB-378522C1-C8C0-4B22-AD32-584BE424FDB3";
$datastore = "O-A0002-001"; // 自動雨量站資料-無人自動站雨量資料

$uri = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/" . $datastore .
  "?Authorization=" . $AuthCode .
  "&format=JSON" . "&elementName=RAIN,HOUR_24" . "&parameterName=CITY,TOWN"; 

// 打api抓雨量資料
$json = file_get_contents($uri);
$obj = json_decode($json);
$rainfall = $obj->records->location; //擷取需要使用的資料就好
unset($json, $obj);

// 啟動與mysql連結
$link = @mysqli_connect("localhost", "root", "root", null, 8889) or die(mysqli_connect_error()); // 若是XAMPP就沒有密碼
mysqli_query($link, "set names utf8");
mysqli_select_db($link, "weatherDB");
$sqlCommand = "";

// 存資料到DB
for ($i = 0; $i < count($rainfall); $i++) {
    $locationName = $rainfall[$i]->locationName;
    $obsTime = $rainfall[$i]->time->obsTime;
    $hour_1 = $rainfall[$i]->weatherElement[0]->elementValue;
    $hour_24 = $rainfall[$i]->weatherElement[1]->elementValue;
    $city = $rainfall[$i]->parameter[0]->parameterValue;
    $town = $rainfall[$i]->parameter[1]->parameterValue;

    $sqlCommand = "INSERT INTO `rainfall` (`locationName`, `cityName`, `town`, `obsTime`, `hour_1`, `hour_24`) VALUES ('$locationName', '$city', '$town', '$obsTime', '$hour_1', '$hour_24')";
    mysqli_query($link, $sqlCommand);
}
mysqli_close($link);
?>