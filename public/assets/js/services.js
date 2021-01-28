const leftDiv = document.querySelector('.hiddenText');
const photos = JSON.parse(leftDiv.dataset.photos);
let picto = [];

for (i = 0; i < photos.length; i++) {
    picto[i] = document.getElementById('picto' + i);
}

function showImgText(id)
{
    let myText = document.getElementById('text' + id);
    let myImg = document.getElementById('defaultServiceImg');

    if (myText.style.visibility === 'visible') {
        myText.style.visibility = 'hidden';
        myImg.src = "/assets/images/concierge/conciergeIndex.jpg";
        myImg.style.opacity= "1";

    } else {
        myText.style.visibility = 'visible';
        myImg.src = "/assets/images/servicesImg/" + photos[id];
        myImg.style.opacity = "0.7";
    }
}

for (j = 0; j < picto.length; j++) {
    (function () {
        let id = j;
    
        picto[j].addEventListener('mouseover', function() {
            showImgText(id);
        });
        picto[j].addEventListener('mouseleave', function() {
            showImgText(id);
        });
    }());
}
