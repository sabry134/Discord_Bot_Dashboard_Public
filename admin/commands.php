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
    }

    .header {
      background-color: #333;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100px;
      z-index: 100;
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
      z-index: 101;
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

    .menu-items a:hover {
      background-color: #555;
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

    .alert-text {
      display: block;
      font-weight: bold;
    }

    .alert-text.collapsed {
      display: none;
    }

    .settings-text {
      display: block;
      font-weight: bold;
    }

    .settings-text.collapsed {
      display: none;
    }

    .menu-items.collapsed {
      display: none;
    }

    .documentation-text {
      display: block;
      font-weight: bold;
    }

    .message-text {
      font-weight: bold;
    }

    .area-text {
      display: block;
      font-weight: bold;
    }

    .background-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.4);
      overflow: auto;
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

    .card-cont {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-around;
      height: 100%;
      margin: 0 0 0 165px;
    }

    .card {
      border: 3px solid gray;
      border-radius: 10px;
      height: 20rem;
      width: 15rem;
      padding: 5px;
      transition: padding 0.5s;
      text-align: center;
      color: rgb(235, 235, 235);
    }

    .card.enabled {
      background-color: rgba(71, 71, 71, 90);
    }

    .card.disabled {
      background-color: rgb(129, 129, 129);
      opacity: 70%;
    }

    .card:hover {
      padding: 10px;
      transition: padding 0.5s;
    }

    .command-name {
      font-size: 2rem;
      padding: 3px 2px 6px 2px;
    }

    .command-onoff {
      width: 90%;
      padding: 10px;
      background-color: #7289DA;
      border: 2px solid #5269BA;
      margin: 10px 0;
      border-radius: 5px;
      font-size: 1.2rem;
      position: absolute;
      bottom: 10px;
    }

    .command-onoff:hover {
      background-color: #5269BA;
    }

    .card-align-cont {
      height: 100%;
      width: 100%;
      position: relative;
    }

    .card-outer-box {
      display: flex;
      align-items: center;
      justify-content: center;
      height: calc(26px + 20rem);
      width: calc(26px + 15rem);
      margin: 5px;
    }

    .command-description {
      max-height: 12rem;
    }

    .command-description::-webkit-scrollbar {
      background: none;
    }
  </style>
</head>

<body>
  <div class="background-overlay"></div>
  <div class="header">
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
  <div class="container">
    <h1 class="center">Bot Dashboard</h1>
  </div>
  <div class="card-cont">
    <?php
    $directory = '../API_Management/commands/';
    $files = scandir($directory);

    foreach ($files as $file) {
      if (pathinfo($file, PATHINFO_EXTENSION) == 'js') {
        $fileName = str_replace('.js', '', $file);
        echo '<div class="card-outer-box"><div class="card enabled"><div class="card-align-cont"><div class="command-name">' . $fileName . '</div><div class="command-description">Description of the command goes here.</div><div class="command-onoff" id="' . $fileName . '">Disable command</div></div></div></div>';
      }
    }
    ?>
  </div>
  <script>
    function loadCardStates() {
      let cardStates = JSON.parse(localStorage.getItem('cardStates')) || {};
      let cards = document.querySelectorAll('.card');

      cards.forEach((card) => {
        let commandName = card.querySelector('.command-name').textContent.trim();
        let state = cardStates[commandName];

        if (state === 'enabled') {
          card.classList.add('enabled');
          card.classList.remove('disabled');
        } else if (state === 'disabled') {
          card.classList.remove('enabled');
          card.classList.add('disabled');
        }
      });
    }


    let cardsContainer = document.querySelector('.card-cont');

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
        cardsContainer.style.margin = '0 0 0 55px';
        manageCardDesign();
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
        cardsContainer.style.margin = '0 0 0 175px';
        manageCardDesign();
      }
    }

    let btns = document.querySelectorAll(".command-onoff")
    for (let i = 0; i < btns.length; i++) {
      btns[i].onclick = toggleCommand
    }

    function toggleCommand(event) {
      let button = event.currentTarget;
      let card = button.parentElement.parentElement;
      let commandFileName = button.id;

      let botToken = "<?php echo trim(preg_replace('/^DISCORD_BOT_TOKEN=/', '', file_get_contents('../API_Management/.env'))); ?>";

      let enable = !card.classList.contains('enabled');
      let state = enable ? 'enabled' : 'disabled';

      let requestData = {
        commandName: commandFileName,
        enable: enable
      };

      fetch('http://localhost:3000/toggleCommand', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': 'Bot ' + botToken
        },
        body: JSON.stringify(requestData)
      }).then(function(response) {
        if (response.ok) {
          let cardStates = JSON.parse(localStorage.getItem('cardStates')) || {};
          cardStates[commandFileName] = state;
          localStorage.setItem('cardStates', JSON.stringify(cardStates));

          if (enable) {
            button.innerHTML = "Disable command";
            card.classList.add('enabled');
            card.classList.remove('disabled');
            console.log(`Enabled ${commandFileName}`);
          } else {
            button.innerHTML = "Enable command";
            card.classList.remove('enabled');
            card.classList.add('disabled');
            console.log(`Disabled ${commandFileName}`);
          }
        } else {
          console.error(`Failed to toggle ${commandFileName}`);
        }
      });
    }

    window.addEventListener('load', function() {
      loadCardStates();
    });

    function manageCardDesign() {
      let extraCardsList = document.querySelectorAll('.extra-card').forEach(function(element) {
        element.remove();
      })
      let containerWidth = cardsContainer.offsetWidth
      let containerHeight = cardsContainer.offsetHeight
      let cardWidth = document.querySelector('.card-outer-box').offsetWidth + 10
      let numberOfColumns = Math.floor(containerWidth / cardWidth)
      let numberOfCards = document.querySelectorAll('.real-card').length;
      let extraCards = numberOfColumns - (numberOfCards % numberOfColumns)
      for (let i = 0; i < extraCards; i++) {
        let extraCard = document.createElement('div');
        extraCard.className = 'card-outer-box extra-card'
        cardsContainer.append(extraCard)
      }
    }
    manageCardDesign();
    addEventListener("resize", () => {
      manageCardDesign();
    })
  </script>
</body>

</html>