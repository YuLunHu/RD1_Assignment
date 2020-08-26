<?php
// require_once('realTimeWeather.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="style.css" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="jquery.js"></script>
  <title>個人氣象站</title>
</head>

<body>

  <form>
    <div class="form-group row">
      <label class="col-4 col-form-label" for="selectCity">縣市:</label>
      <select id="selectCity" name="selectCity" class="col-2 custom-select">
        <option value="">--</option>
      </select>
      <select id="selectData" name="selectData" class="col-2 custom-select">
        <option value="">--</option>
      </select>
      <button id="OKbtn" name="OKbtn" type="button" class="btn btn-primary" value="OK" onclick="Query()">OK</button>
    </div>
  </form>

  <div id="queryResult"><b>Query Result be here...</b></div>

  <p id="demo">Click the button to get your position.</p>
  <button onclick="getLocation()">Try It</button>
  <div id="LongLat"></div>

  <script>
    // 建立選單選項
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

    function Query() {
      if ($("#selectCity").val() != "" && $("#selectData").val() != "") {
        console.log("OK");

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            var x = document.getElementById("queryResult").innerHTML = this.responseText;
            console.log(x); // <-------現在到這裡
          }
        };
        xmlhttp.open("GET", $("#selectData").val() + ".php?city=" + $("#selectCity").val(), true);
        xmlhttp.send();
      }
      else {
        console.log("NO");
      }
    }

  </script>

  <!-- 抓經緯度 -->
  <script>
    var x = document.getElementById("demo");

    function getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
      } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
      }
    }

    function showPosition(position) {
      var latlon = position.coords.latitude + "," + position.coords.longitude;
      document.getElementById("LongLat").innerHTML = latlon;
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