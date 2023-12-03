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

        .background-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
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

        #message-box {
            background-color: #ccc;
            padding: 30px;
            margin: 50px auto;
            width: 70%;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        #message-box label {
            display: block;
            margin-bottom: 10px;
        }

        #message-box input,
        #message-box textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            box-sizing: border-box;
            resize: none;
        }

        #send-button {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #send-button:hover {
            background-color: #45a049;
        }

        #confirmation-box {
            background-color: #4CAF50;
            color: #fff;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            display: none;
            margin-top: 10px;
        }

        #error-box {
            background-color: #FF0000;
            color: #fff;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            display: none;
            margin-top: 10px;
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

        <div id="message-box">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <br>
            <label for="object">Object:</label>
            <input type="text" id="object" name="object" required>
            <br>
            <label for="message">Message content:</label>
            <textarea id="message" name="message" rows="6" required></textarea>
            <br>
            <button id="send-button" onclick="sendMessage()">Send</button>
            <div id="confirmation-box">Message sent!</div>
            <div id="error-box">Please fill in all fields!</div>
            <div id="cooldown-box" style="display: none; background-color: #FF0000; color: #fff; text-align: center; padding: 10px; border-radius: 5px; margin-top: 10px;"></div>
        </div>

    </div>

    <script>
        var lastMessageTime = localStorage.getItem("lastMessageTime") || 0;

        function sendMessage() {
            var currentTime = new Date().getTime();
            var elapsedTime = (currentTime - lastMessageTime) / 1000;

            if (elapsedTime >= 300) {
                var username = document.getElementById("username").value;
                var object = document.getElementById("object").value;
                var message = document.getElementById("message").value;

                if (username && object && message) {
                    var data = {
                        title: username,
                        content: message,
                        username: object
                    };

                    fetch('http://localhost:3000/api/emails', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(data)
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Success:', data);
                            document.getElementById("confirmation-box").style.display = "block";
                            lastMessageTime = currentTime;
                            localStorage.setItem("lastMessageTime", lastMessageTime);
                            setTimeout(function() {
                                document.getElementById("confirmation-box").style.display = "none";
                            }, 3000);
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                        });
                } else {
                    document.getElementById("error-box").style.display = "block";
                    setTimeout(function() {
                        document.getElementById("error-box").style.display = "none";
                    }, 3000);
                }
            } else {
                var timeLeft = Math.ceil(300 - elapsedTime);
                document.getElementById("cooldown-box").style.display = "block";
                document.getElementById("cooldown-box").innerHTML = "Please wait " + timeLeft + " seconds before sending another message.";
                setTimeout(function() {
                    document.getElementById("cooldown-box").style.display = "none";
                }, 3000);
            }
        }
    </script>
</body>

</html>