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

var form = document.getElementById("modal-form");

// Get the modal
var modal = document.getElementById("approveModal");
var modalContent = document.getElementById("modal-content");

var span = document.getElementsByClassName("close")[0];

function showModal(type, myBtn, id) {
  // console.log(type, myBtn, id);
  modal.style.display = "flex";
  var elem = document.getElementById("idOut");
  elem.value = id;
  if (type) {
    document.getElementById("mtitle").innerText = "Reason for approval";
    form.action = "/admin/approve-submissions";
  } else {
    document.getElementById("mtitle").innerText = "Reason for rejection";
    form.action = "/admin/reject-submissions";
  }
}

span.onclick = function () {
  modal.style.display = "none";
};

window.onclick = function(event) {
  if (event.target == modal) {
    // console.log("modal clicked");
    modal.style.display = "none";
  }
}
