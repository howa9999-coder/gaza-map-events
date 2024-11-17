const navigation = document.querySelector(".navigation");

document.querySelector(".toggle").ondblclick = function () {
  this.classList.toggle("active");
  navigation.classList.toggle("active");
};

$(function () {
  let isFixed = false; // Track if the navigation is fixed

  $(".navigation").draggable({
    stop: function (event, ui) {
      const position = $(this).position();
      if (position.top < 0 || position.left < 0) {
        $(this).css({
          top: "10%",
          right: "20px",
        });
      }
      // Update isFixed status based on the position of the navigation
      isFixed = ui.position.top <= 10; // Set isFixed if dragged near the top
    },
  });

  $(window).scroll(function () {
    const scrollTop = $(this).scrollTop();
    const navPosition = $(".navigation").position();

    // Check if the navigation should become fixed
    if (scrollTop > navPosition.top && !isFixed) {
      isFixed = true;
      $(".navigation").css({
        position: "fixed",
        top: "10px",
        left: navPosition.left,
      });
    }

    // Check if the navigation should go back to its original position
    if (scrollTop < navPosition.top && isFixed) {
      isFixed = false;
      $(".navigation").css({
        position: "absolute",
        top: navPosition.top,
        left: navPosition.left,
      });
    }
  });
});
