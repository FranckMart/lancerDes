<?php
/*
 Plugin Name: Lancer de dès
 Description: Modul Mini jeu de lancer de dès 
 Author: Martinez Franck
 Version: 1.0
*/

// Fonction qui affiche le liens et l'image de la page de lancer de dés dans la barre de menu Admin
function addLinkMenuAdmin(){
    add_menu_page(
        "Lancer de dès",
        "Lancer de dès",
        "manage_options",
        "lancer_de_Des/includes/affichage.php",
        "",
        //<a target="_blank" href="https://icones8.fr/icons/set/dice">Dé icon</a> icône par <a target="_blank" href="https://icones8.fr">Icons8</a>//
        plugins_url("lancer_de_Des/img/des.png"),
        100
    );
}

add_action("admin_menu","addLinkMenuAdmin");