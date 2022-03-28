const endDaySelect = document.getElementById("end-date");
const fromDaySelect = Document.getElementById("start-date");

// endDaySelect.addEventListener("select", (e) => {
//     var fromDate = fromDaySelect.target.value != 0;
//     var toDate = e.target.value;
//     console.log(fromDate, toDate);
//     if (e.target.value != 0 && fromDaySelect.target.value != 0) {
//       getCitations(e.target.value);
//     }
//   });

function displayError() {
    endDaySelect.classList.add("add-error");
}

