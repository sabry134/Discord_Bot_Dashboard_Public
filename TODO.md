__**Implemented:**__

- Dynamic documentation
- Basic bot management
- Dockerized
- Alert system for bot managers
- Permission system (access to dashboard per whitelisted ID)
- Bot Status system
- Client.apk for mobile implemented on the docker (shared volume)
- Page for which the bot sends a DM when you click on a button with a specific message (and user ID)
- Page for which the bot sends a message on a discord channel for announcements for example
- Design improvements (animation with GIF)
- Commands system to implement on the admin dashboard
- Inbox system 
- On the user interface, create a button to send a message to the administrators of the dashboard (e.g "Message the Mods" button)
- Servers where the bot is in
- GitHub Integration: Connect the bot to a GitHub repository for version control and updates.
- On server scroll, you show the server details (Example https://imgur.com/Q3hJ7pS.png)
- User Dashboard
- Settings System -> Goes with package system

__**In progress**__

- Mobile app for the dashboard (0%)
- Detailed documentation, currently available [here](https://sabry134.github.io/Discord-Bot-Dashboard/) (90%)
- Extensions that allows to code your own plugins (See Extensions folder) (10%)
- Merge all the web extensions inside one
- Desktop application for PC users (80% -> Outdated)
- Christmas/Haloween/Snow theme to toggle (0%)



**__TODO:__**

- Responsive design
- Implement more AREA related to discord
- Packages that allows you to create new pages and more discord projects (like a discord project system + website logs on webhook)
- Page improvements (Message page for example)
- Webhook Management: Allow users to manage and create webhooks through the dashboard.
- Third-Party Plugin Support: Enable users to add third-party plugins to enhance bot functionality.
- Tutorial/Guide System: Create a system to guide new users through the features of the dashboard.
- Embed Message Builder: Create an interface to easily design and send rich embed messages.



**__Devops Related TODO__**

- Jenkins system to test the images and get the health of images -> Also making it possble to run an image through Jenkins
- More deployment systems
- Kubernetes multi nodes deployment
- Ansible VM to test the deployment
