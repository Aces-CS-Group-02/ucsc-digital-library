const sideBarExpandBtn = document.querySelector("#side-bar-expand-btn");

const sideBarExpanded = document.querySelector(".pdf-viewer-side-bar-expanded");
const overlay = document.querySelector(".pdf-viewer-overlay");
const sidebarSectionExpandCollapsBtn = document.querySelector(
  ".side-bar-section-expand-collaps-btn"
);

const sidebarSectionContent = document.querySelector(
  ".side-bar-section-content"
);

const arrowChange = () => {
  if (
    sideBarExpandBtn.firstElementChild.classList.contains(
      "fa-arrow-alt-circle-right"
    )
  ) {
    sideBarExpandBtn.innerHTML = `<i class="fas fa-arrow-alt-circle-left"></i>`;
  } else {
    sideBarExpandBtn.innerHTML = `<i class="fas fa-arrow-alt-circle-right"></i>`;
  }
};

sideBarExpandBtn.addEventListener("click", () => {
  sideBarExpanded.classList.toggle("active");
  arrowChange();
  overlay.classList.toggle("active");
});

overlay.addEventListener("click", () => {
  overlay.classList.remove("active");
  arrowChange();

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
