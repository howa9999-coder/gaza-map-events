// JavaScript to handle menu visibility
const menuToggle = document.getElementById("menu-toggle");
const menuContent = document.getElementById("menu-content");

$("body").css("padding-top", $("#navbar").height());

// Toggle menu visibility on click
menuToggle.addEventListener("click", () => {
  const isExpanded = menuToggle.getAttribute("aria-expanded") === "true";
  menuToggle.setAttribute("aria-expanded", !isExpanded);
  menuContent.classList.toggle("hidden");
});


// Information : read more & read less
// Get the "Read More" button and the extra content div
const toggleBtn = document.getElementById("toggleBtn");
const toggleText = document.getElementById("read-text");
const toggleIcon = document.getElementById("read-icon");
const extraContent = document.getElementById("extraContent");
if (toggleBtn) {
  // Add event listener to toggle content visibility
  toggleBtn.addEventListener("click", () => {
    // Toggle visibility of extra content
    extraContent.classList.toggle("hidden");

    // Change button text depending on the state of the content
    if (extraContent.classList.contains("hidden")) {
      toggleText.innerText = "Read More";
      toggleIcon.classList.add("fa-caret-down");
      toggleIcon.classList.remove("fa-caret-up");
    } else {
      toggleText.innerText = "Read Less";
      toggleIcon.classList.add("fa-caret-up");
      toggleIcon.classList.remove("fa-caret-down");
    }
  });
}
