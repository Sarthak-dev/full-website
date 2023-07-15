$(document).ready(function() {
  $(".heart").click(function() {
    var heartIcon = $(this);
    var postId = heartIcon.data("post-id");
    var likeCountElement = heartIcon.siblings(".like-count");
    var popUpMessageContainer = heartIcon.closest(".like-btn").find(".pop-up-message-container");

    var isLiked = heartIcon.hasClass("clicked");

    if (isLiked) {
      // Display pop-up message for already liked post
      popUpMessageContainer.addClass("visible");

      // Hide the pop-up message after 3 seconds
      setTimeout(function() {
        popUpMessageContainer.removeClass("visible");
      }, 3000);

      return false;
    }

    $.ajax({
      type: "POST",
      url: "like.php",
      data: { postId: postId },
      dataType: "json",
      success: function(response) {
        if (response && response.success) {
          likeCountElement.text(response.likes);
          heartIcon.toggleClass("clicked");
        } else {
          console.log("An error occurred. Please try again later.");
        }
      },
      error: function(xhr, status, error) {
        console.log(xhr.responseText);
        console.log("An error occurred. Please try again later.");
      }
    });

    return false;
  });
});
