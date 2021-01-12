const srcImgRight = "/assets/images/stewardship/stewardShipIndex.jpg";
const srcImgChange = "/assets/images/home-intendance.jpg";
const opacityChange = "0.7";

const pictoStewardshipAssistance = document.getElementById('pictoStewardshipAssistance');
const pictoShopping = document.getElementById('pictoShopping');
const pictoEntretienIntExt = document.getElementById('pictoEntretienIntExt');
const pictoGarden = document.getElementById('pictoGarden');
const pictoTurnOnOff = document.getElementById('pictoTurnOnOff');
const pictoLittleWork = document.getElementById('pictoLittleWork');
const pictoPool = document.getElementById('pictoPool');
const pictoFollowUpWork = document.getElementById('pictoFollowUpWork');
const pictoRegularMonitoring = document.getElementById('pictoRegularMonitoring');

function showStewardshipAssistance()
{
    let myText = document.getElementById('textStewardAssistance');
    let myImg = document.getElementById('stewardImg');

    if (myText.style.visibility === 'visible') {
        myText.style.visibility = 'hidden';
        myImg.src = srcImgRight;
        myImg.style.opacity= "1";

    } else {
        myText.style.visibility = 'visible';
        myImg.src = srcImgChange;
        myImg.style.opacity = opacityChange;
    }
}

function showShopping()
{
    let myText = document.getElementById('textShopping');
    let myImg = document.getElementById('stewardImg');

    if (myText.style.visibility === 'visible') {
        myText.style.visibility = 'hidden';
        myImg.src = srcImgRight;
        myImg.style.opacity= "1";
    } else {
        myText.style.visibility = 'visible';
        myImg.src = srcImgChange;
        myImg.style.opacity = opacityChange;
    }
}

function showEntretienIntExt()
{
    let myText = document.getElementById('textEntretienIntExt');
    let myImg = document.getElementById('stewardImg');

    if (myText.style.visibility === 'visible') {
        myText.style.visibility = 'hidden';
        myImg.src = srcImgRight;
        myImg.style.opacity= "1";
    } else {
        myText.style.visibility = 'visible';
        myImg.src = srcImgChange;
        myImg.style.opacity = opacityChange;
    }
}

function showGarden()
{
    let myText = document.getElementById('textGarden');
    let myImg = document.getElementById('stewardImg');

    if (myText.style.visibility === 'visible') {
        myText.style.visibility = 'hidden';
        myImg.src = srcImgRight;
        myImg.style.opacity= "1";
    } else {
        myText.style.visibility = 'visible';
        myImg.src = srcImgChange;
        myImg.style.opacity = opacityChange;
    }
}

function showTurnOnOff()
{
    let myText = document.getElementById('textMiseRouteVeille');
    let myImg = document.getElementById('stewardImg');

    if (myText.style.visibility === 'visible') {
        myText.style.visibility = 'hidden';
        myImg.src = srcImgRight;
        myImg.style.opacity= "1";
    } else {
        myText.style.visibility = 'visible';
        myImg.src = srcImgChange;
        myImg.style.opacity = opacityChange;
    }
}

function showLittleWork()
{
    let myText = document.getElementById('textLittleWork');
    let myImg = document.getElementById('stewardImg');

    if (myText.style.visibility === 'visible') {
        myText.style.visibility = 'hidden';
        myImg.src = srcImgRight;
        myImg.style.opacity= "1";
    } else {
        myText.style.visibility = 'visible';
        myImg.src = srcImgChange;
        myImg.style.opacity = opacityChange;
    }
}

function showPool()
{
    let myText = document.getElementById('textPool');
    let myImg = document.getElementById('stewardImg');

    if (myText.style.visibility === 'visible') {
        myText.style.visibility = 'hidden';
        myImg.src = srcImgRight;
        myImg.style.opacity= "1";
    } else {
        myText.style.visibility = 'visible';
        myImg.src = srcImgChange;
        myImg.style.opacity = opacityChange;
    }
}

function showFollowUpWork()
{
    let myText = document.getElementById('textFollowUpWork');
    let myImg = document.getElementById('stewardImg');

    if (myText.style.visibility === 'visible') {
        myText.style.visibility = 'hidden';
        myImg.src = srcImgRight;
        myImg.style.opacity= "1";
    } else {
        myText.style.visibility = 'visible';
        myImg.src = srcImgChange;
        myImg.style.opacity = opacityChange;
    }
}

function showRegularMonitoring()
{
    let myText = document.getElementById('textRegularMonitoring');
    let myImg = document.getElementById('stewardImg');

    if (myText.style.visibility === 'visible') {
        myText.style.visibility = 'hidden';
        myImg.src = srcImgRight;
        myImg.style.opacity= "1";
    } else {
        myText.style.visibility = 'visible';
        myImg.src = srcImgChange;
        myImg.style.opacity = opacityChange;
    }
}

pictoShopping.addEventListener('mouseover', showShopping);
pictoShopping.addEventListener('mouseleave', showShopping);

pictoEntretienIntExt.addEventListener('mouseover', showEntretienIntExt);
pictoEntretienIntExt.addEventListener('mouseleave', showEntretienIntExt);

pictoGarden.addEventListener('mouseover', showGarden);
pictoGarden.addEventListener('mouseleave', showGarden);

pictoTurnOnOff.addEventListener('mouseover', showTurnOnOff);
pictoTurnOnOff.addEventListener('mouseleave', showTurnOnOff);

pictoLittleWork.addEventListener('mouseover', showLittleWork);
pictoLittleWork.addEventListener('mouseleave', showLittleWork);

pictoPool.addEventListener('mouseover', showPool);
pictoPool.addEventListener('mouseleave', showPool);

pictoFollowUpWork.addEventListener('mouseover', showFollowUpWork);
pictoFollowUpWork.addEventListener('mouseleave', showFollowUpWork);

pictoRegularMonitoring.addEventListener('mouseover', showRegularMonitoring);
pictoRegularMonitoring.addEventListener('mouseleave', showRegularMonitoring);

pictoStewardshipAssistance.addEventListener('mouseover', showStewardshipAssistance);
pictoStewardshipAssistance.addEventListener('mouseleave', showStewardshipAssistance);