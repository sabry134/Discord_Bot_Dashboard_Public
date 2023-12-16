# Discord Bot Dashboard Template

**Authors:** Sabry, mjmj

**Welcome to the Discord Bot Dashboard Template repository!**

## Supported platforms

### Automation

- Docker
- Kubernetes (multi node deployments)
- Ansible (VM testing)
- Jenkins 
- Traefik
- Github action (Automatic push on dockerhub)


### Features


#### Staff section

- Bot Hosting
- Enable/Disable Commands
- Webhook Creation
- Server Managements
- Bot Messages
- Trigger the bot at specific times (AREA)
- Alerts system
- Inbox System
- Customizable Documentation
- Settings
- Package system
- Website Logs
- Website health status

#### User section

- Announcements
- User page (customizable by the administrator)
- Message Moderators system


**Full documentation is available [here](https://sabry134.github.io/Discord-Bot-Dashboard/)

## Overview

This repository contains a Discord bot dashboard template built using PHP for the frontend and JavaScript for the backend. The dashboard provides an easy-to-use interface for managing and configuring your Discord bot, making it a valuable tool for bot developers and server administrators.

## Getting Started

### Prerequisites

- [Docker](https://www.docker.com/get-started) must be installed on your system.
- [XAMPP](https://www.apachefriends.org/index.html) must be installed on your system to run the PHP frontend.
- [Node.js](https://nodejs.org/) must be installed on your system to run the JavaScript backend.


## Environment creation

### Existing environment

Rename every ".env.example" into ".env" and write your data inside the .env

### Manual .env creation

You will have to create 3 ".env" files

If you do not, the dashboard will NOT work.

- Create a .env on the inside /admin with the following data:

```
DISCORD_BOT_TOKEN=YOUR_DISCORD_TOKEN
CLIENT_ID=YOUR_CLIENT_ID
```

- Create a .env inside /API_Management with the following data:

```
DISCORD_BOT_TOKEN=YOUR_BOT_TOKEN_HERE
```

- Create a .env inside /user with the following data:

```
SERVER_ID=YOUR_SERVER_ID
```

### Code setup

It will NOT work either if you skip this step:

1. Go to process-oauth.php

2. Edit this code so you add your own client secret, your own client ID and your own permissions:

![process-oauth](https://imgur.com/xUJCTKI.png)

3. Do not forget to also add the redirect uri on the discord developers section. More information is available [here](https://discord.com/developers/docs/intro).




### Starting the Dashboard with Docker

1. Clone this repository to your local machine:
```
git clone git@github.com:sabry134/Php-Discord-Dashboard.git
```
2. Change into the project directory:
```
cd discord-bot-dashboard
```

#### Fast Docker setup

1. Execute the following script:
```
./start.sh
```

#### Manual Docker setup

1. Run the following command to build the necessary Docker containers:
```
docker-compose build
```
2. Once the build is complete, start the application using Docker Compose:
```
docker-compose up -d
```


The `-d` flag runs the containers in the background.

3. Access the dashboard in your web browser at http://localhost:8080.

4. The backend will be available at http://localhost:3000

### Starting the Dashboard without Docker

#### Using XAMPP

1. Clone this repository to your local machine:
```
git clone git@github.com:sabry134/Php-Discord-Dashboard.git
```

2. Put all the PHP files into the `/htdocs` directory of your XAMPP installation.

3. Start XAMPP and click on the "Admin" button next to Apache in the XAMPP control panel.

4. Access the dashboard in your web browser at http://localhost:8080/dashboard.


N.B: You might need to set the default port to 8080 on xampp since it is the required one.

#### Using a Bash command

1. Clone this repository to your local machine:
```
git clone git@github.com:sabry134/Php-Discord-Dashboard.git
```

2. Open a terminal and go into your project folder.

3. Install php package. Please take a look about how to [here](https://hpcshare.sdsc.edu/help/how-to-install-php).

4. Execute the following command:

```
php -S localhost:8080
```

5. Access the dashboard in your web browser at http://localhost:8080/dashboard.

### Starting the Backend (JavaScript)

1. Change into the project directory:
```
cd API_Management
```

2. Run the following command to start the JavaScript backend:
```
node server.js
```
3. Access the dashboard in your web browser at http://localhost:3000.


## Usage

- Access the dashboard in your web browser at the specified URL.
- Log in with your Discord bot's credentials.
- Use the dashboard to manage and configure your bot.

  


## Contributing

We welcome contributions from the community. If you'd like to contribute to this project, please follow our [contribution guidelines](CONTRIBUTING.md).
