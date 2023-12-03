document.getElementById('changeToBackground1').addEventListener('click', function () {
  chrome.tabs.query({ active: true, currentWindow: true }, function (tabs) {
    chrome.tabs.sendMessage(tabs[0].id, { action: 'changeBackground', url: 'https://cdn.discordapp.com/attachments/1023567577831718963/1177024952675872840/dashboard_bg.gif' });
  });
});

document.getElementById('changeToBackground2').addEventListener('click', function () {
  chrome.tabs.query({ active: true, currentWindow: true }, function (tabs) {
    chrome.tabs.sendMessage(tabs[0].id, { action: 'changeBackground', url: 'https://cdn.discordapp.com/attachments/1023567577831718963/1177034124880515072/sparkles_night.jpg' }, function (response) {
      console.log(response);
    });
  });
});

document.getElementById('changeToBackground3').addEventListener('click', function () {
  chrome.tabs.query({ active: true, currentWindow: true }, function (tabs) {
    chrome.tabs.sendMessage(tabs[0].id, { action: 'changeBackground', url: 'https://wallpapers.com/images/hd/background-night-sky-hd-on-high-resolution-nature-background-of-ugibtf7wjb0qeg27.jpg' }, function (response) {
      console.log(response);
    });
  });
});

document.getElementById('changeToBackground4').addEventListener('click', function () {
  chrome.tabs.query({ active: true, currentWindow: true }, function (tabs) {
    chrome.tabs.sendMessage(tabs[0].id, { action: 'changeBackground', url: 'https://dottech.org/wp-content/uploads/2014/04/armenia_aragats_8-wallpaper-1920x1080.jpg' }, function (response) {
      console.log(response);
    });
  });
});

chrome.storage.local.get(['backgroundUrl'], function (result) {
  if (result.backgroundUrl) {
    chrome.tabs.query({ active: true, currentWindow: true }, function (tabs) {
      chrome.tabs.sendMessage(tabs[0].id, { action: 'changeBackground', url: result.backgroundUrl });
    });
  }
});
