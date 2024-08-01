const updateFormTag = document.getElementById("update_details");
const applyChangesButton = document.getElementById("logoutButton");

updateFormTag.addEventListener("submit", async function () {
    const approveChanges = confirm("Are you sure you want to commit the changes?");
    if (approveChanges) {
        let incomeUserText = document.getElementById("username_input").value;
        let incomeImportantText = document.getElementById("important_input").value;
        if (checkVariableType(incomeUserText, "string") && checkVariableType(incomeImportantText, "string")) {
            let requestMethod = "POST";
            let requestBody = {
                action: "updateUserInformation",
                username: incomeUserText,
                password: incomeImportantText,
            };
            const responseCallData = await apiCommunicationHandler(requestMethod, requestBody);
            alert(responseCallData.message);
        }
    }
});

applyChangesButton.addEventListener("click", function () {
    window.location = "/WatchMe/public/logout.php";
});
