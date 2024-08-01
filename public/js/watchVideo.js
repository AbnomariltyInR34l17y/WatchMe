const movieTitle = document.getElementById("movie_title");
const movieDescription = document.getElementById("movie_description");
const iframeVideoTag = document.getElementById("big_video_tag"); // Dynamicly changing the source
const buyMeButton = document.getElementById("watch_me_button");

// Involving the URL paramater. Get URL > param.id > parse to integer
let params = new URL(document.location).searchParams;
const paramId = params.get("id");
const movieId = parseInt(paramId, 10);

// Ask the user to confirm
async function buyingTheMovie() {
    let hasConfirmedBuy = confirm("Are you sure you want to buy this movie?");
    if (hasConfirmedBuy) {
        let requestBody = {
            action: "iWantThis",
            movieId: paramId,
        };

        const responseCallData = await apiCommunicationHandler("POST", requestBody);
        if (responseCallData.status) {
            alert("Have fun!");
            iframeVideoTag.classList.remove("non_clickable");
            iframeVideoTag.play;
        } else {
            alert(responseCallData.message);
        }
    } else {
        location.reload();
    }
}

// When the page load it will replace the content of the tags
async function startLoadingThePage() {
    let params = new URL(document.location).searchParams;
    const paramId = params.get("id");
    const movieId = parseInt(paramId, 10);

    // Check that params is indead in the URL
    if (
        !params.has("id") ||
        paramId === null ||
        paramId === undefined ||
        paramId === "" ||
        movieId < 1 ||
        params.length < 2 ||
        typeof movieId !== "number" ||
        isNaN(movieId)
    ) {
        window.location.replace("/WatchMe/public/watch-video.php?id=1");
    }

    let requestBody = {
        action: "getOneMovie",
        movieId: paramId,
    };

    // The actual request
    const responseCallData = await apiCommunicationHandler("POST", requestBody);
    if (responseCallData.status) {
        let movieTitleString = responseCallData.data["movie_title"];
        movieTitle.textContent = movieTitleString;
        movieDescription.textContent = responseCallData.data["movie_description"];
        iframeVideoTag.src = responseCallData.data["movie_link"];
        iframeVideoTag.title = movieTitleString;
    } else {
        movieTitle.textContent = "Are you sure there is a movie like this?";
        movieDescription.textContent = "Please try again with a different movie ID";
        iframeVideoTag.src = "";
    }
}

document.addEventListener("DOMContentLoaded", function () {
    startLoadingThePage();
});

// Add a click event listener to the video element
buyMeButton.addEventListener("click", async function () {
    buyingTheMovie();
});
