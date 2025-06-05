let last_known_scroll_position = 0;
let ticking = false;
let pegang = null;
let parent = null;
let elm = null;
let form = null;

function kumpulkanBiodata(deret) {
  let lembaran, hantar, notifikasi, jawaban;
  lembaran = { _csrf: '0' };
  deret.forEach(e => {
    switch(e.type) {
      case 'text':
      case 'tel':
      case 'password':
        lembaran[e.name] = e.value;
        break;

      case 'radio':
        if (e.checked) {
          lembaran[e.name] = e.id;
        }
        break;
      
      default:
        console.log('Tidak mengenali ' + e.name);
    }
  });
  hantar = new XMLHttpRequest;
  hantar.onreadystatechange = e => {
    if (hantar.readyState === XMLHttpRequest.DONE) {
      notifikasi = document.getElementById('notifikasi');
      jawaban = JSON.parse(hantar.responseText);
      if (hantar.status === 200) {
        if (jawaban) {
          if (jawaban.status === 'success') {
            notifikasi.classList.remove('d-none');
            form.reset();
          } else if (jawaban.status === 'exist') {
            notifikasi = document.getElementById('terdapat');
            notifikasi.classList.remove('d-none');
            form.querySelector('input[name="nickname"]').value = '';
          }
        } else {
          notifikasi = document.getElementById('umum');
          notifikasi.classList.remove('d-none');
        }
      } else {
        notifikasi = document.getElementById('umum');
        notifikasi.classList.remove('d-none');
      }
      notifikasi.scrollIntoView({ block: "center" });
    }
  }

  lembaran['telp'] = '62'.concat(lembaran['telp']);
  lembaran['password'] = CryptoJS.MD5(lembaran['password']).toString(CryptoJS.enc.Hex);

  hantar.open('POST', 'mendaftar.php', true);
  hantar.send(JSON.stringify(lembaran));
}

function doSomething(scroll_pos) {
  // Do something with the scroll position
  if (elm === null) {
    if (parent === null) {
      return undefined
    } else if (scroll_pos < 80) {
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
  } else if (document.body.clientWidth < 992) {
    elm = null;
  } else {
    elm.style.cursor = 'pointer';
    elm.addEventListener('click', (evt) => {
      window.location.href = '/';
    })
  }
  form = document.getElementsByTagName('form')[0];
  form.addEventListener('submit', e => {
    e.preventDefault();
    kumpulkanBiodata(e.target.querySelectorAll('input'));
  })
})