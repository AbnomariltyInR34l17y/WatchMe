const getWalletForm = document.getElementById("get_wallet_form");

async function fetchWallet() {
    let importantInput = document.getElementById("important_input");
    if (checkVariableType(importantInput, "string")) {
        const data = {
            action: "getMyWallet",
            password: importantInput.value,
        };
        const askApi = await apiCommunicationHandler("POST", data);
        if (askApi.status) {
            alert("WOW!, wallet loaded!");
            window.location = "/WatchMe/public/my-profile.php";
        } else {
            alert(askApi.message);
            console.log("Another try bites the dust");
        }
    } else {
        alert("Your input is not correct");
    }
}

getWalletForm.addEventListener("submit", async function (event) {
    event.preventDefault();
    fetchWallet();
});
