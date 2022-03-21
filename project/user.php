<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>User UI</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h1>User UI</h1>

<hr>

<div id="container">
<form id="search-form">
    <h2>Search in DB:</h2>
    <div>
        <label for="search">Enter term:</label>
        <input id="search" name="search" type="text">
    </div>
    <div>
        <label for="language">Choose language in which you want to find the term:</label>
        <select name="languageCode" id="language">
            <option value ="sk">Slovenčina</option>
            <option value ="en">English</option>
        </select>
    </div>
    <div>
        <button id="search-button" type="button">Search</button>
    </div>
</form>
</div>

<hr>

<table id="result-table">
    <thead>
    <tr>
        <th>Term in chosen language:</th>
        <th>Description:</th>
        <th>Translate into second language</th>
        <th>Translated term:</th>
        <th>Translated description:</th>
    </tr>
    </thead>
    <tbody>

    </tbody>
</table>
<script>
    const form = document.querySelector("#search-form");
    const button = document.querySelector("#search-button");
    const table = document.querySelector("#result-table");
    const tbody = document.querySelector("#result-table").tBodies[0];

    button.addEventListener('click', () =>{
        const data = new FormData(form); // Get data from form
        fetch("translationforuser.php?search="+data.get('search')+"&languageCode="+data.get('languageCode'),
            {method: "get"}
        )
            .then(response => response.json())
            .then(result => {
                result.forEach(item => {
                    const tr = document.createElement("tr");

                    const td1 = document.createElement("td");
                    td1.append(item.searchTitle);

                    const td2 = document.createElement("td");
                    td2.append(item.searchDescription);

                    const td3 = document.createElement("td");

                    const td4 = document.createElement("td");

                    const td5 = document.createElement("td");

                    const button = document.createElement("button");
                    button.append("Translate");
                    button.addEventListener("click", () => {
                        td4.append(item.translatedTitle); //show translations in next column
                        td5.append(item.translatedDescription);
                        button.disabled = true; //disable button after first click
                    });

                    td3.append(button);
                    tr.append(td1);
                    tr.append(td2);
                    tr.append(td3);
                    tr.append(td4);
                    tr.append(td5);
                    tbody.append(tr);
                })
            })
    })
</script>
</body>
</html>