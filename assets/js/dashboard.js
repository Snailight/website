window.addEventListener('load', e => {
    document.getElementById('akun-logout').addEventListener('click', e => {
        e.preventDefault();
        document.cookie = 'userId=; domain=' + window.location.hostname + '; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/'
        window.location.href = '/user/dashboard.php';
    });
});