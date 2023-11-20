const XYvalidator = (input) => {
    input = Number(input);

    if (!Number.isInteger(input)) {
        return [false, "Must be an integer"];
    }

    if (Number.parseInt(input) <= -1000) {
        return [false, "Must be greater than -1000"];
    }

    if (Number.parseInt(input) >= 1000) {
        return [false, "Must be less than 1000"];
    }

    return [true, ""];
};

const Rvalidator = (input) => {
    input = Number(input);

    if (!Number.isInteger(input)) {
        return [false, "Must be an integer"];
    }

    if (Number.parseInt(input) <= 0) {
        return [false, "Must be positive"];
    }

    if (Number.parseInt(input) >= 1000) {
        return [false, "Must be less than 1000"];
    }

    return [true, ""];
};

const formValidator = () => {
    const x = document.getElementById("form_x");
    const y = document.getElementById("form_y");
    const r = document.getElementById("form_r");

    return (
        XYvalidator(x.value)[0] &&
        XYvalidator(y.value)[0] &&
        Rvalidator(r.value)[0]
    );
}

document.getElementById("form_x").addEventListener("input", (e) => {
    const label = document.getElementById("form_x-label");

    if (XYvalidator(e.target.value)[0]) {
        label.style.display = "none";
    } else {
        label.style.display = "block";
        label.innerHTML = XYvalidator(e.target.value)[1];
    }
});

document.getElementById("form_y").addEventListener("input", (e) => {
    const label = document.getElementById("form_y-label");

    if (XYvalidator(e.target.value)[0]) {
        label.style.display = "none";
    } else {
        label.style.display = "block";
        label.innerHTML = XYvalidator(e.target.value)[1];
    }
});

document.getElementById("form_r").addEventListener("input", (e) => {
    const label = document.getElementById("form_r-label");

    if (Rvalidator(e.target.value)[0]) {
        label.style.display = "none";
    } else {
        label.style.display = "block";
        label.innerHTML = Rvalidator(e.target.value)[1];
    }
});
