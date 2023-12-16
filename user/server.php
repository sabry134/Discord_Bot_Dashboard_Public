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
            overflow: hidden;
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

        #discord-container {
            position: absolute;
            top: 50%;
            left: 85%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        #discord-invite {
            width: 350px;
            height: 500px;
        }

        #discord-text {
            max-width: 600px;
            margin: 0 auto;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin-top: 100px;
            overflow-y: auto;
        }

        #markdown-container {
            color: white;
            padding: 20px;
        }

        .background-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            overflow: auto;
        }

        #toggleButton {
            position: absolute;
            top: 10px;
            right: 20px;
            padding: 10px 20px;
            background-color: #7289DA;
            color: #fff;
            text-decoration: none;
            border: none;
            cursor: pointer;
            z-index: 1;
            border-radius: 5px;
        }


        #toggleButton:hover {
            background-color: #677BC4;
        }

        .snowflake {
            position: absolute;
            font-size: 20px;
            color: #fff;
            user-select: none;
        }
    </style>
</head>

<body>
    <div class="background-overlay">


        <?php
        $dotenv = parse_ini_file('.env');

        $serverID = $dotenv['SERVER_ID'];

        function parseMarkdown($content)
        {
            $content = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $content);

            $content = preg_replace('/__(.*?)__/', '<u>$1</u>', $content);

            $content = preg_replace('/\[([^\]]+)\]\(([^)]+)\)/', '<a href="$2">$1</a>', $content);

            $content = preg_replace_callback('/(^|\n)(#+)(.*?)($|\n)/', function ($matches) {
                $level = strlen($matches[2]);
                return '<h' . $level . ' class="dynamic-title">' . $matches[3] . '</h' . $level . '>';
            }, $content);

            return $content;
        }



        $fileContent = file_get_contents(__DIR__ . '/description/community.md');
        $htmlContent = parseMarkdown($fileContent);
        ?>

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

        <button id="toggleButton">Enable Snow</button>

        <div id="discord-container">
            <iframe id="discord-invite" src="https://discord.com/widget?id=<?php echo $serverID; ?>&theme=dark" allowtransparency="true" frameborder="0" sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe>
        </div>

        <div id="discord-text">
            <div id="markdown-container">
                <?php echo $htmlContent; ?>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const numberOfSnowflakes = 50;
            let snowEffectEnabled = localStorage.getItem('snowEffectEnabled') === 'true';

            const toggleButton = document.getElementById('toggleButton');
            updateButtonText();

            toggleButton.addEventListener('click', function () {
                snowEffectEnabled = !snowEffectEnabled;
                updateButtonText();
                localStorage.setItem('snowEffectEnabled', snowEffectEnabled);

                const snowflakes = document.querySelectorAll('.snowflake');
                snowflakes.forEach(function (snowflake) {
                    snowflake.remove();
                });

                if (snowEffectEnabled) {
                    for (let i = 0; i < numberOfSnowflakes; i++) {
                        createSnowflake();
                    }
                }
            });

            function updateButtonText() {
                toggleButton.textContent = snowEffectEnabled ? 'Disable Snow' : 'Enable Snow';
            }

            function createSnowflake() {
                const snowflake = document.createElement('div');
                snowflake.className = 'snowflake';
                snowflake.innerHTML = '❄';
                document.body.appendChild(snowflake);

                const initialX = Math.random() * window.innerWidth;
                const initialY = Math.random() * window.innerHeight;

                snowflake.style.left = initialX + 'px';
                snowflake.style.top = initialY + 'px';

                animateSnowflake(snowflake);
            }

            function animateSnowflake(snowflake) {
                if (!snowEffectEnabled) {
                    return;
                }

                const speed = 1 + Math.random() * 2;
                const rotationSpeed = 0.02 + Math.random() * 0.1;

                function moveSnowflake() {
                    if (!snowEffectEnabled) {
                        snowflake.remove();
                        return;
                    }

                    const currentY = parseFloat(snowflake.style.top);
                    snowflake.style.top = currentY + speed + 'px';

                    const currentRotation = parseFloat(snowflake.style.transform.replace('rotate(', '').replace('deg)', ''));
                    snowflake.style.transform = 'rotate(' + (currentRotation + rotationSpeed) + 'deg)';

                    if (currentY > window.innerHeight) {
                        snowflake.style.top = '0px';
                    }

                    requestAnimationFrame(moveSnowflake);
                }

                moveSnowflake();
            }

            if (snowEffectEnabled) {
                for (let i = 0; i < numberOfSnowflakes; i++) {
                    createSnowflake();
                }
            }
        });
    </script>

</body>

</html>