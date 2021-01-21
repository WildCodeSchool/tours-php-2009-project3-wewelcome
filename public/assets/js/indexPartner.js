const partnersBookingAll = document.querySelector(".partners-booking-all");
const partnersOthersAll = document.querySelector(".partners-others-all");
const partnersBookingAllButton = document.querySelector("#partners-booking-all-button");
const partnersOthersAllButton = document.querySelector("#partners-others-all-button");

function showPartnersBookingAll()
{
    if (partnersBookingAll.style.display === "grid") {
        partnersBookingAll.style.display = "none";
        partnersBookingAllButton.value = "+";
    } else {
        partnersBookingAll.style.display = "grid";
        partnersBookingAllButton.value = "-";
    }
}

partnersBookingAllButton.addEventListener("click", showPartnersBookingAll);

function showPartnersOthersAll()
{
    if (partnersOthersAll.style.display === "grid") {
        partnersOthersAll.style.display = "none";
        partnersOthersAllButton.value = "+";
    } else {
        partnersOthersAll.style.display = "grid";
        partnersOthersAllButton.value = "-";
    }
}

partnersOthersAllButton.addEventListener("click", showPartnersOthersAll);
