<?php
header("content-type:text/html; charset=utf-8");

$AuthCode = "CWB-378522C1-C8C0-4B22-AD32-584BE424FDB3";
$datastore = "F-D0047-073"; // 決定要哪個縣市及決定未來一週的資料
$limit = 1;
$locationName = "臺中市";

$uri = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/" . $datastore .
  "?Authorization=" . $AuthCode .
  "&limit=" . $limit .
  "&offset=0&format=JSON" . 
  "&elementName=WeatherDescription" . 
  "&sort=time"; 

// 打api抓氣象資料
$json = file_get_contents($uri);
$obj = json_decode($json);
$weatherElement = $obj->records->locations[0]->location[0]->weatherElement; //擷取需要使用的資料就好

// 啟動與mysql連結
$link = @mysqli_connect("localhost", "root", "root", null, 8889) or die(mysqli_connect_error()); // 若是XAMPP就沒有密碼
mysqli_query($link, "set names utf8");
mysqli_select_db($link, "weatherDB");
$sqlCommand = "";

// 存資料到DB
for ($i = 0; $i < count($weatherElement[0]->time); $i++) {
  for ($j = 0; $j < count($weatherElement[0]->time[$i]->elementValue); $j++) {
    $weatherDescription = $weatherElement[0]->time[$i]->elementValue[$j]->value;
    $startTime = $weatherElement[0]->time[$i]->startTime;
    $endTime = $weatherElement[0]->time[$i]->endTime;
    $sqlCommand = "INSERT INTO `weatherFor2` (`startTime`, `endTime`, `WeatherDescription`) VALUES ('$startTime', '$endTime', '$weatherDescription')";
    mysqli_query($link, $sqlCommand);
  }
}
mysqli_close($link);

?>
</body>