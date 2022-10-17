<!doctype html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Scorpio - Admin</title>
<!--  <link rel="stylesheet" href="/public/scorpio/css/bootstrap-grid.css">-->
  <link rel="stylesheet" href="/public/scorpio/css/bootstrap.css">
  <link rel="stylesheet" href="/public/scorpio/css/style.css">
</head>
<body>
<div class="container-fluid background-main">
  <div class="row">
    <div class="col top-panel">Top panel</div>
  </div>
  <div class="row">
    <div class="col-sm-2 sidebar">
      leftbar
    </div>
    <div class="col-sm-10 content">
      @section(page)
    </div>
  </div>
</div>
</body>
</html>