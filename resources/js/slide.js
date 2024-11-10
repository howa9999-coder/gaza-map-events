//Associations Slide
let currentIndex = 0;

function updateCarousel(carouselBody) {
    const itemWidth = carouselBody.children[0].clientWidth;
    const offset = -currentIndex * itemWidth;
    carouselBody.style.transform = `translateX(${offset}px)`;
}

function nextSlide(carousel) {
    const carouselBody = carousel.querySelector(".carousel-body");
    const totalItems = carouselBody.children.length;
    currentIndex = (currentIndex + 1) % totalItems;
    updateCarousel(carouselBody);
}

function prevSlide(carousel) {
    const carouselBody = carousel.querySelector(".carousel-body");
    const totalItems = carouselBody.children.length;
    currentIndex = (currentIndex - 1 + totalItems) % totalItems;
    updateCarousel(carouselBody);
}

document.querySelectorAll(".carousel").forEach((carousel) => {
    carousel.querySelectorAll(".nextSlide").forEach((item) => {
        item.addEventListener("click", () => nextSlide(carousel));
    });

    carousel.querySelectorAll(".prevSlide").forEach((item) => {
        item.addEventListener("click", () => prevSlide(carousel));
    });
});
