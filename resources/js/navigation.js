const toggleElement = document.querySelector(".toggle");
const navigation = document.querySelector(".navigation");

function toggleClass() {
  toggleElement.classList.toggle("active");
  navigation.classList.toggle("active");
}

toggleElement.addEventListener("click", function () {
  this.classList.toggle("active");
  navigation.classList.toggle("active");
});

let lastTouchTime = 0;
toggleElement.addEventListener("touchstart", function (e) {
  const currentTime = new Date().getTime();

  // Check if the touch event is occurring within 300ms of the last one (simulating double-tap)
  if (currentTime - lastTouchTime < 300) {
    toggleClass();
  }
  lastTouchTime = currentTime;
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
