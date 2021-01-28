const keyFigures = document.querySelector(".key-figures");
const keyFigure1 = document.querySelector("#key-figure-1");
const keyFigure2 = document.querySelector("#key-figure-2");
const keyFigure3 = document.querySelector("#key-figure-3");
const keyFigure4 = document.querySelector("#key-figure-4");
const keyFigure11 = document.querySelector("#key-figure-11");
const keyFigure21 = document.querySelector("#key-figure-21");
const keyFigure31 = document.querySelector("#key-figure-31");
const keyFigure41 = document.querySelector("#key-figure-41");

const serviceVision = document.querySelector(".service-vision");
const serviceVision1 = document.querySelector("#service-vision-1");
const serviceVision2 = document.querySelector("#service-vision-2");
const serviceVision3 = document.querySelector("#service-vision-3");
const serviceVision4 = document.querySelector("#service-vision-4");

function moveLeft(cible, position, speed, delay) {
    cible.style.left = position;
    cible.style.transition = "left " + speed + " ease-in-out " + delay;
}

if (window.matchMedia("(max-width: 1200px)").matches) {
    keyFigure1.style.left = "20vw";
    keyFigure2.style.left = "19vw";
    keyFigure3.style.left = "18vw";
    keyFigure4.style.left = "17vw";
    keyFigure11.style.left = "35vw";
    keyFigure21.style.left = "34vw";
    keyFigure31.style.left = "33vw";
    keyFigure41.style.left = "32vw";
} else {
    keyFigures.addEventListener("mouseover", function() {
        moveLeft(keyFigure1, "20vw", "1s", "0s");
        moveLeft(keyFigure2, "19vw", "1s", "0.5s");
        moveLeft(keyFigure3, "18vw", "1s", "1s");
        moveLeft(keyFigure4, "17vw", "1s", "1.5s");
        moveLeft(keyFigure11, "35vw", "0.5s", "0.5s");
        moveLeft(keyFigure21, "34vw", "0.5s", "1s");
        moveLeft(keyFigure31, "33vw", "0.5s", "1.5s");
        moveLeft(keyFigure41, "32vw", "0.5s", "2s");
    });
}

if (window.matchMedia("(max-width: 1200px)").matches) {
    serviceVision1.style.left = "26vw";
    serviceVision2.style.left = "24vw";
    serviceVision3.style.left = "22vw";
    serviceVision4.style.left = "20vw";
} else {
    serviceVision.addEventListener("mouseover", function() {
        moveLeft(serviceVision1, "26vw", "1s", "0s");
        moveLeft(serviceVision2, "24vw", "1s", "0.5s");
        moveLeft(serviceVision3, "22vw", "1s", "1s");
        moveLeft(serviceVision4, "20vw", "1s", "1.5s");
    });
}
