document.getElementById("form").addEventListener("submit", (e) => {
    e.preventDefault();

    const errorField = document.getElementById("form_button-label");

    if (formValidator()) {
        const data = new FormData(e.target);
        data.append("time", new Date().getTime());

        checkCoordinates(data);

        errorField.style.display = "none";
        e.target.reset();
    } else {
        errorField.style.display = "block";
        errorField.innerHTML = "Check the input and try again";
    }
});
