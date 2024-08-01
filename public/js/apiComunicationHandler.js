// This is where communication sent to the API
async function apiCommunicationHandler(method, data) {
    let url = "/WatchMe/api/api.php";

    try {
        const request = {
            method: method,
            headers: {
                "Content-Type": "application/json",
            },
        };
        // Append data to request if you have
        if (data) request.body = JSON.stringify(data);

        const response = await fetch(url, request);
        const responseData = await response.json();
        return responseData;
    } catch (error) {
        // TODO: change error log
        return error;
    }
}
