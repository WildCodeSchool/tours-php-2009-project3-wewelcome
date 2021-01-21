const keyFigures = document.querySelector(".key-figures");
const keyFigure1 = document.querySelector("#key-figure-1");
const keyFigure2 = document.querySelector("#key-figure-2");
const keyFigure3 = document.querySelector("#key-figure-3");
const keyFigure4 = document.querySelector("#key-figure-4");
const keyFigure11 = document.querySelector("#key-figure-11");
const keyFigure21 = document.querySelector("#key-figure-21");
const keyFigure31 = document.querySelector("#key-figure-31");
const keyFigure41 = document.querySelector("#key-figure-41");
const keyFigureContact = document.querySelector("#key-figure-contact");

const serviceVision = document.querySelector(".service-vision");
const serviceVision1 = document.querySelector("#service-vision-1");
const serviceVision2 = document.querySelector("#service-vision-2");
const serviceVision3 = document.querySelector("#service-vision-3");
const serviceVision4 = document.querySelector("#service-vision-4");
const serviceVisionContact = document.querySelector("#service-vision-contact");

function moveLeft(cible, position, speed, delay) {
    cible.style.left = position;
    cible.style.transition = "left " + speed + " ease-in-out " + delay;
}

function moveRight(cible, position, speed, delay) {
    cible.style.right = position;
    cible.style.transition = "right " + speed + " ease-in-out " + delay;
}

keyFigures.addEventListener("mouseover", function() {
    moveLeft(keyFigure1, "20vw", "1s", "0s");
    moveLeft(keyFigure2, "18vw", "1s", "0.5s");
    moveLeft(keyFigure3, "16vw", "1s", "1s");
    moveLeft(keyFigure4, "14vw", "1s", "1.5s");
    moveRight(keyFigure11, "24vw", "1s", "0s");
    moveRight(keyFigure21, "26vw", "1s", "0.5s");
    moveRight(keyFigure31, "28vw", "1s", "1s");
    moveRight(keyFigure41, "30vw", "1s", "1.5s");
    moveRight(keyFigureContact, "20vw", "1.5s", "2s");
});

keyFigures.addEventListener("mouseleave", function() {
    moveLeft(keyFigure1, "-100vw", "1s");
    moveLeft(keyFigure2, "-100vw", "1s");
    moveLeft(keyFigure3, "-100vw", "1s");
    moveLeft(keyFigure4, "-100vw", "1s");
    moveRight(keyFigure11, "-100vw", "1s");
    moveRight(keyFigure21, "-100vw", "1s");
    moveRight(keyFigure31, "-100vw", "1s");
    moveRight(keyFigure41, "-100vw", "1s");
    moveRight(keyFigureContact, "-100vw", "1s");
});

serviceVision.addEventListener("mouseover", function() {
    moveLeft(serviceVision1, "26vw", "1s", "0s");
    moveLeft(serviceVision2, "24vw", "1s", "0.5s");
    moveLeft(serviceVision3, "22vw", "1s", "1s");
    moveLeft(serviceVision4, "20vw", "1s", "1.5s");
    moveRight(serviceVisionContact, "20vw", "1.5s", "2s");
});

serviceVision.addEventListener("mouseleave", function() {
    moveLeft(serviceVision1, "-100vw", "1s");
    moveLeft(serviceVision2, "-100vw", "1s");
    moveLeft(serviceVision3, "-100vw", "1s");
    moveLeft(serviceVision4, "-100vw", "1s");
    moveRight(serviceVisionContact, "-100vw", "1s");
});
