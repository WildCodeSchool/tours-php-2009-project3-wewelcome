const mybutton = document.getElementById('returnTop');
const myLogo = document.getElementById('topLogo');
const myNav = document.querySelector('.navBar');
const myNavLinks = document.querySelectorAll('.navLink');
let i = 0;

//background-color: rgba(44, 36, 36, 0);
function scrollFunction() {
    if (document.documentElement.scrollTop > 300) {
      mybutton.style.display = "block";
      myLogo.style.visibility = "visible";
      myNav.style.backgroundColor = "rgba(85, 69, 69, 0.897)";

      for (i = 0; i < myNavLinks.length; ++i) {
        myNavLinks[i].style.color = "whitesmoke";
      }
    } else {
      mybutton.style.display = "none";
      myLogo.style.visibility = "hidden";
      myNav.style.backgroundColor = "rgba(85, 69, 69, 0)";
      
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