//Nav
const navLinks = document.querySelector(".nav-links");
function onToggleMenu(e) {
  if (e.name === "menu") {
    e.name = "close";
  } else {
    e.name = "menu";
  }
  navLinks.classList.toggle("top-[95%]");
}

//Latest Articles
fetch("../json/layer.json")
  .then((response) => response.json())
  .then((data) => {
    // Limit to the first 3 articles
    const firstThreeArticles = data.slice(0, 3);

    // Clear the existing content
    document.querySelector("#latestArticles").innerHTML = "";

    // Loop through the first 3 articles and display them

    firstThreeArticles.forEach((article) => {
      const articleElement = `
                <div class="bg-white shadow-lg rounded-lg p-4 relative hover:shadow-2xl hover:scale-105 transition-all duration-300 ease-in-out">
                 <img src="${article.image}" alt="${article.title}" class="w-full object-cover rounded-lg max-h-48 mb-4">
                    <h2 class="text-xl font-semibold">${article.title}</h2>
                    <p class="text-gray-700 mt-2">${article.description}</p>
                    <div class="mt-4 text-sm text-gray-500">
                        <p>Author: ${article.author}</p>
                        <p>Date: ${article.date}</p>
                        <p>Category: ${article.category}</p>
                    </div>
                    <button class="read-button absolute bottom-4 right-4 text-blue-500 cursor-pointer p-0 bg-transparent border-none" data-title="${article.title}">
                        Read
                    </button>
                </div>`;

      // Append the article to the grid container
      document.querySelector("#latestArticles").innerHTML += articleElement;
    });
    // Attach event listeners to all read buttons
    document.querySelectorAll(".read-button").forEach((button) => {
      button.addEventListener("click", function () {
        const title = this.getAttribute("data-title");
        localStorage.setItem("title", title);
        window.location.href = "../html/art.html";
      });
    });
  })
  .catch((error) => console.error("Error loading the articles:", error));
//slide map
