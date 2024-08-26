document.getElementById('evaluateButton').addEventListener('click', function () {
    var inputText = document.getElementById('inputText').value;
    var outputText = document.getElementById('outputText');

    // Show progress bar
    outputText.innerHTML = 'Analyzing... Please wait...';

    // Prepare the data to be sent
    var data = JSON.stringify({ text: inputText });

    // Create an AJAX request
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/translate.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                outputText.value = response.response;
            } else {
                outputText.value = 'Error: Unable to analyze text.  Please try again!';
            }
        }
    };

    // Send the request with the input text
    xhr.send(data);
});