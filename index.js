window.addEventListener('DOMContentLoaded', (event) => {
      const fileForm = document.getElementById('fileForm');
      const fileContent = document.getElementById('fileContent');
      const toggleButton = document.getElementById('toggleButton');

      function loadFile(file) {
                fetch(file)
                    .then(response => response.text())
                    .then(data => {
                                      fileContent.textContent = data;
                                  });
            }

      fileForm.addEventListener('change', (event) => {
                loadFile(event.target.value);
            });

      toggleButton.addEventListener('click', (event) => {
                const nasdaqRadio = document.getElementById('nasdaq');
                const jinxRadio = document.getElementById('jinx');

                if (nasdaqRadio.checked) {
                              jinxRadio.checked = true;
                              loadFile(jinxRadio.value);
                          } else {
                                        nasdaqRadio.checked = true;
                                        loadFile(nasdaqRadio.value);
                                    }
            });

      loadFile('nasdaq.txt');
});
