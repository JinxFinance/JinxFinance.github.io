document.getElementById('stock-form').addEventListener('submit', function(event) {
  event.preventDefault();

  var ticker = document.getElementById('ticker').value;
  var interval = document.getElementById('interval').value;
  var startDate = document.getElementById('start-date').value;
  var endDate = document.getElementById('end-date').value;

  var apiKey = 'MD0ACNJ6QY9SQTZ0'; // Replace with your API key

  fetch(`https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=${ticker}&interval=${interval}&apikey=${apiKey}`)
    .then(response => response.json())
    .then(data => {
      // The data is in the 'Time Series (Interval)' object
      var timeSeries = data['Time Series (' + interval + ')'];

      // TODO: Filter the data based on the start and end dates

      // TODO: Display the data
    });
});

.then(data => {
  var resultsDiv = document.getElementById('results');
  resultsDiv.innerHTML = '';

  // TODO: Add pagination

  data.forEach(item => {
    var div = document.createElement('div');
    div.textContent = `${item.date}: ${item.price}`;
    resultsDiv.appendChild(div);
  });
});

if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('/service-worker.js')
    .then(function(registration) {
      console.log('Service Worker registered with scope:', registration.scope);
    })
    .catch(function(error) {
      console.log('Service Worker registration failed:', error);
    });
}


Notification.requestPermission().then(function(permission) {
  if (permission === 'granted') {
    console.log('Notification permission granted.');
  } else {
    console.log('Unable to get permission to notify.');
  }
});

navigator.serviceWorker.ready.then(function(registration) {
  if (!registration.pushManager) {
    console.log('Push manager unavailable.');
    return;
  }

  registration.pushManager.getSubscription().then(function(existedSubscription) {
    if (existedSubscription === null) {
      console.log('No subscription detected, make a request.');
      registration.pushManager.subscribe({
        applicationServerKey: urlBase64ToUint8Array('YOUR_PUBLIC_VAPID_KEY_HERE'),
        userVisibleOnly: true,
      }).then(function(newSubscription) {
        console.log('New subscription added.');
        // TODO: Send to application server
      }).catch(function(e) {
        if (Notification.permission !== 'granted') {
          console.log('Permission was not granted.');
        } else {
          console.error('An error ocurred during the subscription process.', e);
        }
      });
    } else {
      console.log('Existing subscription detected.');
    }
  });
})

self.addEventListener('push', function(event) {
  if (event.data) {
    console.log('Push event!! ', event.data.text());
    showLocalNotification('Yolo', event.data.text(), self.registration);
  } else {
    console.log('Push event but no data');
  }
});

const showLocalNotification = (title, body, swRegistration) => {
  const options = {
    body,
    // here you can add more properties like icon, image, vibrate, etc.
  };
  swRegistration.showNotification(title, options);
}

