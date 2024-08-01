// Import moveis from DB and show them on the screen
async function fetchMovies() {
    const data = {
        action: "getAllMovies",
    };

    try {
        const askApi = await apiCommunicationHandler("POST", data);
        displayMovies(askApi.data);
    } catch (error) {
        console.error("I see what you are doing there!");
        alert("The information about movies is not found");
    }
}

// (almost) Main function in this file
function displayMovies(movies) {
    const moviesContainer = document.getElementById("movies_container");

    // Iterate throgh the result to show it to the user
    movies.forEach((movie) => {
        const movieDiv = document.createElement("div");
        const h1Tag = document.createElement("h1");
        const pTag = document.createElement("p");

        // The <p> for the text inside the button
        const pInButtonTag = document.createElement("p");
        const buttonTag = document.createElement("button");

        h1Tag.textContent = movie.movie_title;
        pTag.textContent = movie.movie_description;
        pInButtonTag.textContent = `Buy for ${movie.movie_price}$`;

        movieDiv.classList.add("movie_card");
        h1Tag.classList.add("movie_title");
        pTag.classList.add("movie_description");
        buttonTag.classList.add("buy_button");

        buttonTag.addEventListener("click", function (event) {
            event.preventDefault();
            buyMovie(movie.id);
        });

        movieDiv.appendChild(h1Tag);
        movieDiv.appendChild(pTag);
        buttonTag.appendChild(pInButtonTag);
        movieDiv.appendChild(buttonTag);

        moviesContainer.appendChild(movieDiv);
    });
}

// Dynamicly create a link to inhebit the <button> onclick
function buyMovie(movieId) {
    window.location = `/WatchMe/public/watch-video.php?id=${movieId}`;
}

// Call the fetchMovies function to fetch and display movies when the page loads
window.addEventListener("load", fetchMovies);
