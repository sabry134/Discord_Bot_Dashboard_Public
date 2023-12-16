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
    <title>Bot Dashboard Documentation</title>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="img/Sparkles.png">
    <style>
        body {
            background-image: url('img/dashboard_bg.gif');
            background-size: cover;
            font-family: Arial, sans-serif;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .header {
            background-color: #333;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100px;
            z-index: 1;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
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

        .container {
            margin-left: 10%;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            width: calc(50% - 120px);
            max-width: 800px;
            position: absolute;
            top: 200px;
            right: calc(120px + 5%);
            overflow: auto;
        }

        .gray-container {
            background-color: #ccc;
            border-radius: 10px;
            padding: 20px;
            width: calc(30% - 120px);
            position: absolute;
            top: 200px;
            left: calc(120px + 5%);
            display: flex;
            flex-direction: column;
        }

        .button {
            background-color: #7289DA;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 15px 0;
            text-decoration: none;
            text-align: left;
            display: block;
        }

        h1 {
            color: #333;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin: 10px 0;
        }

        #markdown-content {
            text-align: left;
            padding: 20px;
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
            z-index: 2;
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
            text-align: left;
        }

        .menu-title:hover {
            text-decoration: underline;
        }

        .menu-title.collapsed+.menu-items {
            display: none;
        }

        .menu-title:not(.collapsed)+.menu-items {
            display: block;
        }

        .area-text {
            display: block;
        }

        .request-text {
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

        .top-right {
            display: flex;
            align-items: center;
            margin-right: 20px;
        }

        .top-right {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            align-items: center;
        }

        .username-container {
            background-color: white;
            padding: 10px;
            border-radius: 5px;
            display: flex;
            align-items: center;
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
    <div class="gray-container">
        <h2>Documentation Files</h2>
        <ul>
            <?php
            $directory = './documentation/';
            $files = scandir($directory);

            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) == 'md') {
                    $buttonText = str_replace('.md', '', $file);
                    echo '<a class="button" href="?file=' . urlencode($file) . '">' . $buttonText . '</a>';
                }
            }
            ?>
        </ul>
    </div>
    <div class="container">
        <h1>Bot Dashboard Documentation</h1>
        <div id="markdown-content">
            <?php
            if (isset($_GET['file'])) {
                $requestedFile = $_GET['file'];

                if (file_exists($directory . $requestedFile) && pathinfo($requestedFile, PATHINFO_EXTENSION) == 'md') {
                    $markdownContent = file_get_contents($directory . $requestedFile);
                    $htmlContent = MarkdownToHTML($markdownContent);
                    echo $htmlContent;
                } else {
                    echo "Requested file not found or not a valid Markdown file.";
                }
            }
            ?>

            <?php
            function MarkdownToHTML($markdown)
            {
                $markdown = preg_replace('/^###### (.*?)$/m', '<h6>$1</h6>', $markdown);
                $markdown = preg_replace('/^##### (.*?)$/m', '<h5>$1</h5>', $markdown);
                $markdown = preg_replace('/^#### (.*?)$/m', '<h4>$1</h4>', $markdown);
                $markdown = preg_replace('/^### (.*?)$/m', '<h3>$1</h3>', $markdown);
                $markdown = preg_replace('/^## (.*?)$/m', '<h2>$1</h2>', $markdown);
                $markdown = preg_replace('/^# (.*?)$/m', '<h1>$1</h1>', $markdown);

                $markdown = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $markdown);

                $markdown = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $markdown);

                $markdown = preg_replace('/\[(.*?)\]\((.*?)\)/', '<a href="$2">$1</a>', $markdown);

                $html = '<div>' . nl2br($markdown) . '</div';

                return $html;
            }
            ?>
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

        function toggleLogout() {
            var usernameContainer = document.querySelector(".username-container");
            usernameContainer.classList.toggle('clicked');
            var logoutButton = document.querySelector(".logout-button");
            logoutButton.classList.toggle('show-logout');
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