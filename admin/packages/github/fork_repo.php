<?php
session_start();

if (!$_SESSION['logged_in']) {
    header('Location: error.php');
    exit();
}

$errorOccurred = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fork_url = "https://api.github.com/repos/sabry134/Discord_Bot_Dashboard_Public/forks";

    $options = [
        CURLOPT_URL => $fork_url,
        CURLOPT_HTTPHEADER => [
            'Content-type: application/json',
            'Authorization: Bearer ' . $_SESSION['access_token'],
            'User-Agent: Your-App-Name'
        ],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
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

        .container {
            width: 400px;
            margin: 20px;
            margin-left: 40%;
            margin-top: 20%;
            padding: 20px;
            background-color: grey;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .container.collapsed {
            margin-left: 10px;
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

        .menu-items a:hover {
            background-color: #555;
        }

        .background-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
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
            font-weight: bold;
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

        .fork-button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-left: 30%;
        }

        .fork-button:hover {
            background-color: #45a049;
        }

        .contribute-text {
            color: white;
            font-size: 16px;
            margin-bottom: 20px;
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
            <p class="contribute-text"><strong>Contribute to the Dashboard code by clicking on the button below:</strong></p>
            <form method="post" action="">
                <input type="submit" value="Fork Repository" class="fork-button">
                <?php
                if ($errorOccurred) {
                    echo "<script>showMessage(false, 'Error forking repository.');</script>";
                } elseif (isset($repo_data['html_url'])) {
                    echo "<script>showMessage(true, 'Repository forked successfully.');</script>";
                }
                ?>
            </form>
        </div>
    </div>

    <script>
        function toggleLogout() {
            var logoutButton = document.querySelector('.logout-button');
            logoutButton.classList.toggle('show-logout');
        }

        function toggleMenu() {
            var menu = document.querySelector('.menu');
            var menuItems = document.querySelector('.menu-items');
            menu.classList.toggle('collapsed');
            menuItems.classList.toggle('collapsed');
        }
    </script>
</body>

</html>