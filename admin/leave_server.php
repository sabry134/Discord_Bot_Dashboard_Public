<?php

// Load environment variables from .env file
$envFile = __DIR__ . '/.env';

if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $line) {
        list($key, $value) = explode('=', $line, 2);
        $_ENV[$key] = $value;
    }
}

$token = $_ENV['DISCORD_BOT_TOKEN'];

$guildId = $_GET['guildId'];

$leaveEndpoint = "https://discord.com/api/v10/users/@me/guilds/{$guildId}";
$curl = curl_init($leaveEndpoint);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_setopt($curl, CURLOPT_HTTPHEADER, [
    'Authorization: Bot ' . $token,
]);

$response = curl_exec($curl);
curl_close($curl);

header('Refresh: 1; URL=manage_bot.php');
exit();
?>
