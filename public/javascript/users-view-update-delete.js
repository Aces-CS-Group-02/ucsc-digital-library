var form = document.getElementById("modal-form");



// Get the modal
var modal = document.getElementById("myModal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// Get the okay button
var btnOkay = document.getElementById("okayBtn");

// When the user clicks on the button, open the modal
function showModal(type, myBtn, id, fName, lName) {
    // console.log(fName, lName);
    modal.style.display = "flex";
    var elem = document.getElementById("idOut");
    elem.value = id;
    if (type) {
        document.getElementById("mtitle").innerText = "Reason for approval of ";
        form.action = "/admin/verify-new-users";
    } else {
        document.getElementById("mtitle").innerText = "Reason for rejection of ";
        form.action = "/admin/reject-new-user";
    }
    document.getElementById("FName").innerText = fName;
    document.getElementById("LName").innerText = lName;

    // var name = "req_id";
    // var id_ = id;
    // document.cookie = escape(name) + "=" + escape(id_);
    // console.log(document.cookie);
    // alert(id);
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