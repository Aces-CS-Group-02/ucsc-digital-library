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


// const arrowChange = () => {
//   if (
//     sideBarExpandBtn.firstElementChild.classList.contains(
//       "fa-arrow-alt-circle-right"
//     )
//   ) {
//     sideBarExpandBtn.innerHTML = `<i class="fas fa-arrow-alt-circle-left"></i>`;
//   } else {
//     sideBarExpandBtn.innerHTML = `<i class="fas fa-arrow-alt-circle-right"></i>`;
//   }
// };

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

for(var i=0; i < notesBtns.length; i++){
  notesBtns[i].addEventListener("click", () => {
    noteModal.style.display = "flex";
  });
}

// When the user clicks on <span> (x), close the notes-modal
noteSpan.onclick = function () {
  noteModal.style.display = "none";
};

// Content container from here

let url = "/docs/a-christmas-carol.pdf";

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
