<?php
session_start();

if (!$_SESSION['logged_in']) {
    header('Location: error.php');
    exit();
}

extract($_SESSION['userData']);

$avatar_url = "https://cdn.discordapp.com/avatars/$discord_id/$avatar.jpg";

$errorOccurred = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['repo_name'])) {
        $repo_name = $_POST['repo_name'];

        $repo_url = 'https://api.github.com/user/repos';

        $data = [
            'name' => $repo_name,
            'auto_init' => true
        ];

        $options = [
            CURLOPT_URL => $repo_url,
            CURLOPT_HTTPHEADER => [
                'Content-type: application/json',
                'Authorization: Bearer ' . $_SESSION['access_token'],
                'User-Agent: Your-App-Name'
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data)
        ];

        $ch = curl_init();
        curl_setopt_array($ch, $options);

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch);
            $errorOccurred = true;
        } else {
            $repo_data = json_decode($result, true);

            if (!isset($repo_data['html_url'])) {
                $errorOccurred = true;
            }
        }

        curl_close($ch);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bot Dashboard</title>
    <link rel="icon" type="image/png" href="img/Sparkles.png">
    <script>
        function showMessage(isSuccess, message) {
            var container = document.createElement('div');
            container.className = isSuccess ? 'success-container' : 'error-container';
            container.textContent = message;

            document.body.appendChild(container);

            setTimeout(function() {
                container.style.display = 'none';
            }, 3000);
        }

        function toggleLogout() {
            var usernameContainer = document.querySelector(".username-container");
            usernameContainer.classList.toggle('clicked');
            var logoutButton = document.querySelector(".logout-button");
            logoutButton.classList.toggle('show-logout');
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

    <style>
        body {
            background-image: url('img/dashboard_bg.gif');
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            position: relative;
            height: 100vh;
            overflow: hidden;
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
            width: 400px;
            margin: 20px;
            margin-left: 40%;
            margin-top: 20%;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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

        .menu-items a:hover {
            background-color: #555;
        }

        form {
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .success-container {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            border-radius: 5px;
            display: inline-block;
            z-index: 2;
        }

        .error-container {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #FF5733;
            color: white;
            padding: 15px;
            border-radius: 5px;
            display: inline-block;
            z-index: 2;
        }

        .form-label {
            color: white;
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-instruction {
            color: white;
            font-size: 16px;
            margin-bottom: 20px;
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
    <div class="container">
        <form method="post" action="">
            <p class="form-instruction">Fill out the form below to create a new GitHub repository:</p>
            <label for="repo_name" class="form-label">Enter GitHub Repository Name:</label>
            <input type="text" name="repo_name" required>
            <br>
            <input type="submit" value="Create Repository">
            <?php
            if ($errorOccurred) {
                echo "<script>showMessage(false, 'Error creating repository.');</script>";
            } elseif (isset($repo_data['html_url'])) {
                echo "<script>showMessage(true, 'Repository created successfully.');</script>";
            }
            ?>
        </form>

    </div>

</body>

</html>