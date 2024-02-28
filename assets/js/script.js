function handleKeyPress(event) {
    if (event.keyCode === 13) {
        search();
    }
}

function search() {
    var text = document.getElementById('searchInput').value;

    if (text.trim() !== '') {
        fetchResults(text);
    } else {
        var resultsContainer = document.getElementById('resultsContainer');
        resultsContainer.innerHTML = '';
        showAlert('alert-danger', 'Search field is required.');
    }
}

function fetchResults(text) {
    fetch('https://es.wikipedia.org/w/api.php?action=query&format=json&variant=en&origin=*&list=search&utf8=1&srsearch=' + text)
        .then(response => {
            return response.json();
        })
        .then(data => {
            displayResults(data.query.search);
            saveHistory(text, data.query.search);
        })
        .catch(error => {
            showAlert('alert-danger', 'Error al obtener resultados: ' + error);
        });
}

function displayResults(results) {
    var resultsContainer = document.getElementById('resultsContainer');
    resultsContainer.innerHTML = '';

    if (results.length === 0) {
        resultsContainer.innerHTML = '<p>No results found.</p>';
    } else {
        results.forEach(result => {
            var card = document.createElement('div');
            card.classList.add('result-card');
            card.innerHTML = '<h3>' + result.title + '</h3>' +
                '<p>' + result.snippet + '...</p><p><a href="https://es.wikipedia.org/wiki/' + result.title + '" target="_blank">Go to link <i class="fa-solid fa-arrow-up-right-from-square"></i></a></p>';
            resultsContainer.appendChild(card);
        });
    }
}

function saveHistory(text, results) {
    var data = {
        text: text,
        results: results
    };

    fetch('/functions/WikipediaHistory/HistoryController.php?action=save', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(response => {
            if (!response.ok) {
                showAlert('alert-danger', 'Error calling controller to save data');
            }

            return response.json();
        })
        .then(data => {
            showAlert('alert-success', data.message);
        })
        .catch(error => {
            showAlert('alert-danger', 'An error occurred: ' + error);
        });
}

function showAlert(variant, message) {
    resetAlertClass();

    var alertText = document.getElementById('alertText');
    alertText.textContent = message;

    var alert = document.getElementById('alertInfo');
    alert.className = 'alert ' + variant;
    alert.style.display = "block";

    setTimeout(function () {
        closeAlert();
    }, 3000);
}

function resetAlertClass() {
    var alert = document.getElementById('alertInfo');
    alert.className = '';
}

function closeAlert() {
    var alert = document.getElementById('alertInfo');
    alert.style.display = "none";
}