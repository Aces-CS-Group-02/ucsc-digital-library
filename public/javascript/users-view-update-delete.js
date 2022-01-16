var form = document.getElementById("modal-form");

// Get the modal
var modal = document.getElementById("myModal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// Get the okay button
var btnOkay = document.getElementById("okayBtn");

// When the user clicks on the button, open the modal
function showModal(id, fName, lName) {

    modal.style.display = "flex";
    var elem = document.getElementById("idOut");
    elem.value = id;

    document.getElementById("mtitle").innerText = "Reason for deleting  ";
    form.action = "/admin/users/delete";

    document.getElementById("FName").innerText = fName;
    document.getElementById("LName").innerText = lName;


}
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
};

// When the user clicks on the okay button, close the modal
btnOkay.onclick = function() {
    modal.style.display = "none";
};

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
};