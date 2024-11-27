const navigation = document.getElementById("navigation");

navigation.querySelector(".toggle").addEventListener("click", function () {
  this.classList.toggle("active");
  navigation.classList.toggle("active");
});

$(function () {
  let position;
  const screen = document.body.getBoundingClientRect();

  if (localStorage.getItem("draggableBuycut")) {
    position = JSON.parse(localStorage.getItem("draggableBuycut"));
  }

  if (
    position.top < 0 ||
    position.left < 0 ||
    screen.width < position.left ||
    screen.height < position.top
  ) {
    position.top = "10%";
    position.left = "20px";
  }

  $("#navigation").css({
    top: position?.top ?? "10%",
    left: position?.left ?? "20px",
  });
  console.log(position);
  $("#navigation").draggable({
    stop: function (event, ui) {
      const screen = document.body.getBoundingClientRect();
      const position = $(this).position();

      if (
        position.top < 0 ||
        position.left < 0 ||
        screen.width < position.left ||
        screen.height < position.top
      ) {
        position.top = "10%";
        position.left = "20px";
      }
      $(this).css({
        top: position.top,
        left: position.left,
      });
      localStorage.setItem("draggableBuycut", JSON.stringify(position));
    },
  });
});
