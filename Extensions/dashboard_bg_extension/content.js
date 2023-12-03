console.log('Content script loaded');

const isExcluded = isExcludedUrl(window.location.href);

if (!isExcluded) {
  chrome.storage.local.get(['backgroundUrl'], function (result) {
    if (result.backgroundUrl) {
      document.body.style.backgroundImage = `url(${result.backgroundUrl})`;
    }
  });

  chrome.runtime.onMessage.addListener(async function (request, sender, sendResponse) {
    if (request.action === "changeBackground") {
      document.body.style.backgroundImage = `url(${request.url})`;
      await chrome.storage.local.set({ backgroundUrl: request.url });
    }
  });
}

function isExcludedUrl(url) {
  return (
    url.includes('http://localhost:8080/about.json') ||
    url.includes('http://localhost:8080/admin/index.php')
  );
}
