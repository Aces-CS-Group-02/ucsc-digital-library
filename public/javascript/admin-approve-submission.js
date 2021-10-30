function DivShowHide(check) {
    var buttonDisplay = document.getElementById("buttonDiv");
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');

    let count = 0;
    for (let checkbox of checkboxes) {
        if (checkbox.checked) {
            count++;
        }
    }

    if (count) {
        buttonDisplay.classList.add("display-bulk-operation-btn");
    } else {
        buttonDisplay.classList.remove("display-bulk-operation-btn");
    }
}