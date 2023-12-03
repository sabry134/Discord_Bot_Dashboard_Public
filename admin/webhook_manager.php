<?php
session_start();

if (!$_SESSION['logged_in']) {
  header('Location: error.php');
  exit();
}

extract($_SESSION['userData']);

$avatar_url = "https://cdn.discordapp.com/avatars/$discord_id/$avatar.jpg";
?>

<!DOCTYPE html>
<html>

<head>
  <title>Bot Dashboard Webhook</title>
  <link rel="icon" type="image/png" href="img/Sparkles.png">
  <style>
    body {
      background-image: url('img/dashboard_bg.gif');
      background-size: cover;
      background-position: center;
      margin: 0;
      padding: 0;
      position: relative;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: Arial, sans-serif;
    }

    .container {
      text-align: center;
      background-color: rgba(255, 255, 255, 0.5);
      padding: 20px;
      border-radius: 10px;
      max-width: 400px;
      margin-top: 15%;
      margin-left: 40%;
    }

    .center {
      margin-top: -40%;
      text-align: center;
      font-size: 50px;
      padding: 10px;
      margin-right: 10px;
      color: white;
      z-index: 1;
    }

    h1 {
      color: black;
    }

    .input-container {
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 20px 0;
    }

    .input-field {
      padding: 10px;
      margin: 5px;
      border: none;
      border-radius: 5px;
      width: 300px;
    }

    .button {
      background-color: #7289DA;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .message-success {
      background-color: #4CAF50;
      color: white;
      padding: 10px;
      border-radius: 5px;
      display: none;
    }

    .message-error {
      background-color: #FF5733;
      color: white;
      padding: 10px;
      border-radius: 5px;
      display: none;
    }

    .avatar {
      border-radius: 50%;
      width: 48px;
      height: 48px;
      margin-right: 10px;
    }

    .username-container {
      background-color: white;
      padding: 10px;
      border-radius: 5px;
      display: flex;
      align-items: center;
      cursor: pointer;
    }

    .username {
      color: #000;
      display: inline;
    }

    .top-right {
      position: absolute;
      top: 20px;
      right: 20px;
      display: flex;
      align-items: center;
    }

    .top-left {
      position: absolute;
      top: 20px;
      left: 20px;
    }

    .back-button {
      background-color: #7289DA;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
    }

    .logout-button {
      display: none;
      background-color: #FF5733;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      position: absolute;
      top: 80px;
      right: 20px;
    }

    .username-container.clicked .logout-button {
      display: block;
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

    .hidden-text.collapsed {
      display: none;
    }

    .commands-text.collapsed {
      display: none;
    }

    .status-text.collapsed {
      display: none;
    }

    .alert-text.collapsed {
      display: none;
    }

    .rectangle {
      background-color: #333;
      height: 120px;
      width: 100%;
      position: fixed;
      top: 0;
      z-index: 0;
    }

    .settings-text.collapsed {
      display: none;
    }

    .settings-text.collapsed {
      display: none;
    }

    .menu-items.collapsed {
      display: none;
    }

    .area-text {
      display: block;
    }

    .user-text {
      display: block;
    }

    .manage-text {
      display: block;
    }

    .hidden-text,
    .commands-text,
    .status-text,
    .alert-text,
    .documentation-text,
    .message-text,
    .area-text,
    .user-text,
    .request-text,
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

    .request-text {
      display: block;
    }
  </style>
</head>

<body>
  <h1 class="center">Bot Dashboard</h1>
  <div class="background-overlay">
    <div class="rectangle"></div>
    <div class="container">
      <div class="top-right">
        <div class="username-container" onclick="toggleLogout()">
          <img class="avatar" src="<?php echo $avatar_url; ?>" />
          <span class="username"><?php echo $name; ?></span>
          <div class="logout-button" onclick="location.href='logout.php'">Logout</div>
        </div>
      </div>
      <h1>Webhook Manager</h1>

      <div class="input-container">
        <input type="text" class="input-field" placeholder="Webhook URL" id="webhookUrl">
        <button class="button" onclick="savePreference()">Save</button>
      </div>

      <div class="input-container">
        <input type="text" class="input-field" placeholder="Message" id="message">
        <button class="button" onclick="sendMessage()">Send</button>
      </div>

      <div class="message-success" id="successMessage">Preference updated!</div>
      <div class="message-error" id="errorMessage">Invalid URL</div>
    </div>

    <div class="menu">
      <div class="menu-title" onclick="toggleMenu()">☰</div>
      <div class="menu-items">
        <a class="status-text" href="dashboard.php">Dashboard</a>
        <a class="hidden-text" href="webhook_manager.php">Manage Webhooks</a>
        <a class="commands-text" href="commands.php">Commands</a>
        <a class="alert-text" href="alerts.php">Alerts</a>
        <a class="message-text" href="message.php">Send a message</a>
        <a class="documentation-text" href="documentation.php">Staff documentation</a>
        <a class="area-text" href="area.php">AREA</a>
        <a class="request-text" href="requests.php">Inbox</a>
        <a class="settings-text" href="settings.php">Settings</a>
        <a class="manage-text" href="manage_bot.php">Manage Servers</a>
        <a class="user-text" href="../user/index.php">User Dashboard</a>
      </div>
    </div>
  </div>

  <script>
    function showSuccessMessage(message) {
      var successMessage = document.getElementById("successMessage");
      successMessage.innerHTML = message;
      successMessage.style.backgroundColor = "#4CAF50";
      successMessage.style.display = "block";
      setTimeout(function() {
        successMessage.style.display = "none";
      }, 3000);
    }

    function showErrorMessage(message) {
      var errorMessage = document.getElementById("errorMessage");
      errorMessage.innerHTML = message;
      errorMessage.style.backgroundColor = "#FF5733";
      errorMessage.style.display = "block";
      setTimeout(function() {
        errorMessage.style.display = "none";
      }, 3000);
    }

    function savePreference() {
      var webhookUrl = document.getElementById("webhookUrl").value;

      if (/^https?:\/\/\S+$/.test(webhookUrl)) {
        showSuccessMessage("Preference updated!");
      } else {
        showErrorMessage("Invalid URL");
      }
    }

    function sendMessage() {
      var message = document.getElementById("message").value;
      var webhookUrl = document.getElementById("webhookUrl").value;

      fetch(webhookUrl, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            content: message
          }),
        })
        .then(response => {
          if (response.ok) {
            showSuccessMessage("Message sent!");
          } else {
            showErrorMessage("Failed to send message");
          }
        })
        .catch(error => {
          showErrorMessage("Failed to send message");
        });
    }

    function toggleLogout() {
      var usernameContainer = document.querySelector(".username-container");
      usernameContainer.classList.toggle('clicked');
    }

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