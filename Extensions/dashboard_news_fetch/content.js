chrome.runtime.onMessage.addListener(function(request, sender, sendResponse) {
  if (request.action === 'get_data') {
    fetch('http://localhost:3000/alert')
      .then(response => response.json())
      .then(data => {
        chrome.runtime.sendMessage({ action: 'data_received', data: data });
      })
      .catch(error => console.error('Error fetching data:', error));
  }
});

chrome.runtime.sendMessage({ action: 'get_data' });
