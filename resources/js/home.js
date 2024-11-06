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

document.getElementById("onToggleMenu").addEventListener("click", function () {
    return onToggleMenu(this);
});

//About Us
function aboutUs() {
    const container = document.querySelector("#home-about");

    if (container.innerHTML.includes("Remembering, Reflecting, Rising")) {
        container.innerHTML = `
                <h1 class="text-black text-5xl mb-6 md:text-6xl font-bold text-center">
                    Gaza Events
                </h1>
                <p class="text-white  container text-center">
                Gaza Events is a dedicated platform that focuses on sharing and promoting events related to the ongoing conflict in Gaza. Our mission is to provide a space for voices from the community to be heard, highlighting the stories, struggles, and resilience of those affected. By organizing various events, discussions, and workshops, we aim to raise awareness about the humanitarian challenges faced by the people of Gaza and foster a sense of solidarity among residents and allies. Through these efforts, Gaza Events seeks to inform, engage, and inspire individuals to support peace and understanding in the region.
                </p>
            `;
        document.querySelector("#about-btn").innerHTML = "Gaza Events";
    } else {
        container.innerHTML = `
                <h1 class="text-black text-5xl mb-6 md:text-6xl font-bold text-center">
                    Gaza Events
                </h1>
                <p class="text-white text-xl font-medium text-center">
                    "Remembering, Reflecting, Rising"
                </p>
            `;
        document.querySelector("#about-btn").innerHTML = "About Gaza Events";
    }
}
document.getElementById("about-btn").addEventListener("click", aboutUs);

// Leaflet Map
const map = L.map("map").setView([31.5, 34.47], 12); // Center on Gaza Strip

// Google sat
L.tileLayer("https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}", {
    maxZoom: 20,
    attribution:
        'Map data &copy; <a href="https://www.google.com/intl/en_us/help/terms_maps.html">Google</a>',
    subdomains: ["mt0", "mt1", "mt2", "mt3"],
}).addTo(map);

// Gaza Location
L.marker([31.5, 34.47])
    .addTo(map) // Replace with specific coordinates if needed
    .bindPopup("Gaza Strip Center")
    .openPopup();

//Associations Slide

let currentIndex = 0;

function updateCarousel() {
    const carousel = document.getElementById("carousel");
    const totalItems = carousel.children.length;
    const itemWidth = carousel.children[0].clientWidth;
    const offset = -currentIndex * itemWidth;
    carousel.style.transform = `translateX(${offset}px)`;
}

function nextSlide() {
    const carousel = document.getElementById("carousel");
    const totalItems = carousel.children.length;
    currentIndex = (currentIndex + 1) % totalItems;
    updateCarousel();
}

document.getElementById("nextSlide").addEventListener("click", nextSlide);

function prevSlide() {
    const carousel = document.getElementById("carousel");
    const totalItems = carousel.children.length;
    currentIndex = (currentIndex - 1 + totalItems) % totalItems;
    updateCarousel();
}

document.getElementById("prevSlide").addEventListener("click", prevSlide);
