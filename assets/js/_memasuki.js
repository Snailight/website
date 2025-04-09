let form;
let formasi;
let id;
let pwd;

function kumpulkan(deret) {
  let perhatian = document.getElementById('umum');
  deret.forEach(val => {
    switch(val.name) {
      case 'username':
        if(val.value.match(/^(?:(?:08)|(?:628)|(?:\+628))/)) {
          formasi = 'telp';
        } else {
          formasi = 'nickname';
        }
        id = val.value;
        break;
      
      case 'password':
        pwd = val.value;
        if(pwd.length < 8) {
          perhatian.classList.remove('d-none');
          perhatian.innerHTML = "Password terdiri dari 8 karakter";
          pwd = null;
        } else {
          pwd = CryptoJS.MD5(pwd).toString(CryptoJS.enc.Hex);
        }
        break;
      
      default:
        console.log('Tidak mengenali ' + e.name);
    }
  });

  if(pwd === null) return undefined;
  let formulir = { formasi, id, pwd };
  let jawaban;
  let hantar = new XMLHttpRequest;
  hantar.onreadystatechange = e => {
    if(hantar.readyState === XMLHttpRequest.DONE) {
      perhatian.classList.remove('d-none');
      console.log(hantar.responseText);
      jawaban = JSON.parse(hantar.responseText);
      if(hantar.status === 200) {
        if (jawaban) {
          if (jawaban.status === 'success') {
            document.cookie += 'userId='
              .concat(jawaban.userId.toString())
              .concat('; path=/; domain=')
              .concat(window.location.hostname);
            window.location = '/user/dashboard.php';
          } else if (jawaban.status === 'notfound') {
            perhatian.innerHTML = 'Akun tidak ditemukan';
          } else if (jawaban.status === 'id') {
            perhatian.innerHTML = 'Username salah!';
          } else if (jawaban.status === 'pwd') {
            perhatian.innerHTML = 'Password salah!';
          } else {
            perhatian.innerHTML = 'Database tidak dapat diakses!';
          }
        } else {
          perhatian.innerHTML = "Kesalahan respon server\nJSON tidak terbaca";
        }
      } else {
        perhatian.innerHTML = 'Kesalahan tidak dikenali';
      }
    }
  }
  hantar.open('POST', 'memasuki.php', true);
  hantar.send(JSON.stringify(formulir));
}

window.addEventListener('load', e => {
  form = document.getElementsByTagName('form')[0];
  form.addEventListener('submit', e => {
    e.preventDefault();
    kumpulkan(e.target.querySelectorAll('input'));
  })
})