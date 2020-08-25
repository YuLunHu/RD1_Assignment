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
        <option value="臺中市">臺中市</option>
        <option value="臺南市">臺南市</option>
        <option value="臺北市">臺北市</option>
      </select>
      <button name="submit" type="submit" class="btn btn-primary" value="1">Submit</button>
    </div>
  </form>

  <div id="selectedLocation"></div>
  <div id="resultTable"></div>

  <script>

// onchange
//     $(document).ready(function () {
//       $("#selectCity").on('click', function () {
//         for (var i = 0, len = sel.options.length; i < len; i++) {
//           opt = sel.options[i];
//           if (opt.selected === true) {
//             break;
//           }
//         }
//       })
//     })
  </script>

<?php
// if (isset(selectCity=臺中市&submit=1))
require_once('realTimeWeather.php');
// require_once('weatherfor2.php');
// echo $startTime;
// echo urlencode("臺中市");
?>
</body>

</html>