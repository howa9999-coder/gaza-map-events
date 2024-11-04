//Associations Slide

let currentIndex = 0;
    
    function updateCarousel() {
            const carousel = document.getElementById('carousel');
            const totalItems = carousel.children.length;
            const itemWidth = carousel.children[0].clientWidth;
            const offset = -currentIndex * itemWidth;
            carousel.style.transform = `translateX(${offset}px)`;
    }
    
    function nextSlide() {
            const carousel = document.getElementById('carousel');
            const totalItems = carousel.children.length;
            currentIndex = (currentIndex + 1) % totalItems;
            updateCarousel();
    }
    
    function prevSlide() {
            const carousel = document.getElementById('carousel');
            const totalItems = carousel.children.length;
            currentIndex = (currentIndex - 1 + totalItems) % totalItems;
            updateCarousel();
    }
//fetch data
    fetch('../json/association.json')
    .then(response => response.json())
    .then(data => {
        console.log(data)
        data.forEach(item => {

        // Function to render articles
        function renderAssociations(associations) {
            //console.log(associations)
            document.querySelector('#carousel').innerHTML = ""; // Clear existing cards
            associations.forEach(association => {
                document.querySelector('#carousel').innerHTML += `<div class="flex-none w-full md:w-1/3 p-2">
                                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                                    <img src="${association.logo}" alt="${association.name}" class="w-full h-40 object-cover">
                                    <div class="p-4">
                                        <h3 class="font-semibold text-lg">${association.name}</h3>
                                        <p class="mt-2 text-gray-600">${association.description}</p>
                                        <a href="${association.website}" class="mt-4 inline-block text-blue-500 hover:underline">${association.website}</a>
                                    </div>
                                </div>
                            </div>`; 
            });


        }
                // Initial render
    renderAssociations(data);
    })

    }) 