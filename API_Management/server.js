const express = require('express');
const path = require('path');
const bodyParser = require('body-parser');
const cors = require('cors');
const dotenv = require('dotenv');
const axios = require('axios');
const { Client, GatewayIntentBits } = require('discord.js');
const cron = require('node-cron');
const scheduledTasks = [];
let areaInfoList = [];
let emails = [];



const helpCommand = require('./commands/help');
const helloCommand = require('./commands/hello');

dotenv.config();

const app = express();
const port = process.env.PORT || 3000;

app.use(bodyParser.json());
app.use(cors());
const announcements = [];

const commands = {
  help: { enabled: true },
  hello: { enabled: true },
};

const accounts = [
  { username: 'user1', password: process.env.USER1_PASSWORD },
  { username: 'user2', password: process.env.USER2_PASSWORD },
  { username: 'user3', password: process.env.USER3_PASSWORD },
];

let botIsRunning = false;
let client = null;

let acceptRequests = true;

app.use((req, res, next) => {
  if (!acceptRequests) {
    res.status(403).json({ message: 'Requests are currently refused' });
  } else {
    next();
  }
});


function toggleCommandStatus(commandName, enable) {
  if (commands.hasOwnProperty(commandName)) {
    commands[commandName].enabled = enable;
    return true;
  }
  return false;
}

app.post('/api/emails', (req, res) => {
  const { title, content, username } = req.body;

  if (!title || !content || !username) {
    return res.status(400).json({ error: 'Title, content, and username are required.' });
  }

  const newEmail = {
    id: emails.length + 1,
    title,
    content,
    username,
    date: new Date().toLocaleString(),
  };

  emails.push(newEmail);
  res.json({ message: 'Email added successfully', email: newEmail });
});

app.get('/api/emails', (req, res) => {
  res.json(emails);
});

app.get('/api/emails/:id', (req, res) => {
  const email = emails.find(e => e.id === parseInt(req.params.id));
  res.json(email);
});

app.delete('/api/emails/:id', (req, res) => {
  const id = parseInt(req.params.id);
  emails = emails.filter(email => email.id !== id);
  res.json({ message: 'Email deleted successfully' });
});

app.delete('/api/emails/delete', (req, res) => {
  const { email_id } = req.body;

  if (!email_id) {
    return res.status(400).json({ error: 'email_id is required.' });
  }

  const id = parseInt(email_id);
  emails = emails.filter(email => email.id !== id);
  res.json({ message: 'Email deleted successfully' });
});

app.post('/api/emails/:id/archive', (req, res) => {
  const id = parseInt(req.params.id);
  const emailIndex = emails.findIndex(email => email.id === id);

  if (emailIndex !== -1) {
    const archivedEmail = { ...emails[emailIndex], folder: 'archive' };
    emails.splice(emailIndex, 1, archivedEmail);
    res.json({ message: 'Email archived successfully', email: archivedEmail });
  } else {
    res.status(404).json({ error: 'Email not found' });
  }
});


app.post('/toggleCommand', (req, res) => {
  const { commandName, enable } = req.body;
  const authorizationHeader = req.headers.authorization;

  const expectedToken = process.env.DISCORD_BOT_TOKEN;
  if (!authorizationHeader || authorizationHeader !== `Bot ${expectedToken}`) {
    return res.status(401).json({ message: 'Unauthorized' });
  }

  if (commandName === 'help') {
    helpCommand.setHelpCommandStatus(enable);
    res.status(200).json({ message: `helpCommand is ${enable ? 'enabled' : 'disabled'}` });
  } else if (commandName === 'hello') {
    helloCommand.setHelloCommandStatus(enable);
    res.status(200).json({ message: `helloCommand is ${enable ? 'enabled' : 'disabled'}` });
  } else {
    res.status(400).json({ message: 'Invalid commandName' });
  }
});

app.post('/login', (req, res) => {
  const { username, password } = req.body;
  const account = accounts.find((acc) => acc.username === username);

  if (account) {
    console.log('Stored Password:', account.password);
    console.log('Submitted Password:', password);

    if (account.password === password) {
      console.log('Login successful');
      res.status(200).json({ message: 'Login successful' });
    } else {
      console.log('Login failed - Incorrect password');
      res.status(401).json({ message: 'Incorrect password' });
    }
  } else {
    console.log('Login failed - User not found');
    res.status(401).json({ message: 'User not found' });
  }
});

app.post('/start', (req, res) => {
  if (botIsRunning) {
    res.status(200).json({ message: 'Bot is already running' });
  } else {
    client = new Client({
      intents: [
        GatewayIntentBits.Guilds,
        GatewayIntentBits.GuildMessages,
        GatewayIntentBits.MessageContent,
        GatewayIntentBits.DirectMessages,
      ],
    });

    client.on("messageCreate", (msg) => {
      helpCommand(msg);
      helloCommand(msg);
    });

    client.login(process.env.DISCORD_BOT_TOKEN);

    botIsRunning = true;
    console.log('Bot started');
    res.status(200).json({ message: 'Bot started' });
  }
});


app.get('/download', (req, res) => {
  const apkFilePath = path.join(__dirname, 'client.apk');

  res.download(apkFilePath, 'client.apk', (err) => {
    if (err) {
      console.error('Download failed:', err);
      res.status(500).json({ message: 'Download failed' });
    }
  });
});


app.post('/stop', (req, res) => {
  if (botIsRunning) {
    if (client) {
      client.destroy();
      client = null;
      botIsRunning = false;
      console.log('Bot stopped');
    }
    res.status(200).json({ message: 'Bot stopped' });
  } else {
    res.status(200).json({ message: 'Bot is not running' });
  }
});

app.post('/alert', (req, res) => {
  const { alert_title, alert_description } = req.body;

  const newAnnouncement = {
    alert_title,
    alert_description,
  };

  announcements.unshift(newAnnouncement);

  res.status(201).json({ message: 'Announcement added' });
});

app.delete('/alert', (req, res) => {
  announcements.length = 0;
  res.json({ message: 'All announcements deleted' });
});


app.get('/alert', (req, res) => {
  res.status(200).json(announcements);
});

app.get('/', (req, res) => {
  const endpoints = app._router.stack
    .filter((layer) => layer.route)
    .map((layer) => ({
      path: layer.route.path,
      methods: layer.route.methods,
    }));
  res.status(200).json(endpoints);
});


app.post('/sendDM', async (req, res) => {
  const { userID, message } = req.body;
  const DISCORD_API = 'https://discord.com/api/v10';

  try {
    const userResponse = await axios.get(`${DISCORD_API}/users/${userID}`, {
      headers: {
        'Authorization': `Bot ${process.env.DISCORD_BOT_TOKEN}`,
      },
    });

    const userData = userResponse.data;

    if (userData.id) {
      const dmChannelResponse = await axios.post(`${DISCORD_API}/users/@me/channels`, {
        recipient_id: userID,
      }, {
        headers: {
          'Authorization': `Bot ${process.env.DISCORD_BOT_TOKEN}`,
          'Content-Type': 'application/json',
        },
      });

      const dmChannelData = dmChannelResponse.data;

      const dmMessageResponse = await axios.post(`${DISCORD_API}/channels/${dmChannelData.id}/messages`, {
        content: message,
      }, {
        headers: {
          'Authorization': `Bot ${process.env.DISCORD_BOT_TOKEN}`,
          'Content-Type': 'application/json',
        },
      });

      res.status(200).json({ message: 'Message sent successfully' });
    } else {
      res.status(404).json({ message: 'User not found' });
    }
  } catch (error) {
    console.error('Error sending message:', error);
    res.status(500).json({ message: 'Failed to send message', error: error.message });
  }
});

app.post('/sendMessage', async (req, res) => {
  const { channelID, message } = req.body;
  const DISCORD_API = 'https://discord.com/api/v10';

  try {
    const sendMessageResponse = await axios.post(`${DISCORD_API}/channels/${channelID}/messages`, {
      content: message,
    }, {
      headers: {
        'Authorization': `Bot ${process.env.DISCORD_BOT_TOKEN}`,
        'Content-Type': 'application/json',
      },
    });

    res.status(200).json({ message: 'Message sent successfully to the channel' });
  } catch (error) {
    console.error('Error sending message to channel:', error);
    res.status(500).json({ message: 'Failed to send message to channel', error: error.message });
  }
});


app.post('/CreateArea', async (req, res) => {
  const { channelID, time, message } = req.body;
  const DISCORD_API = 'https://discord.com/api/v10';

  if (!channelID || !time || !message) {
    return res.status(400).json({ message: 'Invalid JSON. Channel ID, time, and message are required.' });
  }
  areaInfoList.unshift({ channelID, time, message });

  const scheduledTask = cron.schedule('* * * * *', async () => {
    const executionTime = new Date().toISOString();
    const executionHour = new Date().getUTCHours();
    const executionMinute = new Date().getUTCMinutes();

    console.log(`Scheduled task executed at ${executionTime}`);

    const [requestedHour, requestedMinute] = time.split(':');

    if (executionHour === parseInt(requestedHour) && executionMinute === parseInt(requestedMinute)) {
      try {
        await axios.post(`${DISCORD_API}/channels/${channelID}/messages`, {
          content: message,
        }, {
          headers: {
            'Authorization': `Bot ${process.env.DISCORD_BOT_TOKEN}`,
            'Content-Type': 'application/json',
          },
        });

        console.log(`Message sent to Discord at ${executionTime}`);
      } catch (error) {
        console.error('Error sending message to Discord:', error);
      }
    } else {
      console.log(`Current time is ${executionHour}:${executionMinute} while the task has to be executed at ${time}`);
    }
  });

  scheduledTasks.push(scheduledTask);

  res.status(201).json({ message: 'Area created and scheduled' });
});

app.post('/StopArea', (req, res) => {
  scheduledTasks.forEach(task => task.stop());
  scheduledTasks.length = 0;

  areaInfoList = [];

  res.status(200).json({ message: 'All tasks stopped and area information deleted' });
});

app.get('/AreaInfo', (req, res) => {
  res.status(200).json(areaInfoList);
});



app.listen(port, () => {
  console.log(`Server is running on port ${port}`);
});
