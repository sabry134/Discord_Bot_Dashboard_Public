<?php
session_start();
require_once 'config.php';

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    $token_url = "https://github.com/login/oauth/access_token";
    $data = [
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'code' => $code
    ];

    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($token_url, false, $context);

    parse_str($result, $token);

    if (isset($token['access_token'])) {
        $_SESSION['access_token'] = $token['access_token'];
        header("Location: github.php");
    } else {
        echo "Error during GitHub authentication.";
    }
} else {
    echo "Error: Authorization code not provided.";
}
