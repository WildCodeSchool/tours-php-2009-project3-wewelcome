const srcImgRight = "/assets/images/stewardship/stewardShipIndex.jpg";

const pictoStewardshipAssistance = document.getElementById('pictoStewardshipAssistance');
const pictoShopping = document.getElementById('pictoShopping');
const pictoEntretienIntExt = document.getElementById('pictoEntretienIntExt');
const pictoGeneralInt = document.getElementById('pictoGeneralInt');
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
        myImg.src = srcImgRight;
        myImg.style.opacity = "0.7";
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
        myImg.src = srcImgRight;
        myImg.style.opacity= "0.7";
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
        myImg.src = srcImgRight;
        myImg.style.opacity= "0.7";
    }
}

function showGeneralInt()
{
    let myText = document.getElementById('textGeneralInt');
    let myImg = document.getElementById('stewardImg');

    if (myText.style.visibility === 'visible') {
        myText.style.visibility = 'hidden';
        myImg.src = srcImgRight;
        myImg.style.opacity= "1";
    } else {
        myText.style.visibility = 'visible';
        myImg.src = srcImgRight;
        myImg.style.opacity= "0.7";
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
        myImg.src = srcImgRight;
        myImg.style.opacity= "0.7";
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
        myImg.src = srcImgRight;
        myImg.style.opacity= "0.7";
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
        myImg.src = srcImgRight;
        myImg.style.opacity= "0.7";
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
        myImg.src = srcImgRight;
        myImg.style.opacity= "0.7";
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
        myImg.src = srcImgRight;
        myImg.style.opacity= "0.7";
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
        myImg.src = srcImgRight;
        myImg.style.opacity= "0.7";
    }
}

pictoStewardshipAssistance.addEventListener('mouseover', showStewardshipAssistance);
pictoStewardshipAssistance.addEventListener('mouseleave', showStewardshipAssistance);

pictoShopping.addEventListener('mouseover', showShopping);
pictoShopping.addEventListener('mouseleave', showShopping);

pictoEntretienIntExt.addEventListener('mouseover', showEntretienIntExt);
pictoEntretienIntExt.addEventListener('mouseleave', showEntretienIntExt);

pictoGeneralInt.addEventListener('mouseover', showGeneralInt);
pictoGeneralInt.addEventListener('mouseleave', showGeneralInt);

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