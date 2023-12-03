// popup.js

document.addEventListener('DOMContentLoaded', function () {
  chrome.tabs.query({ active: true, currentWindow: true }, function (tabs) {
      var currentTab = tabs[0];
      updatePopupContent(currentTab.url);
  });
});

function updatePopupContent(url) {
  var titleElement = document.getElementById('popup-title');
  var descriptionElement = document.getElementById('popup-description');

  if (url.includes('localhost:8080/admin/dashboard.php')) {
      titleElement.textContent = 'Dashboard';
      descriptionElement.textContent = 'Dashboard info';
  } else if (url.includes('localhost:8080/admin/webhook_manager.php')) {
      titleElement.textContent = 'Webhook';
      descriptionElement.textContent = 'Webhook info';
  } else if (url.includes('localhost:8080/admin/commands.php')) {
      titleElement.textContent = 'Commands';
      descriptionElement.textContent = 'Commands info';
  } else if (url.includes('localhost:8080/admin/alerts.php')) {
      titleElement.textContent = 'Alerts';
      descriptionElement.textContent = 'Alerts info';
  } else if (url.includes('localhost:8080/admin/message.php')) {
      titleElement.textContent = 'Messages';
      descriptionElement.textContent = 'Messages info';
  } else if (url.includes('localhost:8080/admin/documentation.php')) {
      titleElement.textContent = 'Documentation title';
      descriptionElement.textContent = 'Documentation description';
  } else if (url.includes('localhost:8080/admin/area.php')) {
      titleElement.textContent = 'AREA title';
      descriptionElement.textContent = 'AREA description';
  } else if (url.includes('http://localhost:8080/admin/settings.php')) {
      titleElement.textContent = 'Settings title';
      descriptionElement.textContent = 'Settings description';
  } else {
      titleElement.textContent = 'Incoming page description';
      descriptionElement.textContent = 'Whoops! Looks like you\'re on a page that doesn\'t have a description yet.';
  }
}
