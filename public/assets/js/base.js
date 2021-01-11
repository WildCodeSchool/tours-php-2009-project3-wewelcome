const mybutton = document.getElementById('returnTop');
const myLogo = document.querySelector('#topLogo img');
const myNav = document.querySelector('.navBar');
const myNavLinks = document.querySelectorAll('.navLink');
let i = 0;

function scrollFunction() {
    if (document.documentElement.scrollTop > 300) {
      mybutton.style.display = "block";
      myLogo.style.width = "200px";
      myLogo.style.transition = "width 1s ease-in-out";
      myLogo.setAttribute("src", "/assets/images/logo-wewelcome-500px-white.png");
      myNav.style.backgroundColor = "var(--primary-color)";

      for (i = 0; i < myNavLinks.length; ++i) {
        myNavLinks[i].style.color = "whitesmoke";
      }
    } else {
      mybutton.style.display = "none";
      myLogo.style.width = "400px";
      myLogo.style.transition = "width 1s ease-in-out";
      myLogo.setAttribute("src", "/assets/images/logo-wewelcome-500px-color.png");
      myNav.style.backgroundColor = "rgba(255, 255, 255, 0)";
      
      for (i = 0; i < myNavLinks.length; ++i) {
        myNavLinks[i].style.color = "var(--primary-color)";
      }
    }
  }
  
  //when click on "go top" button, return to the top of the page
  function topFunction() {
      window.scrollTo({top: 0, behavior: 'smooth'});
  } 
  
  window.addEventListener('scroll', scrollFunction);
  mybutton.addEventListener('click', topFunction);