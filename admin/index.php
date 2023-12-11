<!DOCTYPE html>
<html>

<head>
  <title>Bot Dashboard</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="icon" type="image/png" href="img/Sparkles.png">
</head>

<body>
  <audio id="background-music" src="music/minecraft.mp3" loop></audio>
  <header>
    <h1>
      <img src="img/Sparkles.png" alt="Icon" class="header-icon">
      Bot Dashboard
    </h1>
    <div class="button-group">
      <div class="button-container">
        <a href="init-oauth.php">
          <button id="login-button" class="theme-toggle-button">Login</button>
        </a>
        <button id="download-apk-button" class="theme-toggle-button">Download APK</button>
      </div>
      <div class="button-container">
        <button id="theme-toggle" class="theme-toggle-button">Light Theme</button>
      </div>
      <div class="button-container">
        <button id="music-toggle" class="music-toggle-button">
          <img id="music-image" src="img/mute.png" alt="Unmute">
        </button>
      </div>
    </div>
  </header>


  <section id="home">
    <div class="container">
      <div class="about-us">
        <h2>Bot Dashboard</h2>
        <p>We are a leading company in our industry, and we're looking for talented individuals to join our team.</p>
      </div>
    </div>
  </section>
  <section id="jobs">
    <div class="container">
      <h2>Our Dashboard</h2>
      <div class="line-break"></div>
      <div class="job-list">
        <div class="job">
          <a href="team.php">
            <img src="img/developer.png" alt="Job 1">
            <h3>Our team</h3>
            <p>Are you interested to bring your contribution with coding? You're in the right place!</p>

          </a>
        </div>
        <div class="job">
          <a href="https://sabry134.github.io/Discord-Bot-Dashboard/">
            <img src="img/editor.png" alt="Job 2">
            <h3>Documentation</h3>
            <p>Are you interested to help documenting our bot with its knowledge base? You're in the right place!</p>
          </a>
        </div>
        <div class="job">
          <a href="../index.php">
            <img src="img/tester.png" alt="Job 3">
            <h3>User Dashboard</h3>
            <p>Are you a user? Feel free to have a look at the user dashboard on this section!</p>
          </a>
        </div>
      </div>
    </div>
  </section>
  <footer>
    <p>&copy; 2023 Bot Application. All rights reserved.</p>
  </footer>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const themeToggle = document.getElementById('theme-toggle');
      const musicToggle = document.getElementById('music-toggle');
      const backgroundMusic = document.getElementById('background-music');
      const body = document.body;
      const jobs = document.querySelectorAll('.job');
      let isMusicPlaying = false;

      themeToggle.addEventListener('click', () => {
        body.classList.toggle('mine-theme');
        body.classList.toggle('dark-theme');
        updateButtonLabel();
      });

      function updateButtonLabel() {
        const currentTheme = body.classList.contains('dark-theme') ? 'Light Theme' : 'Dark Theme';
        themeToggle.textContent = currentTheme;
      }

      document.addEventListener('mousemove', (event) => {
        const mouseX = event.clientX;
        const mouseY = event.clientY;
        const xPos = -((mouseX / window.innerWidth) * 20 - 10);
        const yPos = -((mouseY / window.innerHeight) * 20 - 10);
        body.style.backgroundPosition = `${xPos}px ${yPos}px`;
      });

      musicToggle.addEventListener('click', () => {
        if (!isMusicPlaying) {
          backgroundMusic.play();
          musicToggle.setAttribute('aria-label', 'Pause Background Music');
          document.getElementById('music-image').src = 'img/unmute.png';
        } else {
          backgroundMusic.pause();
          musicToggle.setAttribute('aria-label', 'Play Background Music');
          document.getElementById('music-image').src = 'img/mute.png';
        }
        isMusicPlaying = !isMusicPlaying;
      });

      jobs.forEach((job) => {
        job.addEventListener('mouseover', () => {
          job.classList.add('job-hover');
        });

        job.addEventListener('mouseout', () => {
          job.classList.remove('job-hover');
        });
      });
    });
    document.getElementById("download-apk-button").addEventListener("click", function() {
    window.location.href = "http://localhost:3000/download";
  });
  </script>
</body>

</html>