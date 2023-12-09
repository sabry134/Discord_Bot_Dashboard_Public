cp -r * ../Discord_Bot_Dashboard_Public
cd ../Discord_Bot_Dashboard_Public
echo ".gitignore
Mobile/node_modules/
notes.txt
admin/.env
API_Management/.env
user/.env
API_Management/node_modules/
dashboard-documentation/" > .gitignore
echo "<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_GET['code'])) {
    echo 'No code';
    exit();
}

$discord_code = $_GET['code'];

$payload = [
    'code' => $discord_code,
    'client_id' => 'YOUR_CLIENT_ID',
    'client_secret' => 'YOUR_CLIENT_SECRET',
    'grant_type' => 'authorization_code',
    'redirect_uri' => 'http://localhost:8080/admin/process-oauth.php',
    'scope' => 'identify%20guids',
];

$payload_string = http_build_query($payload);
$discord_token_url = "https://discord.com/api/oauth2/token";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $discord_token_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

$result = curl_exec($ch);

if (!$result) {
    echo curl_error($ch);
}

$result = json_decode($result, true);
$access_token = $result['access_token'];

$discord_user_url = "https://discord.com/api/users/@me";
$header = array("Authorization: Bearer $access_token");

$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_URL, $discord_user_url);
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

$result = curl_exec($ch);

$result = json_decode($result, true);

$allowed_ids = array('USER_ID1', 'USER_ID2', 'USER_ID3');
if (!in_array($result['id'], $allowed_ids)) {
    header("Location: error.php");
    exit();
}

$_SESSION['logged_in'] = true;
$_SESSION['userData'] = [
    'name' => $result['username'],
    'discord_id' => $result['id'],
    'avatar' => $result['avatar'],
];

header("Location: dashboard.php");
exit();
?>
" > admin/process-oauth.php

echo "<?php
$client_id = 'YOUR_CLIENT_ID';
$client_secret = 'YOUR_CLIENT_SECRET';" > admin/config.php
cat << 'EOF' > admin/github.php
<?php
session_start();

if (!$_SESSION['logged_in']) {
    header('Location: error.php');
    exit();
}
extract($_SESSION['userData']);

$avatar_url = "https://cdn.discordapp.com/avatars/$discord_id/$avatar.jpg";

require_once 'config.php';

if (!isset($_SESSION['access_token']) || !isset($_SESSION['github_user'])) {
    echo '<a href="login.php" class="github-button">';
    echo '<i class="fab fa-github"></i>Login with GitHub</a>';
} else {
    echo '<a href="create_repo.php" class="github-button">';
    echo '<i class="fab fa-github"></i>Create GitHub Repository</a>';
}
$github_username = 'YOUR_GITHUB_USERNAME';
$github_repository = 'Discord_Bot_Dashboard_Public';
$github_token = 'YOUR_GITHUB_TOKEN';

$api_url = "https://api.github.com/repos/$github_username/$github_repository/commits?per_page=1";
$options = [
    'http' => [
        'header' => [
            "Authorization: Bearer $github_token",
            "User-Agent: Your-App-Name"
        ]
    ]
];
$context = stream_context_create($options);
$response = file_get_contents($api_url, false, $context);
$commits = json_decode($response, true);

$latest_commit = $commits[0]['commit'];
$commit_author = $latest_commit['author']['name'];
$commit_message = $latest_commit['message'];
$commit_date = $latest_commit['author']['date'];

$commit_date_formatted = date("F j, Y, g:i a", strtotime($commit_date));
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            margin-top: -30px;
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

        .github-container {
            margin-top: 15%;
            margin-right: 45%;
            position: relative;
            display: inline-block;
        }

        .github-button-box {
            display: inline-block;
            margin-left: 15%;
            background-color: #34495e;
            border-radius: 10px;
            padding: 10px;
            position: relative;
            z-index: 1;
        }

        .github-button {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            font-size: 16px;
            text-decoration: none;
            color: #fff;
            cursor: pointer;
        }

        .github-button i {
            margin-right: 8px;
        }

        .github-button:hover {
            background-color: #34495e;
        }

        .github-commit-details-container {
            background-color: grey;
            border-radius: 10px;
            padding: 15px;
            margin-right: 40%;
            margin-top: 10%;
            z-index: 1;
        }

        .github-commit-details {
            color: white;
            z-index: 1;
        }

        .commit-info {
            color: white;
        }

        .github-fork-button-box {
            display: inline-block;
            margin-left: 15%;
            background-color: #34495e;
            border-radius: 10px;
            padding: 10px;
            position: relative;
            z-index: 1;
        }

        .github-fork-button {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            font-size: 16px;
            text-decoration: none;
            color: #fff;
            cursor: pointer;
        }

        .github-fork-button i {
            margin-right: 8px;
        }

        .github-fork-button:hover {
            background-color: #34495e;
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
        <h1 class="center">Bot Dashboard</h1>
        <div class="github-commit-details-container">
            <div class="github-commit-details">
                <h2 style="color: white;">Latest GitHub Commit:</h2>
                <p class="commit-info"><strong>Author:</strong> <?php echo $commit_author; ?></p>
                <p class="commit-info"><strong>Message:</strong> <?php echo $commit_message; ?></p>
                <p class="commit-info"><strong>Commit Hash:</strong> <?php echo $commits[0]['sha']; ?></p>
                <p class="commit-info"><strong>Date:</strong> <?php echo $commit_date_formatted; ?></p>
            </div>
            <div class="github-button-box">
                <?php
                require_once 'config.php';

                if (!isset($_SESSION['access_token'])) {
                    echo '<a href="login.php" class="github-button">';
                    echo '<i class="fab fa-github"></i>Login with GitHub</a>';
                } else {
                    echo '<a href="create_repo.php" class="github-button">';
                    echo '<i class="fab fa-github"></i>Create GitHub Repository</a>';
                }
                ?>
            </div>
            <br></br>
            <div class="github-fork-button-box">
                <?php

                if (!isset($_SESSION['access_token'])) {
                    echo '<a href="login.php" class="github-fork-button">';
                    echo '<i class="fab fa-github"></i>Login with GitHub</a>';
                } else {
                    echo '<a href="fork_repo.php" class="github-fork-button">';
                    echo '<i class="fab fa-github"></i>Fork GitHub Repository</a>';
                }
                ?>
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
EOF
push "[ADD] Latest update"