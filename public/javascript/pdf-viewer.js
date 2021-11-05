const sideBarExpandBtn = document.querySelector("#side-bar-expand-btn");

const sideBarExpanded = document.querySelector(".pdf-viewer-side-bar-expanded");
const overlay = document.querySelector(".pdf-viewer-overlay");
const sidebarSectionExpandCollapsBtn = document.querySelector(
  ".side-bar-section-expand-collaps-btn"
);

const sidebarSectionContent = document.querySelector(
  ".side-bar-section-content"
);

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

// Content container from here

let url = "/docs/a-christmas-carol.pdf";

let pdfDoc = null,
  pageNum = 1,
  pageIsRendering = false,
  pageNumIsPending = null;

const scale = 1.5, // size of canvas
  canvas = document.querySelector("#pdf-render"),
  ctx = canvas.getContext("2d");

//   Render the page
const renderPage = (num) => {
  pageIsRendering = true;

  // Get page
  pdfDoc.getPage(num).then((page) => {
    //   console.log(page);

    // Set scale
    const viewport = page.getViewport({ scale });
    canvas.height = viewport.height;
    canvas.width = viewport.width;

    const renderContext = {
      canvasContext: ctx,
      viewport,
    };

    page.render(renderContext).promise.then(() => {
      pageIsRendering = false;

      if (pageNumIsPending !== null) {
        renderPage(pageNumIsPending);
        pageNumIsPending = null;
      }
    });

    // Output current page num
    document.querySelector("#page-num").textContent = num;
  });
};

// Check for pages rendering
const queueRenderPage = (num) => {
  if (pageIsRendering) {
    pageNumIsPending = num;
  } else {
    renderPage(num);
  }
};

// Show previous page
const showPrevPage = () => {
  if (pageNum <= 1) {
    return;
  }

  pageNum--;
  queueRenderPage(pageNum);
};

// Show next page
const showNextPage = () => {
  if (pageNum >= pdfDoc.numPages) {
    return;
  }

  pageNum++;
  queueRenderPage(pageNum);
};

// Get document
pdfjsLib
  .getDocument(url)
  .promise.then((pdfDoc_) => {
    pdfDoc = pdfDoc_;
    //   console.log(pdfDoc);

    document.querySelector("#page-count").textContent = pdfDoc.numPages;

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

// Button events
document.querySelector("#prev-page").addEventListener("click", showPrevPage);
document.querySelector("#next-page").addEventListener("click", showNextPage);
