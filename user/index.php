<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Public Dashboard</title>
    <link rel="icon" type="image/png" href="../admin/img/Sparkles.png">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('../admin/img/dashboard_bg.gif');
            background-size: cover;
            font-family: Arial, sans-serif;
        }

        #header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 30px 0;
        }

        #public-dashboard {
            margin: 0;
        }

        #left-menu {
            background-color: #333;
            color: #fff;
            width: 200px;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            overflow-x: hidden;
            padding-top: 80px;
        }

        #left-menu a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 18px;
            color: #fff;
            display: block;
            margin-top: 10px;
        }

        #left-menu a:hover {
            background-color: #555;
        }

        #back-button {
            position: fixed;
            top: 10px;
            left: 10px;
            padding: 10px 20px;
            background-color: #7289DA;
            color: #fff;
            text-decoration: none;
            border: none;
            cursor: pointer;
            z-index: 1;
            border-radius: 5px;
        }

        #back-button:hover {
            background-color: #677BC4;
        }

        .background-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
        }
    </style>
</head>

<body>
    <div class="background-overlay">

        <a id="back-button" href="../index.php">Back</a>

        <div id="header">
            <h1 id="public-dashboard">Public Dashboard</h1>
        </div>

        <div id="left-menu">
            <a href="index.php">Main Menu</a>
            <a href="announcements.php">Announcements</a>
            <a href="server.php">Community Server</a>
            <a href="message_mods.php">Message Mods</a>
        </div>
    </div>
</body>

</html>