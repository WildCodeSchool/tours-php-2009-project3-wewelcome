const pictoPostingOnline = document.getElementById('pictoPostingOnline');
const pictoBookingManagement = document.getElementById('pictoBookingManagement');
const pictoBookingOptimization = document.getElementById('pictoBookingOptimization');
const pictoWelcoming = document.getElementById('pictoWelcoming');
const pictoAssistance = document.getElementById('pictoAssistance');
const pictoFoodBasket = document.getElementById('pictoFoodBasket');
const pictoLinens = document.getElementById('pictoLinens');
const pictoCleaning = document.getElementById('pictoCleaning');
const pictoStewardship = document.getElementById('pictoStewardship');

function showPostingOnline()
{
    let myText = document.getElementById('textPostingOnline');
    let myImg = document.getElementById('conciergeImg');

    if (myText.style.visibility === 'visible') {
        myText.style.visibility = 'hidden';
        myImg.src = "/assets/images/concierge/conciergeIndex.jpg";
        myImg.style.opacity= "1";

    } else {
        myText.style.visibility = 'visible';
        myImg.src = "/assets/images/concierge/welcomingImg.jpg";
        myImg.style.opacity = "0.7";
    }
}

function showBookingManagement()
{
    let myText = document.getElementById('textBookingManagement');
    let myImg = document.getElementById('conciergeImg');

    if (myText.style.visibility === 'visible') {
        myText.style.visibility = 'hidden';
        myImg.src = "/assets/images/concierge/conciergeIndex.jpg";
        myImg.style.opacity= "1";

    } else {
        myText.style.visibility = 'visible';
        myImg.src = "/assets/images/concierge/welcomingImg.jpg";
        myImg.style.opacity = "0.7";
    }
}

function showBookingOptimization()
{
    let myText = document.getElementById('textBookingOptimization');
    let myImg = document.getElementById('conciergeImg');

    if (myText.style.visibility === 'visible') {
        myText.style.visibility = 'hidden';
        myImg.src = "/assets/images/concierge/conciergeIndex.jpg";
        myImg.style.opacity= "1";

    } else {
        myText.style.visibility = 'visible';
        myImg.src = "/assets/images/concierge/welcomingImg.jpg";
        myImg.style.opacity = "0.7";
    }
}

function showWelcomingText()
{
    let myText = document.getElementById('textWelcoming');
    let myImg = document.getElementById('conciergeImg');

    if (myText.style.visibility === 'visible') {
        myText.style.visibility = 'hidden';
        myImg.src = "/assets/images/concierge/conciergeIndex.jpg";
        myImg.style.opacity= "1";

    } else {
        myText.style.visibility = 'visible';
        myImg.src = "/assets/images/concierge/welcomingImg.jpg";
        myImg.style.opacity = "0.7";
    }
}

function showAssistanceText()
{
    let myText = document.getElementById('textAssistance');
    let myImg = document.getElementById('conciergeImg');

    if (myText.style.visibility === 'visible') {
        myText.style.visibility = 'hidden';
        myImg.src = "/assets/images/concierge/conciergeIndex.jpg";
        myImg.style.opacity= "1";
    } else {
        myText.style.visibility = 'visible';
        myImg.src = "/assets/images/concierge/assistanceImg.png";
        myImg.style.opacity= "0.7";
    }
}

function showFoodBasketText()
{
    let myText = document.getElementById('textFoodBasket');
    let myImg = document.getElementById('conciergeImg');

    if (myText.style.visibility === 'visible') {
        myText.style.visibility = 'hidden';
        myImg.src = "/assets/images/concierge/conciergeIndex.jpg";
        myImg.style.opacity= "1";
    } else {
        myText.style.visibility = 'visible';
        myImg.src = "/assets/images/concierge/foodBasketImg.jpg";
        myImg.style.opacity= "0.7";
    }
}

function showLinensText()
{
    let myText = document.getElementById('textLinens');
    let myImg = document.getElementById('conciergeImg');

    if (myText.style.visibility === 'visible') {
        myText.style.visibility = 'hidden';
        myImg.src = "/assets/images/concierge/conciergeIndex.jpg";
        myImg.style.opacity= "1";
    } else {
        myText.style.visibility = 'visible';
        myImg.src = "/assets/images/concierge/linensImg.jpg";
        myImg.style.opacity= "0.7";
    }
}

function showCleaningText()
{
    let myText = document.getElementById('textCleaning');
    let myImg = document.getElementById('conciergeImg');

    if (myText.style.visibility === 'visible') {
        myText.style.visibility = 'hidden';
        myImg.src = "/assets/images/concierge/conciergeIndex.jpg";
        myImg.style.opacity= "1";
    } else {
        myText.style.visibility = 'visible';
        myImg.src = "/assets/images/concierge/cleaningImg.jpg";
        myImg.style.opacity= "0.7";
    }
}

function showStewardShipText()
{
    let myText = document.getElementById('textStewardship');
    let myImg = document.getElementById('conciergeImg');

    if (myText.style.visibility === 'visible') {
        myText.style.visibility = 'hidden';
        myImg.src = "/assets/images/concierge/conciergeIndex.jpg";
        myImg.style.opacity= "1";
    } else {
        myText.style.visibility = 'visible';
        myImg.src = "/assets/images/concierge/intendanceImg.jpg";
        myImg.style.opacity= "0.7";
    }
}

pictoPostingOnline.addEventListener('mouseover', showPostingOnline);
pictoPostingOnline.addEventListener('mouseleave', showPostingOnline);

pictoBookingManagement.addEventListener('mouseover', showBookingManagement);
pictoBookingManagement.addEventListener('mouseleave', showBookingManagement);

pictoBookingOptimization.addEventListener('mouseover', showBookingOptimization);
pictoBookingOptimization.addEventListener('mouseleave', showBookingOptimization);

pictoWelcoming.addEventListener('mouseover', showWelcomingText);
pictoWelcoming.addEventListener('mouseleave', showWelcomingText);

pictoAssistance.addEventListener('mouseover', showAssistanceText);
pictoAssistance.addEventListener('mouseleave', showAssistanceText);

pictoFoodBasket.addEventListener('mouseover', showFoodBasketText);
pictoFoodBasket.addEventListener('mouseleave', showFoodBasketText);

pictoLinens.addEventListener('mouseover', showLinensText);
pictoLinens.addEventListener('mouseleave', showLinensText);

pictoCleaning.addEventListener('mouseover', showCleaningText);
pictoCleaning.addEventListener('mouseleave', showCleaningText);

pictoStewardship.addEventListener('mouseover', showStewardShipText);
pictoStewardship.addEventListener('mouseleave', showStewardShipText);