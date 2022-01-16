var collectionId = document.getElementById("collection_id").value;
const deleteBtns = document.querySelectorAll(".delete-content");
const collectionDeleteBtn = document.getElementById("delete-collection");

window.addEventListener("load", (event) => {
  //   console.log(collectionId);
});

const removeContentFromCollection = ({ currentTarget }) => {
  var contentId = currentTarget.value;
  if (confirm("Are you sure?")) {
    const removeContentReq = new XMLHttpRequest();

    var url = "/ajax/remove-content-from-user-collection";
    // console.log(JSON.stringify(params));
    removeContentReq.open("POST", url, true);
    removeContentReq.setRequestHeader("Content-Type", "application/json");
    removeContentReq.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        if (this.responseText) {
          var response = JSON.parse(this.responseText);
          //   console.log(response);
          var message = response.message;
          if (response.action == "error") {
            alert(message);
          }
          window.location.reload();
        }
      }
    };
    removeContentReq.send(
      JSON.stringify({
        user_collection_id: collectionId,
        content_id: contentId,
      })
    );
  }
};

const removeUserCollection = ({ currentTarget }) => {
  if (confirm("Are you sure?")) {
    const removeCollectiontReq = new XMLHttpRequest();

    var url = "/ajax/remove-user-collection";
    let params = [];
    params = `user_collection_id=${collectionId}`;
    removeCollectiontReq.open("POST", url);
    removeCollectiontReq.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        // console.log(this.responseText);
        window.location.href = "/profile";
      }
    };
    removeCollectiontReq.setRequestHeader(
      "Content-type",
      "application/x-www-form-urlencoded"
    );
    removeCollectiontReq.send(params);
  }
};

if (deleteBtns && collectionId) {
  for (const btn of deleteBtns) {
    btn.addEventListener("click", removeContentFromCollection, false);
  }
}

collectionDeleteBtn.addEventListener("click", removeUserCollection, false);
