fetch("json/layer.json")
    .then((response) => response.json())
    .then((data) => {
        const uniqueCategories = new Set();

        data.forEach((item) => {
            if (item.category) {
                uniqueCategories.add(item.category);
            }
        });

        const categoriesArray = Array.from(uniqueCategories);
        document.querySelector("#categorySelect").innerHTML = `
            <option value="All">All</option>
            ${categoriesArray
                .map(
                    (category) =>
                        `<option value="${category}">${category}</option>`
                )
                .join("")}
        `;

        const cardsPerPage = 6; // Set the number of articles per page
        let currentPage = 1;
        let filteredData = data; // This will hold the current filtered data

        function renderArticles(articles) {
            document.querySelector("#card").innerHTML = ""; // Clear existing cards
            const start = (currentPage - 1) * cardsPerPage;
            const end = start + cardsPerPage;
            const currentArticles = articles.slice(start, end);

            currentArticles.forEach((article) => {
                document.querySelector("#card").innerHTML += `
                    <div class="bg-white shadow-lg rounded-lg p-4 relative">
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
            });

            // Attach event listeners to all read buttons
            document.querySelectorAll(".read-button").forEach((button) => {
                button.addEventListener("click", function () {
                    const title = this.getAttribute("data-title");
                    localStorage.setItem("title", title);
                    window.location.href = "../html/art.html";
                });
            });

            setupPagination(articles.length); // Setup pagination based on total articles
        }

        function setupPagination(totalArticles) {
            const paginationContainer = document.getElementById("pagination");
            paginationContainer.innerHTML = ""; // Clear existing pagination

            const pageCount = Math.ceil(totalArticles / cardsPerPage);

            for (let i = 1; i <= pageCount; i++) {
                const pageButton = document.createElement("button");
                pageButton.textContent = i;
                pageButton.className =
                    "mx-1 px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-200 transition"; // Tailwind styles
                pageButton.onclick = () => {
                    currentPage = i;
                    renderArticles(filteredData); // Render articles for the current page
                };
                paginationContainer.appendChild(pageButton);
            }
        }

        // Initial render
        renderArticles(data);

        // Search function
        document
            .querySelector("#search")
            .addEventListener("input", function () {
                let searchValue = this.value.toLowerCase();
                filteredData = data.filter((i) =>
                    i.title.toLowerCase().includes(searchValue)
                ); // Adjusted to search by title
                currentPage = 1; // Reset to first page on search
                renderArticles(filteredData);
            });

        // Filter by category
        document
            .querySelector("#categorySelect")
            .addEventListener("change", function () {
                let selectedValue = this.value;
                filteredData = data.filter(
                    (article) =>
                        selectedValue === "All" ||
                        selectedValue === article.category
                );
                currentPage = 1; // Reset to first page on filter
                renderArticles(filteredData);
            });

        // Sort articles
        document
            .getElementById("articleSort")
            .addEventListener("change", function () {
                const selectedValue = this.value;
                let sortedData;
                if (selectedValue === "latest") {
                    sortedData = [...filteredData].sort(
                        (a, b) => new Date(b.date) - new Date(a.date)
                    );
                } else if (selectedValue === "oldest") {
                    sortedData = [...filteredData].sort(
                        (a, b) => new Date(a.date) - new Date(b.date)
                    );
                } else {
                    sortedData = filteredData;
                }
                filteredData = sortedData;
                currentPage = 1; // Reset to first page on sort
                renderArticles(filteredData);
            });
    })
    .catch((error) => console.error("Error fetching the data:", error));
