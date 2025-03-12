let last_known_scroll_position = 0;
let ticking = false;
let pegang = null;
let parent = null;
let elm = null;

function doSomething(scroll_pos) {
  // Do something with the scroll position
  if (elm === null) {
    if (scroll_pos < 80) {
      parent.style.boxShadow = 'none';
    } else {
      parent.style.boxShadow = '1px 5px 0 rgba(0, 0, 0, .6)';
    }
    return undefined
  } else {
    if (scroll_pos < 360) {
      parent.style.boxShadow = 'none';
    } else {
      parent.style.boxShadow = '1px 5px 0 rgba(0, 0, 0, .6)';
    }
  }
  let attr;
  if (scroll_pos < 360) {
    attr = 'translateX(-' + (110 * scroll_pos / 360) + '%)';
    attr += ' translateY(' + (100 * scroll_pos / 360) + '%)';
    attr += ' scale(' + (100 - (35 * scroll_pos / 360)) + '%)';
  } else {
    attr = 'translateX(-80vw)';
    attr += ' translateY(250px)';
    attr += ' scale(15%)';
  }
  elm.style.transform = attr;
  elm.style.borderRadius = (50 * scroll_pos / 360) + '%';
}

window.addEventListener('scroll', function(e) {
  last_known_scroll_position = window.scrollY;

  if (!ticking) {
    window.requestAnimationFrame(function() {
      doSomething(last_known_scroll_position);
      ticking = false;
    });

    ticking = true;
  }
});

window.addEventListener('load', e => {
  elm = document.querySelector('.header img');
  pegang = elm.parentElement || elm.parentNode;
  parent = pegang.parentElement || pegang.parentNode;
  if (elm === null) {
    // null
  } else if (window.screen.width < 992) {
    elm = null;
  } else {
    elm.style.cursor = 'pointer';
    elm.addEventListener('click', (evt) => {
      window.location.href = '/';
    })
  }
})