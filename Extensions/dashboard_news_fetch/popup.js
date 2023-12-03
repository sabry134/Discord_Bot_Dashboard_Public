chrome.runtime.onMessage.addListener(function(request, sender, sendResponse) {
  if (request.action === 'data_received') {
    displayData(request.data);
  }
});

chrome.tabs.query({ active: true, currentWindow: true }, function(tabs) {
  chrome.tabs.sendMessage(tabs[0].id, { action: 'get_data' });
});

function displayData(data) {
  const contentDiv = document.getElementById('content');
  contentDiv.innerHTML = '';

  const announcement = document.createElement('div');
  announcement.className = 'announcement';
  announcement.innerHTML = '<strong>Dashboard Template Alerts<br></br></strong>';
  contentDiv.appendChild(announcement);

  const lineBreak1 = document.createElement('div');
  lineBreak1.className = 'line-break';
  contentDiv.appendChild(lineBreak1);

  if (data.length === 0) {
    const noneMessage = document.createElement('div');
    noneMessage.className = 'none-message';
    noneMessage.innerHTML = '<em>None</em>';
    contentDiv.appendChild(noneMessage);
  } else {
    data.forEach(item => {
      const card = document.createElement('div');
      card.className = 'card';
      card.innerHTML = `<strong>${item.alert_title}</strong><br>${item.alert_description}`;
      contentDiv.appendChild(card);
    });
  }
}
