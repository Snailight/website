function post_shell(evt) {
  if(evt.target.classList.contains('disabled')) return null
  evt.target.classList.add('disabled')
  let ketikan = document.getElementById('ketikan').value
  document.getElementById('ketikan').value = ''
  let induk = document.getElementById('papan')
  let elm = document.createElement('pre')
  elm.innerHTML = '$ '.concat(ketikan)
  induk.appendChild(elm)
  if(!ketikan) return null
  let hantar = new XMLHttpRequest
  hantar.onreadystatechange = e => {
    if (hantar.readyState === XMLHttpRequest.DONE) {
      let jawaban = hantar.responseText
      let hasil = document.createElement('pre')
      hasil.innerHTML = jawaban
      induk.appendChild(hasil)
      evt.target.classList.remove('disabled')
    }
  }
  hantar.open('POST', 'exec.php')
  hantar.send(ketikan)
}

window.addEventListener('load', evt => {
  let picu = document.getElementById('picu')
  picu.addEventListener('click', post_shell)
})