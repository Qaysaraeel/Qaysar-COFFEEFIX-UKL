let search = document.querySelector('.search-box');
let searchIcon = document.querySelector('#search-icon');
let isActive = false;

searchIcon.onclick = () => {
    isActive = !isActive; // Toggle nilai isActive
    if (isActive) {
        search.classList.add('active'); // Tambahkan kelas 'active'
    } else {
        search.classList.remove('active'); // Hapus kelas 'active'
    }
}

let navbar = document.querySelector('.navbar');

document.querySelector('#menu-icon').onclick = () => {
    navbar.classList.toggle('active');
}


let header = document.querySelector('header');

window.addEventListener('scroll' , () => {
    header.classList.toggle('shadow', window.scrollY > 0);
});

