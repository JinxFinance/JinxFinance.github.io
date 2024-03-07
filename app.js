document.getElementById('stock-form').addEventListener('submit', function(event) {
  event.preventDefault();

  var ticker = document.getElementById('ticker').value;
  var interval = document.getElementById('interval').value;
  var startDate = document.getElementById('start-date').value;
  var endDate = document.getElementById('end-date').value;

  var apiKey = 'YOUR_ALPHA_VANTAGE_API_KEY'; // Replace with your API key

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

