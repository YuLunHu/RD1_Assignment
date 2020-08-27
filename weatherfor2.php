<?php
header("content-type:text/html; charset=utf-8");
session_start();

$cityName = $_SESSION['selectCity'];

$AuthCode = "CWB-378522C1-C8C0-4B22-AD32-584BE424FDB3";
$datastore = "F-D0047-089"; // 台灣各城市未來２天

$uri = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/" . $datastore .
  "?Authorization=" . $AuthCode .
  "&format=JSON" . 
  "&locationName=" . urlencode($cityName) .
  "&elementName=WeatherDescription" . 
  "&sort=time"; 

// 打api抓氣象資料
$json = file_get_contents($uri);
$obj = json_decode($json);
$weatherElement = $obj->records->locations[0]->location[0]->weatherElement[0]->time; //擷取需要使用的資料就好
unset($json, $obj);

// // 啟動與mysql連結
$link = @mysqli_connect("localhost", "root", "root", null, 8889) or die(mysqli_connect_error()); // 若是XAMPP就沒有密碼
mysqli_query($link, "set names utf8");
mysqli_select_db($link, "weatherDB");
$sqlCommand = "";

// 存資料到DB
for ($i = 0; $i < count($weatherElement); $i++) {
    $startTime = $weatherElement[$i]->startTime;
    $endTime = $weatherElement[$i]->endTime;
    $weatherDescription = $weatherElement[$i]->elementValue[0]->value;

    $sqlCommand = "INSERT INTO `weatherFor2` (`cityName`, `startTime`, `endTime`, `weatherDescription`) VALUES ('$cityName', '$startTime', '$endTime', '$weatherDescription')";
    mysqli_query($link, $sqlCommand);
}
mysqli_close($link);
?>