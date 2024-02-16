document.getElementById('form').addEventListener('submit', function(event) {
      event.preventDefault();
      fetchData();
});

function fetchData() {
  fetch('nasdaq.txt')
    .then(response => response.text())
    .then(data => {
      const lines = data.split('\n');
      const x = lines.map((_, i) => i);
      const y = lines;
      Plotly.newPlot('chart',
        [{
          x, y, type: 'line', name 'NASDAQ',
          line: {
            color: 'rgb(219, 64, 82)',
            width: 2
          }],
        { showlegend: true },
      );
  });
}

fetchData();
