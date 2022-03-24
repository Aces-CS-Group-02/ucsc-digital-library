const browseLink = document.querySelector("#browse-main-link");
const browseDropDown = document.querySelector(".browse-drop-down");
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

  if (
    !notificationPanel.contains(e.target) &&
    !notificationBtn.contains(e.target)
  ) {
    if (notificationPanel.style.display == "block") {
      console.log(notificationPanel.style.display);
      notificationPanel.style.display = "none";
    }
  }
});

const notificationPanel = document.getElementById("notifications-panel");
const notificationBtn = document.getElementById("notification-nav-link");

notificationBtn.addEventListener("click", () => {
  if (notificationPanel.style.display == "block") {
    console.log(notificationPanel.style.display);
    notificationPanel.style.display = "none";
  } else {
    notificationPanel.style.display = "block";
  }

  const req = new XMLHttpRequest();
  req.open("GET", "/ajax/open-notifications");
  // req.onreadystatechange = () => {
  //   if (this.readyState == 4 && this.status == 200) {
  //     if (this.responseText === "success") {
  //       document.querySelector(".notifications-count-label").style.display =
  //         "none";
  //     }
  //   }
  // };
  req.onload = () => {
    if (req.status == 200) {
      console.log(req.responseText);
      if (req.responseText === "viewed") {
        document.querySelector(".notifications-count-label").style.display =
          "none";
      }
    }
  };
  req.setRequestHeader("Content-Type", "application/json");
  req.send();
});

browseLink.addEventListener("click", () => {
  browseDropDown.classList.toggle("active");
});
