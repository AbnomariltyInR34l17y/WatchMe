const submitButton = document.getElementById("submit");
const mainRegisterForm = document.getElementById("register_form");

async function registrationProcess(event) {
    const incomeUserText = document.getElementById("username_input").value;
    const incomeImportantText = document.getElementById("important_input").value;
    let requestMethod = "POST";
    let selectedActivity = "signMeUp";

    event.preventDefault();
    if (checkVariableType(incomeUserText, "string") && checkVariableType(incomeImportantText, "string")) {
        let incomeImportantText2 = document.getElementById("important_input2").value;
        checkVariableType(incomeImportantText2, "string");
        // Secound validation
        if (incomeImportantText2 === incomeImportantText) {
            let requestBody = {
                action: selectedActivity,
                username: incomeUserText,
                password: incomeImportantText2,
            };
            const responseCallData = await apiCommunicationHandler(requestMethod, requestBody);
            if (responseCallData.status) {
                alert("Regestration done! let's go to login");
                window.location = "/WatchMe/public/login.php";
                return;
            } else {
                alert(responseCallData.message);
            }
        } else {
            alert("Passwords are not matching. Please try again");
        }
    } else {
        alert("Something is wrong with the input");
        console.error("Which inputs are you sending there?");
    }
}

mainRegisterForm.addEventListener("submit", function (e) {
    registrationProcess(e);
});
