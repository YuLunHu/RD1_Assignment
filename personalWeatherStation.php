<?php
session_start();

// $datetime = date("Y-m-d H:i:s", mktime(date('H')+8, date('i'), date('s'), date('m'), date('d'), date('Y')));
// echo $datetime; // 看時間

if (isset($_POST["OKbtn"])) // 按下按鈕後去要資料
{
  if ($_POST["selectCity"] != "" && $_POST["selectData"] != "")
  {
    $_SESSION['selectCity'] = $_POST["selectCity"];
    $_SESSION['selectData'] = $_POST["selectData"];

    require($_POST["selectData"] . ".php");
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="js/jquery.js"></script>
  <title>個人氣象站</title>
</head>

<body>
  <form method="POST" action="personalWeatherStation.php">
    <!-- 經緯度 -->
    <div style="text-align:center">
      　<div id="LatLong" name="LatLong" style="margin:0 auto; width:150px;"></div>
    </div>
    <div class="form-group row">
      <label class="col-4 col-form-label" for="selectCity">縣市:</label>
      <select id="selectCity" name="selectCity" class="col-2 custom-select">
        <option value="">--</option>
      </select>
      <select id="selectData" name="selectData" class="col-2 custom-select">
        <option value="">--</option>
      </select>
      <button id="OKbtn" name="OKbtn" type="submit" class="btn btn-primary" value="OK">OK</button>
    </div>
  </form>

<div class="landscape" style="margin:15px">
  <img id="cityImage" <?php if ($_POST["selectCity"] != "") {
    echo "src=images/" . $_POST["selectCity"] . ".jpg";
  } ?> width="200" style="display:block; margin:auto;">
</div>
  
  <div id="queryTable">
    <table class="table table-striped version_5 href-tr" id="sortTable">
      <thead>
        <tr>
          <?php switch ($_POST["selectData"]) {

            case "realTimeWeather": ?>
          <!-- 當前天氣狀況 -->
          <th scope="col" id="cityName" class="height-100">縣市</th>
          <th scope="col" id="startTime">開始時間</th>
          <th scope="col" id="endTime">結束時間</th>
          <th scope="col" id="Wx">天氣現象</th>
          <th scope="col" id="MaxT">最高溫度</th>
          <th scope="col" id="MinT">最低溫度</th>
          <th scope="col" id="CI">舒適度</th>
          <th scope="col" id="PoP">降雨機率</th>
        </tr>
      </thead>
      <tbody id="queryResult">
        <?php for ($i = 0; $i < count($startTime); $i++) { ?>
        <tr>
          <th scope="col" id="cityName" class="height-100"><?=$cityName?></th>
          <th scope="col" id="startTime"><?=$startTime[$i]?></th>
          <th scope="col" id="endTime"><?=$endTime[$i]?></th>
          <th scope="col" id="Wx"><?=$Wx[$i]?></th>
          <th scope="col" id="MaxT"><?=$MaxT[$i]?></th>
          <th scope="col" id="MinT"><?=$MinT[$i]?></th>
          <th scope="col" id="CI"><?=$CI[$i]?></th>
          <th scope="col" id="PoP"><?=$PoP[$i]?></th>
        </tr>
        <?php } break; ?>

        <?php case "weatherFor2": ?>
        <!-- 未來兩天天氣預報 -->
        <th scope="col" id="cityName" class="height-100">縣市</th>
        <th scope="col" id="startTime">開始時間</th>
        <th scope="col" id="endTime">結束時間</th>
        <th scope="col" id="weatherDescription">天氣描述</th>
        </tr>
        </thead>
      <tbody id="queryResult">
        <?php for ($i = 0; $i < count($weatherElement); $i++) { ?>
        <tr>
          <th scope="col" id="cityName" class="height-100"><?=$cityName?></th>
          <th scope="col" id="startTime"><?=$weatherElement[$i]->startTime?></th>
          <th scope="col" id="endTime"><?=$weatherElement[$i]->endTime?></th>
          <th scope="col" id="weatherDescription"><?=$weatherElement[$i]->elementValue[0]->value?></th>
        </tr>
        <?php } break; ?>

        <?php case "weatherForWeek": ?>
        <!-- 未來一週天氣預報 -->
        <th scope="col" id="cityName" class="height-100">縣市</th>
        <th scope="col" id="startTime">開始時間</th>
        <th scope="col" id="endTime">結束時間</th>
        <th scope="col" id="weatherDescription">天氣描述</th>
        </tr>
        </thead>
      <tbody id="queryResult">
        <?php for ($i = 0; $i < count($weatherElement); $i++) { ?>
        <tr>
          <th scope="col" id="cityName" class="height-100"><?=$cityName?></th>
          <th scope="col" id="startTime"><?=$weatherElement[$i]->startTime?></th>
          <th scope="col" id="endTime"><?=$weatherElement[$i]->endTime?></th>
          <th scope="col" id="weatherDescription"><?=$weatherElement[$i]->elementValue[0]->value?></th>
        </tr>
        <?php } break; ?>

        <?php case "rainfall": ?>
        <!-- 雨量資料 -->
        <th scope="col" id="locationyName" class="height-100">測站名稱</th>
        <th scope="col" id="cityName">縣市</th>
        <th scope="col" id="town">鄉鎮市區</th>
        <th scope="col" id="obsTime">測量時間</th>
        <th scope="col" id="hour_1">過去1小時累積雨量(毫米)</th>
        <th scope="col" id="hour_24">過去24小時累積雨量(毫米)</th>
        </tr>
        </thead>
      <tbody id="queryResult">
        <?php for ($i = 0; $i < count($rainfall); $i++) {
          if ($rainfall[$i]->parameter[0]->parameterValue == $_SESSION['selectCity'] ) { ?>
        <!-- ^過濾縣市資料 -->
        <tr>
          <th scope="col" id="locationyName" class="height-100"><?=$locationName = $rainfall[$i]->locationName?></th>
          <th scope="col" id="cityName"><?=$rainfall[$i]->parameter[0]->parameterValue?></th>
          <th scope="col" id="town"><?=$rainfall[$i]->parameter[1]->parameterValue?></th>
          <th scope="col" id="obsTime"><?=$rainfall[$i]->time->obsTime?></th>
          <th scope="col" id="hour_1"><?php 
          if ($rainfall[$i]->weatherElement[0]->elementValue < 0) {
            echo "該時刻因故無資料";
          } elseif ($rainfall[$i]->weatherElement[0]->elementValue == -998.00) {
            echo "過去6小時累積雨量為0";
          } else {
            echo $rainfall[$i]->weatherElement[0]->elementValue;
          }?></th>
          <th scope="col" id="hour_24"><?php 
          if ($rainfall[$i]->weatherElement[1]->elementValue < 0) {
            echo "該時刻因故無資料";
          } elseif ($rainfall[$i]->weatherElement[1]->elementValue == -998.00) {
            echo "過去6小時累積雨量為0";
          } else {
            echo $rainfall[$i]->weatherElement[1]->elementValue;
          }?></th>
        </tr>
        <?php }?>
        <?php } break; ?>

        <?php } ?>
      </tbody>
    </table>
  </div>

  <script>
    alert('Jquery:'+ $.fn.jquery);
    // 建立下拉式選單的選項
    const cityName = { 宜蘭縣: "宜蘭縣", 花蓮縣: "花蓮縣", 臺東縣: "臺東縣", 澎湖縣: "澎湖縣", 金門縣: "金門縣", 連江縣: "連江縣", 臺北市: "臺北市", 新北市: "新北市", 桃園市: "桃園市", 臺中市: "臺中市", 臺南市: "臺南市", 高雄市: "高雄市", 基隆市: "基隆市", 新竹縣: "新竹縣", 新竹市: "新竹市", 苗栗縣: "苗栗縣", 彰化縣: "彰化縣", 南投縣: "南投縣", 雲林縣: "雲林縣", 嘉義縣: "嘉義縣", 嘉義市: "嘉義市", 屏東縣: "屏東縣" };
    for (var key in cityName) {
      addOption("selectCity", key, cityName[key]);
    }
    const weatherData = { 當前天氣狀況: "realTimeWeather", 未來2天天氣預報: "weatherFor2", 未來1週天氣預報: "weatherForWeek", 過去1小時累積雨量: "rainfall", 過去24小時累積雨量: "rainfall" };
    for (var key in weatherData) {
      addOption("selectData", key, weatherData[key]);
    }

    function addOption(objId, text, val) {
      var obj = document.getElementById(objId);
      var objOption = new Option(text, val);
      obj.options.add(objOption);
      objOption = null;
      obj = null;
    }

    $("#selectCity").change(function() {
      var cityImagePath = "images/" + $("#selectCity").val() + ".jpg";
      $("#cityImage").attr("src", cityImagePath);
      $("#cityImage").css('visibility','visible');
    });
  </script>

  <!-- 抓經緯度 -->
  <script>
    getLocation();

    function getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
      } else {
        alert("您的瀏覽器不支援地理資訊");
      }
    }

    function showPosition(position) {
      var latlon = position.coords.latitude + "," + position.coords.longitude;
      document.getElementById("LatLong").innerHTML = latlon;
    }

    function showError(error) {
      switch (error.code) {
        case error.PERMISSION_DENIED:
          x.innerHTML = "User denied the request for Geolocation."
          break;
        case error.POSITION_UNAVAILABLE:
          x.innerHTML = "Location information is unavailable."
          break;
        case error.TIMEOUT:
          x.innerHTML = "The request to get user location timed out."
          break;
        case error.UNKNOWN_ERROR:
          x.innerHTML = "An unknown error occurred."
          break;
      }
    }

  </script>
</body>

</html>