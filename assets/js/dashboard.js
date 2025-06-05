let walletcreator;
let hartacreator;
let belanja = [];

function hantarrsc(e) {
  let jawaban;
  if(this.readyState === XMLHttpRequest.DONE) {
    jawaban = JSON.parse(this.responseText);
    if(this.status === 200) {
      if(jawaban) {
        if(jawaban.status === 'success') {
          document.location.href = '/user/dashboard.php';
          return undefined;
        }
      }
    }
    this.sasaran.style = 'color: red';
    if(this.sasaran.nextElementSibling.id == 'buat-wallet') {
      this.sasaran.innerHTML = 'Gagal untuk pembuatan wallet';
    } else if (this.sasaran.nextElementSibling.id == 'buat-inventory') {
      this.sasaran.innerHTML = 'Gagal untuk pembuatan inventory';
    } else {
      this.sasaran.innerHTML = 'Operasi gagal, elemen tidak dikenali';
    }
  }
}

function buatwallet(elm) {
  let hantar = new XMLHttpRequest;
  hantar.sasaran = elm.previousElementSibling;
  hantar.onreadystatechange = hantarrsc;
  hantar.open('POST', 'util.php', true);
  hantar.send(JSON.stringify({ jalan: 'memulai', sasaran: 'wallet' }));
}

function buatharta(elm) {
  let hantar = new XMLHttpRequest;
  hantar.sasaran = elm.previousElementSibling;
  hantar.onreadystatechange = hantarrsc;
  hantar.open('POST', 'util.php', true);
  hantar.send(JSON.stringify({ jalan: 'memulai', sasaran: 'harta' }));
}

window.addEventListener('load', e => {
  document.getElementById('akun-logout').addEventListener('click', e => {
    e.preventDefault();
    document.cookie = 'userId=; domain=' + window.location.hostname + '; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/'
    window.location.href = '/user/dashboard.php';
  });
  walletcreator = document.getElementById('buat-wallet');
  if (walletcreator != null) {
    walletcreator.addEventListener('click', e => {
      e.preventDefault();
      buatwallet(e.target);
    });
  }
  hartacreator = document.getElementById('buat-harta');
  if (hartacreator != null) {
    hartacreator.addEventListener('click', e => {
      e.preventDefault();
      buatharta(e.target);
    });
  }
  let krj = document.getElementById('keranjang');
  let elmbayar = document.getElementById('total-bayar');
  elmbayar.parentElement.addEventListener('click', evt => {
    evt.preventDefault();
    let jawaban;
    let total = parseInt(elmbayar.innerHTML);
    let hantar = new XMLHttpRequest;
    hantar.onreadystatechange = e => {
      if(hantar.readyState === XMLHttpRequest.DONE) {
        console.log(hantar.responseText);
        jawaban = JSON.parse(hantar.responseText);
        if (hantar.status === 200) {
          if (jawaban) {
            if (jawaban.status === 'success') {
              krj.classList.add('d-none');
              belanja.clear();
              window.location.href = '/user/dashboard.php'
            } else {
              alert('Failed to buy groceries on shop')
            }
          }
        }
      }
    }
    hantar.open('POST', '_pasar.php', true);
    let options = { keranjang: [], total }
    for(let b of belanja) {
      let nama = b.nama
      let dari = nama.indexOf(' ') + 1
      let sampe = nama.length
      options.keranjang.push({ nama: nama.slice(dari, sampe), jumlah: b.jumlah })
    }
    console.log(JSON.stringify(options))
    hantar.send(JSON.stringify(options));
  });
  for(let e of document.getElementsByClassName('lapak')) {
    let elmumum = e.querySelector('div');
    let harga = parseInt(elmumum.nextElementSibling.innerHTML);
    let teks = elmumum.innerHTML;
    let nama = teks.slice(0, teks.indexOf(' x'));
    let count = teks.slice(teks.indexOf(' x') + 2, teks.length);
    let jumlah = count === '∞' ? 9999 : parseInt(count);
    e.querySelector('.btn-secondary').addEventListener('click', evt => {
      evt.preventDefault();
      if (krj.classList.contains('d-none')) {
        krj.classList.remove('d-none');
      }
      let urutan = evt.target.getAttribute('data-urutan');
      let barang = belanja.find(i => i.id == urutan);
      let elmbayarupdate = () => {
        let total = 0;
        for (let i of belanja) {
          total += i.jumlah * i.harga;
        }
        elmbayar.innerHTML = total.toString();
        if(total > parseInt(elmbayar.getAttribute('data-money'))) {
          elmbayar.parentElement.classList.add('disabled');
        }
      }
      if (barang) {
        barang.jumlah++;
        let kuantitas = barang.daftar.querySelector('.text-end');
        kuantitas.querySelector('span').innerHTML = 'x' + barang.jumlah.toString();
      } else {
        let nota = document.createElement('li');
        nota.classList.add('list-group-item');
        let daftar = document.createElement('div');
        daftar.className = 'lapak d-flex align-items-center';
        daftar.style = 'justify-content: space-between;';
        nota.appendChild(daftar);
        let lapak = document.createElement('div');
        lapak.classList.add('w-50');
        lapak.innerHTML = nama;
        let kuantitas = document.createElement('div');
        kuantitas.className = 'w-50 text-end';
        kuantitas.innerHTML = '<span class="me-4">x1</span><a href="#" class="btn btn-danger">Hapus</a>';
        daftar.appendChild(lapak);
        daftar.appendChild(kuantitas);
        krj.querySelector('ul').appendChild(nota);
        barang = { id: urutan, nama, jumlah: 1, harga, daftar };
        belanja.push(barang);
        kuantitas.querySelector('a').addEventListener('click', evtt => {
          evtt.preventDefault();
          krj.querySelector('ul').removeChild(nota);
          belanja.splice(belanja.indexOf(barang), 1);
          elmbayarupdate();
        });
      }
      if(barang.jumlah >= jumlah && jumlah > 0) {
        evt.target.classList.add('disabled')
      }
      elmbayarupdate();
    });
  }
});