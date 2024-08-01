const submitButton = document.getElementById("submit");
const mainRegisterForm = document.getElementById("login_form");

async function loginProcess(event) {
    const incomeUserText = document.getElementById("username_input").value;
    const incomeImportantText = document.getElementById("important_input").value;
    let requestMethod = "POST";
    let selectedActivity = "logMeIn";

    event.preventDefault();
    if (checkVariableType(incomeUserText, "string") && checkVariableType(incomeImportantText, "string")) {
        let requestBody = {
            action: selectedActivity,
            username: incomeUserText,
            password: incomeImportantText,
        };
        const responseCallData = await apiCommunicationHandler(requestMethod, requestBody);
        if (responseCallData.status_code === 409 || !responseCallData.status) {
            alert(responseCallData.message);
        } else if (responseCallData.status) {
            alert("Login done! let's go to watch some movies!");
            window.location = "/WatchMe/public/explore-videos.php";
        } else {
            console.error("Now, what was that?!");
            alert(responseCallData.message);
        }
    } else {
        alert("Something is wrong with the input");
        console.error("Which inputs are you sending there?");
    }
}

mainRegisterForm.addEventListener("submit", function (e) {
    loginProcess(e);
});
