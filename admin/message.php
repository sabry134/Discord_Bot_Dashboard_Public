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

        .message-container {
            display: inline-block;
            background-color: rgba(255, 255, 255, 0.5);
            padding: 30px;
            border-radius: 5px;
            margin-top: 15%;
            margin-right: 40%;
            text-align: center;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border-radius: 5px;
            width: 60%;
            text-align: center;
            position: relative;
        }

        .discord-button {
            background-color: #7289DA;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            margin-top: 20px;
            cursor: pointer;
        }

        .discord-button:hover {
            background-color: #677BC4;
        }

        .modal input {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .modal button {
            width: 100%;
            padding: 10px;
        }

        .discord-button[disabled] {
            pointer-events: none;
            background-color: #ccc;
        }

        .menu-items a:hover {
            background-color: #555;
        }

        .menu-items .packages-menu-item {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="background-overlay">
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
            <div class="message-container">
                <button class="discord-button dashboard-button" onclick="openModal()">Send DM message</button>
                <button class="discord-button dashboard-button" onclick="openChannelModal()">Send Channel message</button>
            </div>
        </div>
        <div id="channelModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeChannelModal()">&times;</span>
                <input type="text" id="channelID" placeholder="Channel ID">
                <input type="text" id="channelMessage" placeholder="Message">
                <button class="discord-button" onclick="sendChannelMessage()">Send</button>
            </div>
        </div>
        <div id="modal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <input type="text" id="userID" placeholder="User ID">
                <input type="text" id="message" placeholder="Message">
                <button class="discord-button" onclick="sendPrivateMessage()">Send</button>
            </div>
        </div>
    </div>
    <script>
        const menuItemUrls = {
            'Dashboard': 'dashboard.php',
            'Commands': 'commands.php',
            'Manage Webhooks': 'webhook_manager.php',
            'Manage Servers': 'manage_bot.php',
            'Send a message': 'message.php',
            'AREA': 'area.php',
            'Alerts': 'alerts.php',
            'Inbox': 'requests.php',
            'Staff documentation': 'documentation.php',
            'Settings': 'settings.php',
            'User Dashboard': '../user/index.php',
        };

        function openModal() {
            document.getElementById('modal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
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

        function sendPrivateMessage() {
            const userID = document.getElementById('userID').value;
            const message = document.getElementById('message').value;
            const sendButton = document.querySelector('#modal button');

            if (sendButton.disabled) {
                return;
            }

            sendButton.disabled = true;

            fetch('http://localhost:3000/sendDM', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        userID: userID,
                        message: message,
                    }),
                })
                .then(function(response) {
                    if (response.ok) {
                        console.log('Message sent successfully!');
                        closeModal();
                        document.getElementById('userID').value = '';
                        document.getElementById('message').value = '';
                        setTimeout(function() {
                            sendButton.disabled = false;
                        }, 10000);
                    } else {
                        console.log('Failed to send the message.');
                        sendButton.disabled = false;
                    }
                })
                .catch(function(error) {
                    console.error('Error:', error);
                    sendButton.disabled = false;
                });
        }

        function openChannelModal() {
            document.getElementById('channelModal').style.display = 'block';
        }

        function closeChannelModal() {
            document.getElementById('channelModal').style.display = 'none';
        }

        function sendChannelMessage() {
            const channelID = document.getElementById('channelID').value;
            const channelMessage = document.getElementById('channelMessage').value;
            const sendButton = document.querySelector('#channelModal button');

            if (sendButton.disabled) {
                return;
            }

            sendButton.disabled = true;

            fetch('http://localhost:3000/sendMessage', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        channelID: channelID,
                        message: channelMessage,
                    }),
                })
                .then(function(response) {
                    if (response.ok) {
                        console.log('Message sent successfully to the channel!');
                        closeChannelModal();
                        document.getElementById('channelID').value = '';
                        document.getElementById('channelMessage').value = '';
                        setTimeout(function() {
                            sendButton.disabled = false;
                        }, 10000);
                    } else {
                        console.log('Failed to send the message to the channel.');
                        sendButton.disabled = false;
                    }
                })
                .catch(function(error) {
                    console.error('Error:', error);
                    sendButton.disabled = false;
                });
        }

        function loadConfigurationFromLocalStorage() {
            var storedConfiguration = localStorage.getItem('botConfiguration');

            if (storedConfiguration) {
                var parsedConfiguration = JSON.parse(storedConfiguration);
                updateMenu(parsedConfiguration.enabled);
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            loadConfigurationFromLocalStorage();
            var storedConfiguration = localStorage.getItem('botConfiguration');

            if (storedConfiguration) {
                var parsedConfiguration = JSON.parse(storedConfiguration);
                updateMenu(parsedConfiguration);
            }

            var packagesEnabled = localStorage.getItem('packagesEnabled');
            if (packagesEnabled === 'true') {
                togglePackages();
            } else {
                displayErrorMessage();
            }

            applyConfiguration();
        });

        function togglePackages() {
            var menuItems = document.querySelector('.menu-items');
            var enablePackageButton = document.querySelector('.grey-box button');

            var packagesMenuItem = document.querySelector('.packages-menu-item');

            if (!packagesMenuItem) {
                var newMenuItem = document.createElement('a');
                newMenuItem.className = 'packages-menu-item';
                newMenuItem.href = 'packages.php';
                newMenuItem.innerText = 'Packages';
                menuItems.appendChild(newMenuItem);
                enablePackageButton.innerText = 'Disable Package';
                localStorage.setItem('packagesEnabled', 'true');
            } else {
                packagesMenuItem.remove();
                enablePackageButton.innerText = 'Enable Package';
                localStorage.setItem('packagesEnabled', 'false');
            }
        }

        function applyConfiguration() {
            var fileInput = document.getElementById('configFileInput');
            var file = fileInput.files[0];

            if (file) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    try {
                        var configData = JSON.parse(e.target.result);

                        localStorage.setItem('botConfiguration', JSON.stringify(configData));

                        updateMenu(configData.enabled);
                    } catch (error) {
                        console.error("Error parsing JSON:", error);
                        alert("Error parsing JSON file. Please make sure the file is valid.");
                    }
                };

                reader.readAsText(file);
            } else {
                alert("Please upload a JSON file.");
            }
        }

        function updateMenu(enabledConfig) {
            var menuItems = document.querySelectorAll('.menu-items a');

            menuItems.forEach(function(menuItem) {
                var menuItemText = menuItem.innerText.trim();
                var enabled = enabledConfig[menuItemText];

                if (enabled !== undefined) {
                    menuItem.href = enabled === "true" ? menuItemUrls[menuItemText] : "#";
                    menuItem.style.pointerEvents = enabled === "true" ? "auto" : "none";
                    menuItem.style.color = enabled === "true" ? "#fff" : "#888";
                }
            });
        }
    </script>
</body>

</html>