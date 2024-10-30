//Slider
const slider = document.querySelector('.slider');
const slides = document.querySelector('.slides');
const images = document.querySelectorAll('.slides img');
const prevBtn = document.querySelector('.prevBtn');
const nextBtn = document.querySelector('.nextBtn');
const dotsContainer = document.querySelector('.dots-container');

let counter = 0;
const slideWidth = images[0].clientWidth;

slides.style.transform = `translateX(${-slideWidth * counter}px)`;

function nextSlide() {
  if (counter >= images.length - 1) {
    counter = 0;
  } else {
    counter++;
  }
  updateSlider();
}

function prevSlide() {
  if (counter <= 0) {
    counter = images.length - 1;
  } else {
    counter--;
  }
  updateSlider();
}

function goToSlide(index) {
  counter = index;
  updateSlider();
}

function updateSlider() {
  slides.style.transition = "transform 0.5s ease-in-out";
  slides.style.transform = `translateX(${-slideWidth * counter}px)`;
  updateDots();
}

function updateDots() {
  const dots = document.querySelectorAll('.dot');
  dots.forEach((dot, index) => {
    if (index === counter) {
      dot.classList.add('active');
    } else {
      dot.classList.remove('active');
    }
  });
}

nextBtn.addEventListener('click', nextSlide);
prevBtn.addEventListener('click', prevSlide);

// Crear los puntos indicadores
images.forEach((_, index) => {
  const dot = document.createElement('div');
  dot.classList.add('dot');
  dotsContainer.appendChild(dot);

  dot.addEventListener('click', () => {
    goToSlide(index);
  });
});

// Actualizar los puntos indicadores al cambiar automáticamente
function autoSlide() {
  nextSlide();
  updateDots();
}

let slideInterval = setInterval(autoSlide, 3000);

slider.addEventListener('mouseenter', () => {
  clearInterval(slideInterval);
});

slider.addEventListener('mouseleave', () => {
  slideInterval = setInterval(autoSlide, 3000);
});