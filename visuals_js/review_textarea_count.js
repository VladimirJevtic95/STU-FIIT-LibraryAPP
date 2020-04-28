$(document).ready(function () {
  $(".char-textarea").on("keyup", function (event) {
    checkTextAreaMaxLength(this, event);
  });

  function checkTextAreaMaxLength(textBox, e) {

    $(".char-count").html(textBox.value.length);

    return true;
  }
  
  function checkSpecialKeys(e) {
    if (
      e.keyCode != 8 &&
      e.keyCode != 46 &&
      e.keyCode != 37 &&
      e.keyCode != 38 &&
      e.keyCode != 39 &&
      e.keyCode != 40
    )
      return false;
    else return true;
  }
});
