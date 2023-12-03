<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      margin: 0;
      padding: 0;
      background-image: url('img/dashboard_bg.gif');
      background-size: cover;
      background-repeat: no-repeat;
    }

    .container {
      background-color: rgba(0, 0, 0, 0.7);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      flex-direction: column;
    }

    .text-white {
      color: white;
    }

    .text-3xl {
      font-size: 24px;
    }

    .mt-3 {
      margin-top: 12px;
    }

    .underline {
      text-decoration: underline;
    }
  </style>
</head>
<body>
    <div class="container">
        <span class="text-white text-3xl">Sorry, you need to be logged in to view this page.</span>
        <a href="index.php" class="mt-3 text-white underline">Back to home</a>
    </div>
</body>
</html>
