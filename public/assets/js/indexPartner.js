let allPartners = document.getElementById("allPartners");

function showMorePartners()
{
    const navPartnerInvisible = document.querySelector('.navPartnerInvisible');

    if (navPartnerInvisible.style.display === "grid") {
        navPartnerInvisible.style.display = "none";
    } else {
        navPartnerInvisible.style.display = "grid";
    }
}

allPartners.addEventListener("click", showMorePartners);