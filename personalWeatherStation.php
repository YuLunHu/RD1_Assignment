<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="style.css" rel="stylesheet" type="text/css">
  <title>個人氣象站</title>
</head>

<body>

  <form>
    <div class="form-group row">
      <label class="col-4 col-form-label" for="selectCity">縣市:</label>
      <select id="selectCity" name="selectCity" class="col-2 custom-select">
        <option value="Taichung">台中市</option>
        <option value="duck">Duck</option>
        <option value="fish">Fish</option>
      </select>
      <button name="submit" type="submit" class="btn btn-primary">Submit</button>
    </div>
  </form>

  <div id="selectedLocation"></div>
  <!--選到的話會看到-->
  <div id="resultTable"></div>

  <script>

// onchange
    // $(document).ready(function () {
    //   $("#selectCity").on('click', function () {
    //     for (var i = 0, len = sel.options.length; i < len; i++) {
    //       opt = sel.options[i];
    //       if (opt.selected === true) {
    //         break;
    //       }
    //     }
    //   })
    // })
  </script>

<?php
header("content-type:text/html; charset=utf-8");

$AuthCode = "CWB-378522C1-C8C0-4B22-AD32-584BE424FDB3";
$datastore = "F-D0047-073";
$limit = 1;
$locationName = "臺中市";

$uri = "https://opendata.cwb.gov.tw/api/v1/rest/datastore/" . $datastore .
  "?Authorization=" . $AuthCode .
  "&limit=" . $limit .
  "&offset=0&format=JSON" . 
  "&elementName=WeatherDescription" . 
  "&sort=time"; 

// $json = file_get_contents($uri);
// $obj = json_decode($json);
// $weatherElement = $obj->records->locations[0]->location[0]->weatherElement; //擷取需要使用的資料就好

// for ($i = 0; $i < count($weatherElement[0]->time); $i++) {
//   for ($j = 0; $j < count($weatherElement[0]->time[$i]->elementValue); $j++) {
//     echo $weatherElement[0]->time[$i]->elementValue[$j]->value . "<br>";
//   }
// }

// 將資料存到DB
$link = @mysqli_connect("localhost", "root", "root", null, 8889) or die(mysqli_connect_error()); // 若是XAMPP就沒有密碼
$result = mysqli_query($link, "set names utf8");
mysqli_select_db($link, "weatherDB");

$sql = <<<multi
INSERT INTO `weatherFor2` (`startTime`, `endTime`, `WeatherDescription`)
VALUES ('2020-08-25 06:00:00', '2020-08-25 09:00:00', '晴。降雨機率 20%。溫度攝氏27度。悶熱。偏南風 平均風速3-4級(每秒6公尺)。相對濕度87%。')
multi;

$result = mysqli_query($link, $commandText);

// while ($row = mysqli_fetch_assoc($result))
// {
//   echo "wID：{$row['wID']}<br>";
//   echo "startTime: {$row['startTime']}<br>";
//   echo "endTime: {$row['endTime']}<br>";
//   echo "WeatherDescription：{$row['WeatherDescription']}<br>";
//   echo "<HR>";
// }

mysqli_close($link);

?>
</body>

</html>