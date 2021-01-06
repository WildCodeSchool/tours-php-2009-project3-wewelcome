const pictoWelcoming = document.getElementById('pictoWelcoming');
const pictoAssistance = document.getElementById('pictoAssistance');
const pictoGeneral = document.getElementById('pictoGeneral');
const pictoLinens = document.getElementById('pictoLinens');
const pictoCleaning = document.getElementById('pictoCleaning');
const pictoFoodBasket = document.getElementById('pictoFoodBasket');
const pictoStewardship = document.getElementById('pictoStewardship');

function showWelcomingText()
{
    let myText = document.getElementById('textWelcoming');

    if (myText.style.visibility === 'visible') {
        myText.style.visibility = 'hidden';
    } else {
        myText.style.visibility = 'visible';
    }
}

function showAssistanceText()
{
    let myText = document.getElementById('textAssistance');

    if (myText.style.visibility === 'visible') {
        myText.style.visibility = 'hidden';
    } else {
        myText.style.visibility = 'visible';
    }
}

function showGeneralText()
{
    let myText = document.getElementById('textGeneral');

    if (myText.style.visibility === 'visible') {
        myText.style.visibility = 'hidden';
    } else {
        myText.style.visibility = 'visible';
    }
}

function showLinensText()
{
    let myText = document.getElementById('textLinens');

    if (myText.style.visibility === 'visible') {
        myText.style.visibility = 'hidden';
    } else {
        myText.style.visibility = 'visible';
    }
}

function showCleaningText()
{
    let myText = document.getElementById('textCleaning');

    if (myText.style.visibility === 'visible') {
        myText.style.visibility = 'hidden';
    } else {
        myText.style.visibility = 'visible';
    }
}

function showFoodBasketText()
{
    let myText = document.getElementById('textFoodBasket');

    if (myText.style.visibility === 'visible') {
        myText.style.visibility = 'hidden';
    } else {
        myText.style.visibility = 'visible';
    }
}

function showStewardShipText()
{
    let myText = document.getElementById('textStewardship');

    if (myText.style.visibility === 'visible') {
        myText.style.visibility = 'hidden';
    } else {
        myText.style.visibility = 'visible';
    }
}

pictoWelcoming.addEventListener('mouseover', showWelcomingText);
pictoWelcoming.addEventListener('mouseleave', showWelcomingText);

pictoAssistance.addEventListener('mouseover', showAssistanceText);
pictoAssistance.addEventListener('mouseleave', showAssistanceText);

pictoGeneral.addEventListener('mouseover', showGeneralText);
pictoGeneral.addEventListener('mouseleave', showGeneralText);

pictoLinens.addEventListener('mouseover', showLinensText);
pictoLinens.addEventListener('mouseleave', showLinensText);

pictoCleaning.addEventListener('mouseover', showCleaningText);
pictoCleaning.addEventListener('mouseleave', showCleaningText);

pictoFoodBasket.addEventListener('mouseover', showFoodBasketText);
pictoFoodBasket.addEventListener('mouseleave', showFoodBasketText);

pictoStewardship.addEventListener('mouseover', showStewardShipText);
pictoStewardship.addEventListener('mouseleave', showStewardShipText);