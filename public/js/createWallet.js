const submitButton = document.getElementById("submit");
const mainRegisterForm = document.getElementById("create_wallet_form");

async function registrationProcess() {
    const incomeImportantText = document.getElementById("important_input").value;

    if (checkVariableType(incomeImportantText, "string")) {
        let incomeImportantText2 = document.getElementById("important_input2").value;
        checkVariableType(incomeImportantText2, "string");
        // Secound Password validation
        if (incomeImportantText2 === incomeImportantText) {
            let requestBody = {
                action: "createNewWallet",
                password: incomeImportantText2,
            };

            const responseCallData = await apiCommunicationHandler("POST", requestBody);
            if (responseCallData["status"]) {
                console.log(responseCallData);
                alert("You have a new wallet");
                window.location = "/WatchMe/public/explore-videos.php";
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
    e.preventDefault();
    registrationProcess(e);
});
