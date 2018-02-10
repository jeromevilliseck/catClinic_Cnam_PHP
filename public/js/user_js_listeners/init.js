//Fonction de déclenchement des listeners standard
function Listener(elem, event, fnct) {
    if (elem) {
        if (elem.addEventListener) {
            elem.addEventListener(event, fnct, false);
        } else { //IE
            elem.attachEvent('on' + event, fnct);
        }

        // Si l'événement est un click on change le curseur de souris
        if ('click' == event) {
            elem.style.cursor = 'pointer';
        }
    }
    return;
}

//caroussel FUNCTIONS START (homepage)
var picture  = document.getElementById('photo'); //Instancier par l'id
Listener(picture, 'mouseover', diaporama); //Ecouter

var image_visible = 'homePageCaroussel01.jpg';

function diaporama(){
    changeImage();
    return;
}

function changeImage(){
    var images = Array('homePageCaroussel01.jpg', 'homePageCaroussel02.jpg', 'homePageCaroussel03.jpg');
    var nb_images = images.length; //3
    var picture  = document.getElementById('photo');
    var description = document.getElementById('descript');

    //Boucle sur les images
    for (var i = 0; i < nb_images; ++i){
        if (images[i] == image_visible){
            //Condition ternaire qui reafecte image_visible avec l'image suivante
            image_visible = (images[i+1] != undefined) ? images[i+1] : images[0];

            picture.setAttribute('title', image_visible);

            if(image_visible == images[0]){
                picture.setAttribute('alt', 'photo montrant un chat');
                description.innerHTML = 'Prendre soin de ses petits compagnons';
            } else if(image_visible == images[1]){
                picture.setAttribute('alt', 'photo montrant un papillon');
                description.innerHTML = 'Un espace de sérénité';
            } else if(image_visible == images[2]){
                picture.setAttribute('alt', 'photo montrant un tigre');
                description.innerHTML = 'Nos amis les félins';
            }

            picture.setAttribute('src', '../img/' + image_visible);

            break;
        }
    }

    //Timer du changement d'image
    setTimeout(changeImage, 6000);

    return;
}
//Caroussel FUNCTIONS END