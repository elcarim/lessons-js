"use strict";
const leftArrow = document.querySelector(".left-arrow"),
  rightArrow = document.querySelector(".right-arrow"),
  slider = document.querySelector(".slider"),
  slider1 = document.querySelector(".slider1"),
  slider2 = document.querySelector(".slider2");

  leftArrow.style.display = 'none'

slider2.scrollTo({
  left: slider2.scrollWidth
});
/**
 * @brief Scroll to the right
 */
function scrollRight() {
    
  if (slider1.scrollWidth - slider1.clientWidth === slider1.scrollLeft) {
    // slider1.scrollTo({
    //   left: 0,
    //   behavior: "smooth"
    // });
    // slider2.scrollTo({
    //   left: slider2.scrollWidth,
    //   behavior: "smooth"
    // });
    rightArrow.style.display = 'none'
  } else {
    slider1.scrollBy({
      left: window.innerWidth,
      behavior: "smooth"
    });
    slider2.scrollBy({
      left: -window.innerWidth,
      behavior: "smooth"
    });

    if (slider1.scrollWidth - slider1.clientWidth*2 === slider1.scrollLeft) {
        rightArrow.style.display = 'none'

    }
  }
  leftArrow.style.display = 'inherit'
}

/**
 * @brief Scroll to the left
 */
function scrollLeft() {
    rightArrow.style.display = 'inherit'

  slider1.scrollBy({
    left: -window.innerWidth,
    behavior: "smooth"
  });
  slider2.scrollBy({ 
    left: window.innerWidth,
    behavior: "smooth"
  });

//   console.log (slider2.scrollWidth, slider2.clientWidth, slider2.scrollLeft)
  if (slider2.scrollWidth - slider2.clientWidth*2 === slider2.scrollLeft) {
    leftArrow.style.display = 'none'

  }  
}

// Auto slider
// let timerId = setInterval(scrollRight, 2000);

/**
 * @brief Reset timer for scrolling right
 */
// function resetTimer() {
//   clearInterval(timerId);
//   timerId = setInterval(scrollRight, 2000);
// }

// Scroll Events
slider.addEventListener("click", function (ev) {
  if (ev.target === leftArrow) {
    scrollLeft();
    // resetTimer();
  }
});

slider.addEventListener("click", function (ev) {
  if (ev.target === rightArrow) {
    scrollRight();
    // resetTimer();
  }
});
