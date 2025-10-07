document.addEventListener("DOMContentLoaded", () => {
    // Menu par continent
    document.getElementById("perContinent").addEventListener("click", (e) => {
        const ulContinent = document.getElementById("ulContinent");
        ulContinent.hidden = !ulContinent.hidden;
    });

    // Menu par profil
    document.getElementById("perProfile").addEventListener("click", (e) => {
        const ulProfile = e.target.closest(".menu").querySelector("ul");
        ulProfile.hidden = !ulProfile.hidden;
    });

    //Sous-menu Afrique
    document.getElementById("Afrique").addEventListener("click", (e) => {
        const ulAfrique = document.getElementById("ulAfrique");
        ulAfrique.hidden = !ulAfrique.hidden;
    });
    //Sous-menu Asie
    document.getElementById("Asie").addEventListener("click", (e) => {
        const ulAsie = document.getElementById("ulAsie");
        ulAsie.hidden = !ulAsie.hidden;
    });
});



const slider = document.querySelector('.slider');

function activate(e) {
  const items = document.querySelectorAll('.item');
  e.target.matches('.next') && slider.append(items[0])
  e.target.matches('.prev') && slider.prepend(items[items.length-1]);
}

document.addEventListener('click',activate,false);