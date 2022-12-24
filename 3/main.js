const 
  leftArrow = document.querySelector(".left-arrow"),
  rightArrow = document.querySelector(".right-arrow"),
  slider = document.querySelector(".slider"),
  slider1 = document.querySelector(".slider1"),
  slider2 = document.querySelector(".slider2");

leftArrow.style.display = 'none'

// инициализация нижнего скрола в самый правый угол
slider2.scrollTo({
  left: slider2.scrollWidth
});

function scrollRight() {
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

  leftArrow.style.display = 'inherit'
}

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

leftArrow.addEventListener("click", function (ev) {
  // if (ev.target === leftArrow) {
    scrollLeft();
  // }
});

slider.addEventListener("click", function (ev) {
	console.log (ev.target);
  if (ev.target === rightArrow) {
    scrollRight();
  }
});
