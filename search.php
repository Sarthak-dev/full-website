<!DOCTYPE html>
<html>
<head>
    <title>Blog Search</title>
    <style>
        body {
            background-color: #ffd8d8;
        }
        .search-bar {
            text-align: center;
            margin-top: 50px;
            border-radius: 10px;
        }
        .search-bar input {
            width: 300px;
            font-size: 16px;
            border: none;
            border-radius: 10px;
            border: 8px solid white;
            outline: none; /* Remove default outline */
            padding: 10px;
        }
        .suggestions {
            list-style: none;
            padding: 0;
            margin-top: 10px;
            display: none;
            font-size: large;
        }
        .suggestions li {
            cursor: pointer;
            padding: 5px;
            font-size: large;
        }
        .suggestions li:hover {
            background-color: #f5f5f5;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="search.css">
</head>
<body>
    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Search Posts..." onkeyup="getSuggestions(this.value)">
        <ul id="suggestionsList" class="suggestions"></ul>
    </div>

    <script>
        function getSuggestions(query) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    displaySuggestions(this.responseText);
                }
            };
            xmlhttp.open("GET", "get_suggestions.php?query=" + query, true);
            xmlhttp.send();
        }

        function displaySuggestions(response) {
            var suggestionsList = document.getElementById("suggestionsList");
            suggestionsList.innerHTML = "";
            if (response != "") {
                var suggestions = JSON.parse(response);
                suggestions.forEach(function(suggestion) {
                    var listItem = document.createElement("li");
                    listItem.innerHTML = suggestion.title;
                    listItem.onclick = function() {
                        redirectToPostPage(suggestion.id);
                    };
                    suggestionsList.appendChild(listItem);
                });
                suggestionsList.style.display = "block";
            } else {
                suggestionsList.style.display = "none";
            }
        }

        function redirectToPostPage(postId) {
            window.location.href = "post.php?id=" + postId;
        }

        document.addEventListener("click", function(event) {
            var suggestionsList = document.getElementById("suggestionsList");
            if (!suggestionsList.contains(event.target)) {
                suggestionsList.style.display = "none";
            }
        });
    </script>
</body>
</html>
