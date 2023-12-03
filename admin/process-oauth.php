<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset(['code'])) {
    echo 'No code';
    exit();
}

 = ['code'];

 = [
    'code' => ,
    'client_id' => 'YOUR_CLIENT_ID',
    'client_secret' => 'YOUR_CLIENT_SECRET',
    'grant_type' => 'authorization_code',
    'redirect_uri' => 'http://localhost:8080/admin/process-oauth.php',
    'scope' => 'identify%20guids',
];

 = http_build_query();
 = https://discord.com/api/oauth2/token;

 = curl_init();

curl_setopt(, CURLOPT_URL, );
curl_setopt(, CURLOPT_POST, true);
curl_setopt(, CURLOPT_POSTFIELDS, );
curl_setopt(, CURLOPT_RETURNTRANSFER, true);

curl_setopt(, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt(, CURLOPT_SSL_VERIFYPEER, 0);

 = curl_exec();

if (!) {
    echo curl_error();
}

 = json_decode(, true);
 = ['access_token'];

 = https://discord.com/api/users/@me;
 = array(Authorization: Bearer );

 = curl_init();
curl_setopt(, CURLOPT_HTTPHEADER, );
curl_setopt(, CURLOPT_URL, );
curl_setopt(, CURLOPT_POST, false);
curl_setopt(, CURLOPT_RETURNTRANSFER, true);

curl_setopt(, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt(, CURLOPT_SSL_VERIFYPEER, 0);

 = curl_exec();

 = json_decode(, true);

 = array('USER_ID1', 'USER_ID2', 'USER_ID3');
if (!in_array(['id'], )) {
    header(Location: error.php);
    exit();
}

['logged_in'] = true;
['userData'] = [
    'name' => ['username'],
    'discord_id' => ['id'],
    'avatar' => ['avatar'],
];

header(Location: dashboard.php);
exit();
?>

