const mybutton = document.getElementById('returnTop');
const myLogo = document.getElementById('topLogo');

function scrollFunction() {
    if (document.documentElement.scrollTop > 500) {
      mybutton.style.display = "block";
      myLogo.style.visibility = "visible";
    } else {
      mybutton.style.display = "none";
      myLogo.style.visibility = "hidden";
    }
  }
  
  //when click on "go top" button, return to the top of the page
  function topFunction() {
      window.scrollTo({top: 0, behavior: 'smooth'});
  } 
  
  window.addEventListener('scroll', scrollFunction);
  mybutton.addEventListener('click', topFunction);