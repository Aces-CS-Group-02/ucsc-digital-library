const flashMessage = document.getElementById("flash-msg-alert");
const flashMessageAlertDeteteBtn = document.getElementById("flash-msg-remove");

if (flashMessageAlertDeteteBtn) {
  flashMessageAlertDeteteBtn.onclick = function () {
    flashMessage.remove();
  };
}
