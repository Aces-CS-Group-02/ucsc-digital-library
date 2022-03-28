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
var bookmarkBtns = document.getElementsByClassName("add-bookmark-btn");
var notesBtns = document.getElementsByClassName("add-notes-btn");
var noteModal = document.getElementById("notesModal");
var noteSpan = document.getElementsByClassName("close-note")[0];
var noteSave = document.getElementById("notes-modal-form");
var noteData = document.getElementById("note-data");
var shareBtns = document.getElementsByClassName("share-btn");
var shareModal = document.getElementById("shareModal");
var shareSpan = document.getElementsByClassName("close-share")[0];
var citationBtns = document.getElementsByClassName("get-citation-btn");
var citationModal = document.getElementById("citationsModal");
var citationSpan = document.getElementsByClassName("close-citation")[0];
var citationSelect = document.getElementById("select-citation");
var deleteNoteBtn = document.getElementById("delete-note-btn");

var collectionBtns = document.getElementsByClassName("add-to-collection-btn");
var collectionModal = document.getElementById("collectionsModal");
var collectionSpan = document.getElementsByClassName("close-collection")[0];
var addCollectionBtn = document.getElementById("add-collection");
// const collectionCheckboxes = document.querySelectorAll('input[type="checkbox"]');
sideBarExpandBtn.addEventListener("click", (e) => {
  sideBarExpanded.classList.toggle("active");
  // arrowChange();
  overlay.classList.toggle("active");
  getBookmarks();
});

// sideBarExpandBtn.addEventListener("click", getBookmarks, false);

overlay.addEventListener("click", () => {
  overlay.classList.remove("active");
  // arrowChange();

  sideBarExpanded.classList.toggle("active");
});

if (sidebarSectionExpandCollapsBtn) {
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
}

// When the user clicks on <span> (x), close the notes-modal
noteSpan.onclick = function () {
  noteModal.style.display = "none";
};

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
  if (
    event.target == noteModal ||
    event.target == collectionModal ||
    event.target == citationModal ||
    event.target == shareModal
  ) {
    // console.log("modal clicked");
    collectionModal.style.display = "none";
    var messageContainer = document.getElementById("message-container");
    messageContainer.style.display = "none";
    noteModal.style.display = "none";
    citationModal.style.display = "none";
    shareModal.style.display = "none";
  }
};

var shareLinkContainer = document.querySelector(".share-link-container");
var shareLinkCopyBtn = document.getElementById("copy-share-link");

const selection = window.getSelection();
const range = document.createRange();
// const textToCopy = document.getElementById("textToCopy")

// shareLinkCopyBtn.addEventListener('click', function(e) {
//     range.selectNodeContents(shareLinkContainer);
//     selection.removeAllRanges();
//     selection.addRange(range);
//     const successful = document.execCommand('copy');
//     if(successful){
//       console.log('Copied!');
//     } else {
//       console.log('Unable to copy!');
//     }
//     window.getSelection().removeAllRanges()
// });
var linkCopyMsg = document.querySelector(".link-copy-msg");

function copyShareLink() {
  shareLinkContainer.select();
  shareLinkContainer.setSelectionRange(0, 99999); /* For mobile devices */

  /* Copy the text inside the text field */
  navigator.clipboard.writeText(shareLinkContainer.value);
  linkCopyMsg.classList.add("add-animation");
  setTimeout(function () {
    linkCopyMsg.classList.remove("add-animation");
  }, 1500);
}

const getShareLink = () => {
  const getSLinkReq = new XMLHttpRequest();
  var url = "/ajax/get-content-share-link";
  getSLinkReq.open("POST", url);
  getSLinkReq.onreadystatechange = function () {
    // console.log(this.responseText);
    if (this.readyState == 4 && this.status == 200) {
      shareModal.style.display = "flex";
      shareLinkContainer.innerText = this.responseText;
    }
  };
  getSLinkReq.send(JSON.stringify({ content_id: contentId }));
};

for (var btn of shareBtns) {
  btn.addEventListener("click", getShareLink, false);
}

shareSpan.onclick = function () {
  shareModal.style.display = "none";
};

var citationTextArea = document.getElementById("citation-data");
var citationCopyBtn = document.getElementById("copy-citation");
var citationCopyMsg = document.querySelector(".copy-msg");

const getCitations = (type) => {
  // currentTarget.preventDefault();
  const getCitationReq = new XMLHttpRequest();
  var url = "/ajax/get-citation";
  getCitationReq.open("POST", url);
  getCitationReq.onreadystatechange = function () {
    // console.log(this.responseText);
    if (this.readyState == 4 && this.status == 200) {
      citationTextArea.innerText = this.responseText;
      citationCopyBtn.style.display = "flex";
      citationCopyBtn.addEventListener("click", (e) => {
        citationCopyMsg.classList.add("add-animation");
        setTimeout(function () {
          citationCopyMsg.classList.remove("add-animation");
        }, 1500);
      });
    }
  };
  getCitationReq.send(
    JSON.stringify({ content_id: contentId, citation_type: type })
  );
};

var citationForm = document.getElementById("citation-select-form");

citationSelect.addEventListener("change", (e) => {
  // console.log(e.target);
  if (e.target.value != 0) {
    getCitations(e.target.value);
  }
});

for (var btn of citationBtns) {
  btn.addEventListener("click", () => {
    citationModal.style.display = "flex";
  });
}

citationSpan.onclick = function () {
  citationModal.style.display = "none";
};

function copyCitation() {
  citationTextArea.select();
  citationTextArea.setSelectionRange(0, 99999); /* For mobile devices */

  /* Copy the text inside the text field */
  navigator.clipboard.writeText(citationTextArea.value);
}

const deleteNote = () => {
  if (confirm("Are you sure?")) {
    const deleteNoteReq = new XMLHttpRequest();
    var url = "/ajax/delete-user-notes";
    deleteNoteReq.open("POST", url);
    deleteNoteReq.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        noteModal.style.display = "none";
        deleteNoteBtn.style.display = "none";
        alert(this.responseText);
      }
    };
    deleteNoteReq.send(JSON.stringify({ content_id: contentId }));
  }
};

deleteNoteBtn.addEventListener("click", deleteNote, false);

const saveNote = (currentTarget) => {
  currentTarget.preventDefault();
  for (instance in CKEDITOR.instances) {
    CKEDITOR.instances[instance].updateElement();
  }
  var formData = new FormData(currentTarget.target);
  var path = currentTarget.target.getAttribute("action");
  // console.log(formData);
  // console.log(path);

  const saveNoteReq = new XMLHttpRequest();
  saveNoteReq.open("POST", path);
  saveNoteReq.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      noteModal.style.display = "none";
      // console.log(this.responseText);
    }
  };
  saveNoteReq.send(formData);
};
// console.log(contentId);
// console.log(noteData);
noteSave.addEventListener("submit", saveNote, false);

const getNoteData = () => {
  const getNoteReq = new XMLHttpRequest();
  let params = [];
  params = `content_id=${contentId}`;
  var url = "/ajax/get-user-notes";
  getNoteReq.open("GET", url + "?" + params);
  // console.log(params);
  getNoteReq.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      // console.log(this.responseText);
      if (this.responseText) deleteNoteBtn.style.display = "flex";
      else deleteNoteBtn.style.display = "none";

      var editor = CKEDITOR.instances["note-data"];
      editor.setData(this.responseText);
    }
  };
  getNoteReq.send();
  noteModal.style.display = "flex";
};

for (var btn of notesBtns) {
  btn.addEventListener("click", getNoteData, false);
}

const addBookmark = (currentTarget) => {
  const addBookmarkReq = new XMLHttpRequest();
  // let params = [];
  // params = `content_id=${contentId}&reg_no=${regNo}`;
  pageNo = document.querySelector("#page-num").textContent;
  var url = "/ajax/user-bookmarks";
  addBookmarkReq.open("POST", url);
  addBookmarkReq.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      // console.log(this.responseText);
      alert(this.responseText);
      getBookmarks();
    }
  };
  addBookmarkReq.send(
    JSON.stringify({ content_id: contentId, page_no: pageNo })
  );
};

const getBookmarks = () => {
  // AJAX request
  const bookmarkReq = new XMLHttpRequest();
  // let params = [];
  // params = `reg_no=${id}`;
  var url = "/ajax/get-user-bookmarks";
  // var url = "/ajax/get-user-collections" + "&rand=" + new Date().getTime();
  // var randNo = parseInt(Math.random()*99999999);
  bookmarkReq.open("POST", url);
  bookmarkReq.onreadystatechange = getBookmarkData;
  // collectionReq.send(params);
  bookmarkReq.send(JSON.stringify({ content_id: contentId }));
};

const deleteBookmark = ({ currentTarget }) => {
  // console.log(currentTarget.value);
  // console.log(currentTarget.dataset.bookmarkId);
  // var contentId = currentTarget.value;
  var pageNo = currentTarget.dataset.bookmarkId;

  const deleteBookmarkReq = new XMLHttpRequest();
  var url = "/ajax/delete-user-bookmarks";
  deleteBookmarkReq.open("POST", url);
  deleteBookmarkReq.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      alert(this.responseText);
      getBookmarks();
    }
  };
  deleteBookmarkReq.send(
    JSON.stringify({ content_id: contentId, page_no: pageNo })
  );
};

function getBookmarkData() {
  var parentDiv = document.getElementById("side-bar-section-content"); //from here

  if (this.readyState == 4) {
    if (this.status == 200) {
      // console.log("got the data");
      parentDiv.innerHTML = "";
      var bookmarks = JSON.parse(this.responseText);
      // console.log(this.responseText);
      if (bookmarks.length <= 3) {
        document.querySelector(
          ".side-bar-section-expand-collaps-btn"
        ).style.display = "none";
        document
          .querySelector(".side-bar-section-content")
          .classList.add("toggle-view");
      } else {
        document.querySelector(
          ".side-bar-section-expand-collaps-btn"
        ).style.display = "";
      }
      for (var bookmark of bookmarks) {
        var div = document.createElement("div");
        div.classList.add("bookmark-card");
        // div.setAttribute("id", bookmark.page);
        div.dataset.id = bookmark.page;
        div.innerHTML =
          "<p class='bookmark-header-title'>Page: " + bookmark.page + "</p>";
        var dltBtn = document.createElement("button");
        dltBtn.classList.add("bookmark-delete-btn");
        dltBtn.innerHTML =
          '<i class="bookmark-dlt-icon fas fa-trash" id="delete-content">';
        dltBtn.value = contentId;
        dltBtn.dataset.bookmarkId = bookmark.page;
        div.appendChild(dltBtn);
        parentDiv.appendChild(div);
        dltBtn.addEventListener("click", (e) => {
          // console.log(e.target.dataset.bookmarkId);
          // console.log(e.target.value);
          deleteBookmark(e);
        });
        div.addEventListener("click", (e) => {
          // alert();
          // console.log("😊" + e.target);
          var canvas = document.querySelector(".pdfCanvas");
          var pageHeight = canvas.height;
          // console.log(pageHeight);
          var scrollHeight = pageHeight * (e.target.dataset.id-0.9);
          // console.log(scrollHeight);
          var scrollDiv = document.querySelector("#scroll-div");
          scrollDiv.scrollTop = scrollHeight;
        });
      }
    }
  }
}

for (var btn of bookmarkBtns) {
  btn.addEventListener("click", addBookmark, false);
}

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

function getCollectionContent(collectionId) {
  const collectionContentReq = new XMLHttpRequest();

  let params = [];
  params = `user_collection_id=${collectionId}&content_id=${contentId}`;
  // params2 = `content_id=${contentId}`;
  var url = "/ajax/get-user-collection-content";
  // console.log(params);
  collectionContentReq.open("GET", url + "?" + params);
  collectionContentReq.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if (this.responseText) {
        // console.log(this.responseText);
        var checkId = document.getElementById("checkbox_" + collectionId);
        // console.log(checkId);
        checkId.checked = true;
      } else {
        var checkId = document.getElementById("checkbox_" + collectionId);
        checkId.checked = false;
      }
    }
  };
  collectionContentReq.send();
}

function addContentToCollection(collectionId) {
  const addContentReq = new XMLHttpRequest();

  // let params = [];
  // params = `user_collection_id=${collectionId}&content_id=${contentId}`;
  // params2 = `content_id=${contentId}`;
  var url = "/ajax/add-content-to-user-collection";
  // console.log(params);
  addContentReq.open("POST", url);
  addContentReq.setRequestHeader("Content-type", "application/json");
  addContentReq.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if (this.responseText) {
        var response = JSON.parse(this.responseText);
        // console.log(this.responseText);
        var messageContainer = document.getElementById("message-container");
        messageContainer.innerText = response.message;
        messageContainer.style.display = "flex";
        if (response.action == "added") {
          messageContainer.classList.remove("add-orange", "add-red");
          messageContainer.classList.add("add-green");
        } else if (response.action == "error") {
          messageContainer.classList.remove("add-orange", "add-green");
          messageContainer.classList.add("add-red");
        }
      }
    }
  };
  addContentReq.send(
    JSON.stringify({ user_collection_id: collectionId, content_id: contentId })
  );
}

function removeContentFromCollection(collectionId) {
  const removeContentReq = new XMLHttpRequest();

  // let params = [];
  // params = `user_collection_id=${collectionId}&content_id=${contentId}`;
  // let params = ;
  // params2 = `content_id=${contentId}`;
  var url = "/ajax/remove-content-from-user-collection";
  // console.log(JSON.stringify(params));
  removeContentReq.open("POST", url, true);
  removeContentReq.setRequestHeader("Content-Type", "application/json");
  removeContentReq.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      // console.log(this.responseText);
      if (this.responseText) {
        var response = JSON.parse(this.responseText);
        // console.log(response);
        var messageContainer = document.getElementById("message-container");
        messageContainer.innerText = response.message;
        messageContainer.style.display = "flex";
        if (response.action == "removed") {
          messageContainer.classList.remove("add-green", "add-red");
          messageContainer.classList.add("add-orange");
        } else if (response.action == "error") {
          messageContainer.classList.remove("add-orange", "add-green");
          messageContainer.classList.add("add-red");
        }
      }
    }
  };
  removeContentReq.send(
    JSON.stringify({ user_collection_id: collectionId, content_id: contentId })
  );
}

function getCollectionData() {
  var parentDiv = document.getElementById("collection-modal-collections");

  if (this.readyState == 4) {
    if (this.status == 200) {
      // console.log("got the data");
      // var messageContainer = document.getElementById("message-container");
      // messageContainer.style.display = "none";
      document.getElementById("name").value = "";
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
        checkbx.id = "checkbox_" + collection["user_collection_id"];
        checkbx.name = collection["user_collection_id"];
        checkbx.addEventListener("click", (e) => {
          // console.log(e.target.checked);
          if (e.target.checked) {
            // console.log(e.target);
            addContentToCollection(e.target.name);
          } else {
            removeContentFromCollection(e.target.name);
          }
        });
        getCollectionContent(collection["user_collection_id"]);
        div2.appendChild(checkbx);
        var collectionName = document.createTextNode(collection["name"]);
        div2.appendChild(collectionName);
      }

      // alert("The server said:" + this.responseText);
    }
  }
}

const createCollection = ({ currentTarget }) => {
  // currentTarget.preventDefault();
  const newCollectionReq = new XMLHttpRequest();
  var url = "/ajax/create-and-add-to-collection";
  var collection_name = document.getElementById("name").value;
  // console.log(collection_name);
  newCollectionReq.open("POST", url);
  newCollectionReq.setRequestHeader("Content-type", "application/json");
  newCollectionReq.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if (this.responseText) {
        var response = JSON.parse(this.responseText);
        // console.log(this.responseText);
        // getCollections;
        var messageContainer = document.getElementById("message-container");
        messageContainer.innerText = response.message;
        messageContainer.style.display = "flex";
        if (response.action == "added") {
          messageContainer.classList.remove("add-orange", "add-red");
          messageContainer.classList.add("add-green");
        } else if (response.action == "error") {
          messageContainer.classList.remove("add-orange", "add-green");
          messageContainer.classList.add("add-red");
        }
        // getCollectionData();
        // getCollections;
        // getCollectionData;
      }
    }
  };
  newCollectionReq.send(
    JSON.stringify({
      name: collection_name,
      content_id: contentId,
      reg_no: regNo,
    })
  );
};

for (var btn of collectionBtns) {
  btn.addEventListener("click", getCollections, false);
}

addCollectionBtn.addEventListener("click", createCollection, false);
addCollectionBtn.addEventListener("click", getCollections, false);

// When the user clicks on <span> (x), close the collections-modal
collectionSpan.onclick = function () {
  collectionModal.style.display = "none";
  var messageContainer = document.getElementById("message-container");
  messageContainer.style.display = "none";
};

// console.log(collectionCheckboxes);

// for (var i = 0; i < collectionCheckboxes.length; i++) {
//   collectionCheckboxes[i].addEventListener("click", addOrRemove);
// }

// function addOrRemove(e) {
//   console.log(e.target);
//   if (e.target.checked) {
//     console.log("Checkbox is checked..");
//   }
// }
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

// document.querySelector(".create-collection").addEventListener("focus", () => {
//   var buttonDisplay = document.getElementById("save-btn-container");
//   var toHide = document.getElementById("create-and-save");
//   const checkboxes = document.querySelectorAll('input[type="checkbox"]');
//   for (let checkbox of checkboxes) {
//     if (checkbox.checked) {
//       checkbox.checked = false;
//       buttonDisplay.classList.remove("display-save-btn");
//       toHide.classList.remove("hide-create-and-save-btn");
//     }
//   }
// });

// Content container from here

// var contentName = "<?php echo $url ?>";
// console.log(contentUrl);

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

    //Creating a canvas for each page to draw it on
    var canvas = document.createElement("canvas");
    canvas.id = num;
    canvas.className = "pdfCanvas";
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
      console.log(pdfDoc);

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

// console.log(bookmarkCard);
// if(bookmarkCard){
//   bookmarkCard.addEventListener("click", (e) => {
//     alert();
//     console.log(e.target.id);
//     // document.querySelector("#page-num").textContent = e.target.id;
//   })
// }
