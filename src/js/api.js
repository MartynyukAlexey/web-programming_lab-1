const checkCoordinates = (data) => {
    const requestOptions = {
        method: "Post",
        body: data,
    };

    fetch("./check-coordinates.php", requestOptions)
        .then((response) => {
            if (!response.ok) {
                return Promise.reject(response);
            }
            return response.json();
        })

        .then((data) => {
            const message = document.getElementById("generated-message");
            const image = document.getElementById("generated-image");

            if (data.hasOwnProperty("result")) {
                message.innerText = data["result"]
                    ? "You hit the area!"
                    : "Unfortunately, you missed ^(";
            } else {
                message.innerText =
                    "Server sent inalid respone. Try back later.";
            }

            if (data.hasOwnProperty("image")) {
                image.src = "data:image/jpeg;base64," + data["image"];
            } else {
                image.src = "../img/php-elephant.svg";
            }
        })

        .catch((error) => {
            console.log("Error in checkCoordinates(), api.js", error);

            document.getElementById("generated-message").innerText =
                "Something went wrong... Try back later.";
        });
};

const loadTable = () => {
    const table = document.getElementById("generated-table");
    table.replaceChildren();

    fetch("./check-history.php", { method: "POST" })
        .then((response) => {
            if (!response.ok) {
                return Promise.reject(response);
            }
            return response.json();
        })
        .then((json) => {
            const headersTableRow = table.insertRow();
            const headers = ["request_id", "request_time", "x", "y", "r", "result"];

            for (const header of headers) {
                headersTableRow
                    .insertCell()
                    .appendChild(document.createTextNode(header));
            }

            for (const jsonRow of json) {
                const tableRow = table.insertRow();

                for (const header of headers) {
                    const value =
                        header === "request_time"
                            ? new Date(jsonRow[header] * 1000).toLocaleString()
                            : jsonRow[header];
                    tableRow
                        .insertCell()
                        .appendChild(document.createTextNode(value));
                }
            }
        })
        .catch((error) => {
            console.log("Error in loadTable(), loaders.js", error);
            
            table.replaceChildren();
            table
                .insertRow()
                .insertCell()
                .appendChild(
                    document.createTextNode("Something went wrong...")
                );
        });
};

loadTable();
setInterval(loadTable, 3000);
