const { app, BrowserWindow } = require('electron');
const { autoUpdater } = require('electron-updater');
const path = require('path');

let mainWindow;

app.on('ready', () => {
  mainWindow = new BrowserWindow({
    width: 1920,
    height: 1080,
    webPreferences: {
      nodeIntegration: true
    }
  });

  mainWindow.loadFile('dashboard.html');

  mainWindow.webContents.on('dom-ready', () => {
    mainWindow.webContents.insertCSS(`
      body {
        background-image: url('dashboard_bg.gif');
        background-size: cover;
        margin: 0;
        padding: 0;
      }
    `);
  });
});
