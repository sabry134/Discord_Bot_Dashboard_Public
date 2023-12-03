<?php
session_start();

if (!$_SESSION['logged_in']) {
  header('Location: error.php');
  exit();
}

extract($_SESSION['userData']);

$avatar_url = "https://cdn.discordapp.com/avatars/$discord_id/$avatar.jpg";

$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
  $envContents = file_get_contents($envFile);
  $envLines = explode("\n", $envContents);

  foreach ($envLines as $line) {
    list($key, $value) = explode('=', $line, 2);
    $_ENV[trim($key)] = trim($value);
  }
}

$client_id = $_ENV['CLIENT_ID'] ?? null;

if (!$client_id) {
  die("CLIENT_ID not found in .env file.");
}

$invite_bot_link = "https://discord.com/api/oauth2/authorize?client_id=$client_id&permissions=8&scope=bot";
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bot Dashboard</title>
  <link rel="icon" type="image/png" href="img/Sparkles.png">
  <script>
    var botState = 'offline';

    function toggleBot() {
      var button = document.getElementById('bot-button');
      var statusDot = document.getElementById('status-dot');
      var statusText = document.getElementById('status-text');

      if (botState === 'offline') {
        fetch('http://localhost:3000/start', {
          method: 'POST',
        }).then(function(response) {
          if (response.ok) {
            button.textContent = "Stop bot";
            botState = 'online';
            statusText.textContent = 'Your bot is online';
            statusDot.style.backgroundColor = 'green';
            localStorage.setItem('botState', botState);
          } else {
            alert('Failed to start the bot.');
          }
        });
      } else {
        fetch('http://localhost:3000/stop', {
          method: 'POST',
        }).then(function(response) {
          if (response.ok) {
            button.textContent = "Start bot";
            botState = 'offline';
            statusText.textContent = 'Your bot is offline';
            statusDot.style.backgroundColor = 'red';
            localStorage.setItem('botState', botState);
          } else {
            alert('Failed to stop the bot.');
          }
        });
      }
    }

    window.addEventListener('load', function() {
      botState = localStorage.getItem('botState') || 'offline';
      var button = document.getElementById('bot-button');
      var statusDot = document.getElementById('status-dot');
      var statusText = document.getElementById('status-text');

      if (botState === 'online') {
        button.textContent = "Stop bot";
        statusText.textContent = 'Your bot is online';
        statusDot.style.backgroundColor = 'green';
      }
    });

    function toggleLogout() {
      var usernameContainer = document.querySelector(".username-container");
      usernameContainer.classList.toggle('clicked');
      var logoutButton = document.querySelector(".logout-button");
      logoutButton.classList.toggle('show-logout');
    }
  </script>

  <style>
    body {
      background-image: url('img/dashboard_bg.gif');
      background-size: cover;
      background-position: center;
      margin: 0;
      padding: 0;
      position: relative;
      height: 100vh;
      background-color: rgba(0, 0, 0, 0.8);
    }

    .header {
      background-color: #333;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100px;
      z-index: 0;
      padding: 10px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .top-right {
      display: flex;
      align-items: center;
      margin-right: 20px;
    }

    .avatar {
      border-radius: 50%;
      width: 48px;
      height: 48px;
      margin-right: 10px;
    }

    .username {
      color: black;
      display: inline;
    }

    .logout-button {
      display: none;
      background-color: #FF5733;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .show-logout {
      display: block;
    }

    .menu {
      position: fixed;
      left: 0;
      top: 0;
      background: #333;
      color: #fff;
      width: 120px;
      height: 100%;
      padding: 20px;
      transition: width 0.3s;
      z-index: 1;
    }

    .menu.collapsed {
      width: 30px;
    }

    .menu-title {
      cursor: pointer;
    }

    .menu-title:hover {
      text-decoration: underline;
    }

    .menu-items {
      display: block;
      margin-left: 5px;
      opacity: 1;
      transition: opacity 0.3s;
      margin-top: 70%;
    }

    .menu-items.collapsed {
      display: none;
      opacity: 0;
    }

    .menu-items a {
      text-decoration: none;
      color: #fff;
      display: block;
      margin-top: 20px;
      cursor: pointer;
      font-size: 18px;
    }

    .menu-title.collapsed+.menu-items {
      display: none;
    }

    .menu-title:not(.collapsed)+.menu-items {
      display: block;
    }

    .hidden-text {
      display: block;
      font-weight: bold;
    }

    .hidden-text.collapsed {
      display: none;
    }

    .commands-text {
      display: block;
      font-weight: bold;
    }

    .commands-text.collapsed {
      display: none;
    }

    .status-text {
      display: block;
      font-weight: bold;
    }

    .status-text.collapsed {
      display: none;
    }

    .alert-text {
      display: block;
      font-weight: bold;
    }

    .alert-text.collapsed {
      display: none;
    }

    .container {
      margin-left: 80px;
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      justify-content: flex-start;
      padding: 20px;
      transition: margin-left 0.3s;
    }

    .container.collapsed {
      margin-left: 10px;
    }

    .top-right {
      position: absolute;
      top: 20px;
      right: 20px;
      display: flex;
      align-items: center;
    }

    .welcome-box {
      background-color: rgba(255, 255, 255, 0.5);
      padding: 50px;
      border-radius: 10px;
      margin-top: 15%;
      text-align: center;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: auto;
      margin-right: 35%;
      position: fixed;
      z-index: 1;
    }

    .welcome-text {
      color: #fff;
      font-size: 24px;
      font-weight: bold;
      margin-left: auto;
    }

    .dashboard-button {
      margin-top: auto;
      background-color: #7289DA;
      color: #fff;
      padding: 8px 16px;
      border: none;
      border-radius: 5px;
      margin-right: auto;
    }

    .dashboard-button:hover {
      cursor: pointer;
    }

    .user-info {
      background-color: white;
      padding: 10px;
      border-radius: 5px;
      position: relative;
    }

    .username-container {
      background-color: white;
      padding: 10px;
      border-radius: 5px;
      display: flex;
      align-items: center;
      cursor: pointer;
    }

    .bot-status {
      display: flex;
      align-items: center;
      margin-top: 20px;
    }

    .status-dot {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      margin-right: 10px;
    }

    #status-dot {
      background-color: red;
    }

    #status-text {
      font-size: 24px;
      font-weight: bold;
    }

    .center {
      margin-top: 10px;
      text-align: center;
      font-size: 50px;
      padding: 10px;
      margin-right: 42%;
      color: white;
      z-index: 1;
    }

    .settings-text {
      display: block;
      font-weight: bold;
    }

    .documentation-text {
      display: block;
      font-weight: bold;
    }

    .settings-text.collapsed {
      display: none;
    }

    .menu-items.collapsed {
      display: none;
    }

    .message-text {
      font-weight: bold;
    }

    .area-text {
      display: block;
      font-weight: bold;
    }

    .request-text {
      display: block;
      font-weight: bold;
    }

    .user-text {
      display: block;
      font-weight: bold;
    }

    .manage-text {
      display: block;
      font-weight: bold;
    }


    .hidden-text,
    .commands-text,
    .status-text,
    .alert-text,
    .documentation-text,
    .message-text,
    .area-text,
    .request-text,
    .user-text,
    .manage-text,
    .settings-text {
      display: block;
    }

    .hidden-text.collapsed,
    .commands-text.collapsed,
    .status-text.collapsed,
    .alert-text.collapsed,
    .documentation-text.collapsed,
    .message-text.collapsed,
    .area-text.collapsed,
    .request-text.collapsed,
    .user-text.collapsed,
    .manage-text.collapsed,
    .settings-text.collapsed {
      display: none;
    }

    .invite-button {
      background-color: #7289DA;
      color: #fff;
      padding: 8px 16px;
      border: none;
      border-radius: 5px;
      margin-left: 170px;
      text-decoration: none;
    }

    .invite-button:hover {
      cursor: pointer;
    }

    .background-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.4);
    }

    .menu-items a:hover {
      background-color: #555;
    }
  </style>
</head>

<body>
  <div class="background-overlay"></div>
  <div class="header">
    <a href="<?php echo $invite_bot_link; ?>" target="_blank" class="invite-button">Invite bot</a>
    <div class="top-right">
      <div class="username-container" onclick="toggleLogout()">
        <img class="avatar" src="<?php echo $avatar_url; ?>" />
        <span class="username"><?php echo $name; ?></span>
        <div class="logout-button" onclick="location.href='logout.php'">Logout</div>
      </div>
    </div>
  </div>
  <div class="menu">
    <div class="menu-title" onclick="toggleMenu()">☰</div>
    <div class="menu-items">
      <a class="status-text" href="dashboard.php">Dashboard</a>
      <a class="commands-text" href="commands.php">Commands</a>
      <a class="hidden-text" href="webhook_manager.php">Manage Webhooks</a>
      <a class="manage-text" href="manage_bot.php">Manage Servers</a>
      <a class="message-text" href="message.php">Send a message</a>
      <a class="area-text" href="area.php">AREA</a>
      <a class="alert-text" href="alerts.php">Alerts</a>
      <a class="request-text" href="requests.php">Inbox</a>
      <a class="documentation-text" href="documentation.php">Staff documentation</a>
      <a class="settings-text" href="settings.php">Settings</a>
      <a class="user-text" href="../user/index.php">User Dashboard</a>
    </div>
  </div>
  <div class="container">
    <h1 class="center">Bot Dashboard</h1>
    <div class="welcome-box">
      <div>
        <h1>Your bot's name</h1>
        <div class="bot-status" id="bot-status">
          <div class="status-dot" id="status-dot"></div>
          <span id="status-text">Your bot is offline</span>
        </div>
        <p>This is your description about your bot, feel free to customize it</p>
        <button class="dashboard-button" id="bot-button" onclick="toggleBot()">Start bot</button>
      </div>
    </div>
  </div>

  <script>
    function toggleMenu() {
      var menu = document.querySelector('.menu');
      var menuItems = document.querySelector('.menu-items');
      var hiddenText = document.querySelector('.hidden-text');
      var commandsText = document.querySelector('.commands-text');
      var statusText = document.querySelector('.status-text');
      var alertText = document.querySelector('.alert-text');
      var settingsText = document.querySelector('.settings-text');
      var documentationText = document.querySelector('.documentation-text');
      var messageText = document.querySelector('.message-text');
      var areaText = document.querySelector('.area-text');
      var requestText = document.querySelector('.request-text');
      var userText = document.querySelector('.user-text');
      var manageText = document.querySelector('.manage-text');

      menu.classList.toggle('collapsed');
      const isCollapsed = menu.classList.contains('collapsed');

      if (isCollapsed) {
        hiddenText.classList.add('collapsed');
        commandsText.classList.add('collapsed');
        statusText.classList.add('collapsed');
        alertText.classList.add('collapsed');
        settingsText.classList.add('collapsed');
        documentationText.classList.add('collapsed');
        messageText.classList.add('collapsed');
        areaText.classList.add('collapsed');
        requestText.classList.add('collapsed');
        userText.classList.add('collapsed');
        manageText.classList.add('collapsed');
      } else {
        hiddenText.classList.remove('collapsed');
        commandsText.classList.remove('collapsed');
        statusText.classList.remove('collapsed');
        alertText.classList.remove('collapsed');
        settingsText.classList.remove('collapsed');
        documentationText.classList.remove('collapsed');
        messageText.classList.remove('collapsed');
        areaText.classList.remove('collapsed');
        requestText.classList.remove('collapsed');
        userText.classList.remove('collapsed');
        manageText.classList.remove('collapsed');
      }
    }
  </script>
</body>

</html>