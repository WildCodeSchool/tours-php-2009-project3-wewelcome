const mybutton = document.getElementById('returnTop');
const myLogo = document.querySelector('#topLogo img');
const myNav = document.querySelector('.navBar');
const myNavLinks = document.querySelectorAll('.navLink');
let i = 0;

function scrollFunction() {
    if (document.documentElement.scrollTop > 300) {
      mybutton.style.display = "block";
      myLogo.style.width = "10vw";
      myLogo.style.transition = "width 1s ease-in-out";
      myLogo.setAttribute("src", "/assets/images/logo-wewelcome-white.png");
      myNav.style.backgroundColor = "var(--primary-color)";
      myNav.style.alignItems = "center";

      for (i = 0; i < myNavLinks.length; ++i) {
        myNavLinks[i].style.color = "whitesmoke";
      }
    } else {
      mybutton.style.display = "none";
      myLogo.style.width = "20vw";
      myLogo.style.transition = "width 1s ease-in-out";
      myLogo.setAttribute("src", "/assets/images/logo-wewelcome-color.png");
      myNav.style.backgroundColor = "rgba(255, 255, 255, 0)";
      myNav.style.alignItems = "start";
      
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
