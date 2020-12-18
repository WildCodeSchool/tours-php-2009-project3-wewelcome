const serviceVision1 = document.querySelector("#service-vision-1");
const serviceVision2 = document.querySelector("#service-vision-2");
const serviceVision3 = document.querySelector("#service-vision-3");
const serviceVision4 = document.querySelector("#service-vision-4");

const keyFigure1 = document.querySelector("#key-figure-1");
const keyFigure2 = document.querySelector("#key-figure-2");
const keyFigure3 = document.querySelector("#key-figure-3");
const keyFigure4 = document.querySelector("#key-figure-4");

function moveLeft(cible, position, speed, delay) {
    cible.style.left = position;
    cible.style.transition = "left " + speed + " ease-out " + delay;
}

function scrollServiceVision() {
    if (document.documentElement.scrollTop > 1800 & document.documentElement.scrollTop < 2300) {
        moveLeft(serviceVision1, "60vh", "2s", "0s");
        moveLeft(serviceVision2, "50vh", "2s", "0.5s");
        moveLeft(serviceVision3, "40vh", "2s", "1s");
        moveLeft(serviceVision4, "30vh", "2s", "1.5s");

    } else {
        moveLeft(serviceVision1, "-50vh", "1s");
        moveLeft(serviceVision2, "-50vh", "1s");
        moveLeft(serviceVision3, "-50vh", "1s");
        moveLeft(serviceVision4, "-50vh", "1s");
    }
}

function scrollKeyFigures() {
    if (document.documentElement.scrollTop > 3500 & document.documentElement.scrollTop < 4000) {
        moveLeft(keyFigure1, "10vh", "2s", "0s");
        moveLeft(keyFigure2, "10vh", "2s", "0.5s");
        moveLeft(keyFigure3, "10vh", "2s", "1s");
        moveLeft(keyFigure4, "10vh", "2s", "1.5s");
        
    } else {
        moveLeft(keyFigure1, "-50vh", "1s");
        moveLeft(keyFigure2, "-50vh", "1s");
        moveLeft(keyFigure3, "-50vh", "1s");
        moveLeft(keyFigure4, "-50vh", "1s");
    }
}

window.addEventListener('scroll', scrollServiceVision);

window.addEventListener('scroll', scrollKeyFigures);