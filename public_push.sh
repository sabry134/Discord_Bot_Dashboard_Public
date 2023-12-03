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
push "[ADD] Latest update"