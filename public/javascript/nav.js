const burgerMenu = document.querySelector(".burger-menu");
const crossLine = document.querySelectorAll(".cross-line");
const profileBtn = document.querySelectorAll(".user-profile-circle");
const dropdownMenu = document.querySelector(".profile-dropdown-menu");
const burgerMenuSlidePanel = document.querySelector(".burger-menu-slide-panel");
const slidePanelLinksContainer = document.querySelector(
  ".slide-panel-links-container"
);
const dropDownMenuItems = document.querySelector(
  ".slide-panel-links-container"
);

let isProfileMenuOpen = false;
let isBurgerMenuOpen = false;

/*==========================================================================*/

burgerMenu.addEventListener("click", () => {
  crossLine.forEach((cl) => {
    cl.classList.toggle("open");
  });
  burgerMenuSlidePanel.classList.toggle("active");
  // Array.from(dropDownMenuItems.children).forEach((i) => {
  //   i.classList.add("fade-in");
  // });
  isBurgerMenuOpen = burgerMenuSlidePanel.classList.contains("active")
    ? true
    : false;
});

/*==========================================================================*/

profileBtn.forEach((b) => {
  b.addEventListener("click", () => {
    if (isBurgerMenuOpen) {
      burgerMenuSlidePanel.classList.remove("active");
      crossLine.forEach((cl) => {
        cl.classList.remove("open");
      });
      isBurgerMenuOpen = false;
    }

    dropdownMenu.classList.toggle("active");
    isProfileMenuOpen = dropdownMenu.classList.contains("active")
      ? true
      : false;
  });
});

/*==========================================================================*/

window.addEventListener("resize", () => {
  let isLarge = window.innerWidth >= 768 ? true : false;
  if (isLarge && burgerMenuSlidePanel.classList.contains("active")) {
    burgerMenuSlidePanel.classList.remove("active");

    if (
      crossLine[0].classList.contains("open") &&
      crossLine[1].classList.contains("open") &&
      crossLine[2].classList.contains("open")
    ) {
      crossLine.forEach((cl) => {
        cl.classList.remove("open");
      });
    }
    isBurgerMenuOpen = false;
  }
});

/*=======================================================================*/

document.addEventListener("click", function (e) {
  if (
    !dropdownMenu.contains(e.target) &&
    !profileBtn[0].contains(e.target) &&
    !profileBtn[1].contains(e.target)
  ) {
    if (dropdownMenu.classList.contains("active")) {
      dropdownMenu.classList.remove("active");
      isProfileMenuOpen = false;
    }
  }
});
