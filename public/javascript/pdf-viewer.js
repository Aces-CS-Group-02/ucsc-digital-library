const sideBarExpandBtn = document.querySelector("#side-bar-expand-btn");

const sideBarExpanded = document.querySelector(".pdf-viewer-side-bar-expanded");
const overlay = document.querySelector(".pdf-viewer-overlay");
const sidebarSectionExpandCollapsBtn = document.querySelector(
  ".side-bar-section-expand-collaps-btn"
);

const sidebarSectionContent = document.querySelector(
  ".side-bar-section-content"
);

// var notesBtns = document.querySelector("#add-notes-btn");
var notesBtns = document.getElementsByClassName("add-notes-btn");
var noteModal = document.getElementById("notesModal");
var noteSpan = document.getElementsByClassName("close-note")[0];

var collectionBtns = document.getElementsByClassName("add-to-collection-btn");
var collectionModal = document.getElementById("collectionsModal");
var collectionSpan = document.getElementsByClassName("close-collection")[0];

sideBarExpandBtn.addEventListener("click", () => {
  sideBarExpanded.classList.toggle("active");
  // arrowChange();
  overlay.classList.toggle("active");
});

overlay.addEventListener("click", () => {
  overlay.classList.remove("active");
  // arrowChange();

  sideBarExpanded.classList.toggle("active");
});

sidebarSectionExpandCollapsBtn.addEventListener("click", () => {
  sidebarSectionContent.classList.toggle("expand");

  if (
    sidebarSectionExpandCollapsBtn.firstElementChild.classList.contains(
      "fa-chevron-down"
    )
  ) {
    sidebarSectionExpandCollapsBtn.innerHTML = `<i class="fas fa-chevron-up"></i>`;
  } else {
    sidebarSectionExpandCollapsBtn.innerHTML = `<i class="fas fa-chevron-down"></i>`;
  }
});

for (var i = 0; i < notesBtns.length; i++) {
  notesBtns[i].addEventListener("click", () => {
    noteModal.style.display = "flex";
  });
}

// When the user clicks on <span> (x), close the notes-modal
noteSpan.onclick = function () {
  noteModal.style.display = "none";
};

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
  if (event.target == noteModal || event.target == collectionModal) {
    // console.log("modal clicked");
    collectionModal.style.display = "none";
    noteModal.style.display = "none";
  }
};

const getCollections = ({ currentTarget }) => {
  // AJAX request
  const collectionReq = new XMLHttpRequest();
  // let params = [];
  // params = `reg_no=${id}`;
  var url = "/ajax/get-user-collections";
  // var url = "/ajax/get-user-collections" + "&rand=" + new Date().getTime();
  // var randNo = parseInt(Math.random()*99999999);
  collectionReq.open("GET", url);
  collectionReq.onreadystatechange = getCollectionData;
  // collectionReq.send(params);
  collectionReq.send(null);
  collectionModal.style.display = "flex";
};

function getCollectionData() {
  var parentDiv = document.getElementById("collection-modal-collections");

  if (this.readyState == 4) {
    if (this.status == 200) {
      // console.log("got the data");
      parentDiv.innerHTML = "";
      var collections = JSON.parse(this.responseText);
      // console.log(collections);
      for (var collection of collections) {
        // console.log(collection["name"]);
        var div1 = document.createElement("div");
        div1.classList.add("input-group", "custom-control");
        parentDiv.appendChild(div1);
        var div2 = document.createElement("div");
        div2.classList.add("checkbox", "checkbox-edit");
        div1.appendChild(div2);
        var checkbx = document.createElement("input");
        checkbx.classList.add("checkbox", "checkbox-edit");
        checkbx.type = "checkbox";
        checkbx.id = collection["user_collection_id"];
        div2.appendChild(checkbx);
        var collectionName = document.createTextNode(collection["name"]);
        div2.appendChild(collectionName);
      }

      // alert("The server said:" + this.responseText);
    }
  }
}

for (var btn of collectionBtns) {
  btn.addEventListener("click", getCollections, false);
}

// When the user clicks on <span> (x), close the collections-modal
collectionSpan.onclick = function () {
  collectionModal.style.display = "none";
};

// function DivShowHide(check) {
//   var buttonDisplay = document.getElementById("save-btn-container");
//   var toHide = document.getElementById("create-and-save");
//   const checkboxes = document.querySelectorAll('input[type="checkbox"]');

//   let count = 0;
//   for (let checkbox of checkboxes) {
//     if (checkbox.checked) {
//       count++;
//     }
//   }

//   if (count) {
//     buttonDisplay.classList.add("display-save-btn");
//     toHide.classList.add("hide-create-and-save-btn");
//   } else {
//     buttonDisplay.classList.remove("display-save-btn");
//     toHide.classList.remove("hide-create-and-save-btn");
//   }
// }

document.querySelector(".create-collection").addEventListener("focus", () => {
  var buttonDisplay = document.getElementById("save-btn-container");
  var toHide = document.getElementById("create-and-save");
  const checkboxes = document.querySelectorAll('input[type="checkbox"]');
  for (let checkbox of checkboxes) {
    if (checkbox.checked) {
      checkbox.checked = false;
      buttonDisplay.classList.remove("display-save-btn");
      toHide.classList.remove("hide-create-and-save-btn");
    }
  }
});

// Content container from here

// var contentName = "<?php echo $url ?>";
console.log(contentUrl);

// var req = new XMLHttpRequest(); 
//     req.onload = function() {
//     console.log(this.responseText); 
//  };
// req.open("get", "get-data.php", true); 
// req.send();

let url = contentUrl;

let pdfDoc = null,
  pageNum = 1;

const scale = 1.5; // size of canvas
var div = document.querySelector("#pdf-render");

//   Render the pages
function renderPage(num) {
  // Get page
  pdfDoc.getPage(num).then((page) => {
    // console.log(page);

    // Set scale
    const viewport = page.getViewport({ scale });

    //Xreating a canvas for each page to draw it on
    var canvas = document.createElement("canvas");
    canvas.id = num;
    canvas.style.display = "flex";
    canvas.style.margin = "auto";
    canvas.style.overflow = "hidden";
    canvas.style.minHeight = "100vh";
    canvas.style.marginBottom = "5px";

    var ctx = canvas.getContext("2d");

    canvas.height = viewport.height;
    canvas.width = viewport.width;

    const renderContext = {
      canvasContext: ctx,
      viewport,
    };

    page.render(renderContext).promise.then(() => {
      //Add it to the web page
      div.appendChild(canvas);

      // Output current page num
      document.querySelector("#page-num").textContent = pageNum;

      if (num < pdfDoc.numPages) {
        num++;
        renderPage(num);
      }
    });
  });
}

// Get document
pdfjsLib
  .getDocument(url)
  .promise.then((pdfDoc_) => {
    pdfDoc = pdfDoc_;
    //   console.log(pdfDoc);

    document.querySelector("#page-count").textContent = pdfDoc.numPages;

    // renderPages(pdfDoc);
    renderPage(pageNum);
  })
  .catch((err) => {
    // Display error
    const div = document.createElement("div");
    div.className = "error";
    div.appendChild(document.createTextNode(err.message));
    document.querySelector("body").insertBefore(div, canvas);

    // Remove top bar
    document.querySelector(".top-bar").style.display = "none";
  });

document.querySelector("#scroll-div").addEventListener("scroll", () => {
  var scrollDiv = document.querySelector("#scroll-div");
  const scrolled = scrollDiv.scrollTop;
  // console.log(scrolled);

  var num = 1;
  const canvas = document.getElementById(num);
  const canvasHeight = canvas.scrollHeight;
  // console.log(canvasHeight);

  var pages = scrolled - canvasHeight;

  if (pages >= 1) {
    num++;
    if (pages >= canvasHeight) {
      while (pages >= canvasHeight) {
        var pages = pages - canvasHeight;
        num++;
      }
    }
    // console.log(num);
  }
  document.querySelector("#page-num").textContent = num;
});
