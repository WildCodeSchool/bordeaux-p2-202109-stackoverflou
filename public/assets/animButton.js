const logo = document.getElementById('navbarLogo');

logo.addEventListener('mouseenter',function(){
    logo.classList.add('animation-button')
});
logo.addEventListener('mouseleave',function(){
    logo.classList.remove('animation-button')
});