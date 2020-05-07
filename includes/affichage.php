<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Ajout du style -->
    <style>
        table,
        th {
            border: 1px solid #333;
        }

        thead,
        tfoot {
            background-color: #333;
            color: #fff;
        }
    </style>
</head>

<body>


    <!-- Ajout de la variable SuperGlobal qui permmet de recupérer les infrormations de la bdd Wordpress_ics -->
    <?php
    global $wpdp;
    ?>


    <?php

    // Fonction WP qui récupère les informations de l'utilisateur
    $current_user = wp_get_current_user();

    // Récupère le pseudo de l'utilisateur 
    $name = esc_html($current_user->user_login);

    // Récupère la date dans ce format 2020-05-07 13:40:36
    $hours =  current_time('mysql') . '<br />';


    ?>


    <!-- Ici on créer le formulaire d'ajout de nombre -->
    <h1>Lancer de dés</h1>
    <!-- Action sur la même page la récupérations des informations ce fera grâce au name des input  -->
    <form action="" method="post">
        <label for="d2">D2</label>

        <input type="number" id="d2" name="d2" min="0" max="10" value="0"><br>
        <label for="d4">D4</label>

        <input type="number" id="d4" name="d4" min="0" max="10" value="0"><br>
        <label for="d6">D6</label>

        <input type="number" id="d6" name="d6" min="0" max="10" value="0"><br>

        <label for="d8">D8</label>

        <input type="number" id="d8" name="d8" min="0" max="10" value="0"><br>

        <label for="d10">D10</label>

        <input type="number" id="d10" name="d10" min="0" max="10" value="0"><br>
        <label for="d12">D12</label>

        <input type="number" id="d12" name="d12" min="0" max="10" value="0"><br>

        <label for="d20">D20</label>

        <input type="number" id="d20" name="d20" min="0" max="10" value="0"><br>

        <label for="d100">D100</label>

        <input type="number" id="d100" name="d100" min="0" max="10" value="0"><br>

        <label for="user_number">Ajouter un nombre</label>
        <input type="number" name="user_number" id="user_number">

        <input type="submit" value="Valider">
    </form>


</body>

</html>


<?php

// Nous avons pas su régler une erreur qui n'empéche pas le bon fonctionnement du code 
error_reporting(0);


// Je vérifie si au moins un champs input est remplis
if (isset($_POST["d2"]) || isset($_POST["d4"]) || isset($_POST["d6"]) || isset($_POST["d8"]) || isset($_POST["d10"]) || isset($_POST["d12"]) || isset($_POST["d20"]) || isset($_POST["d100"])) {



    // Création de plusieurs tableaux pour stocker les valeurs retourné au nombre de lancer 
    $dice = $_POST;
    $tabd2 = [];
    $tabd4 = [];
    $tabd6 = [];
    $tabd8 = [];
    $tabd10 = [];
    $tabd12 = [];
    $tabd20 = [];
    $tabd100 = [];


    // On parcours tout les requêtes POST du formulaire
    foreach ($dice as $key => $value) {

        // Si la valeur est supérieur à 0 alors on affiche les informations
        if ($value > 0) {


            // je recupère le nombre de face en fonction du nom du champ input
            $typeDes = substr($key, 1);

            // Je parcours les valeurs (cela représente le nombre de lancés de chaque dés)
            // Je créer une boucle for pour intégrer les bon nombre de resultats de chaque lancé de dés
            for ($i = 1; $i <= $value; $i++) {

                // $tabes vas ajoutés "tabd" sur chaque tableau pour ainsi récupérer le bon tableau
                $tabDes = "tabd" . $typeDes;
                $table = &$$tabDes;
                // On Push les resultat dans le tableau voulu avec des nombre aléatoire entre 1 et $typesDes
                array_push($table, rand(1, $typeDes));
            }
        }
    }


    // On Affiche les résultats
    echo "d2: " . implode(",", $tabd2) . "<br>";
    echo "d4: " . implode(",", $tabd4) . "<br>";
    echo "d6: " . implode(",", $tabd6) . "<br>";
    echo "d8: " . implode(",", $tabd8) . "<br>";
    echo "d10: " . implode(",", $tabd10) . "<br>";
    echo "d12: " . implode(",", $tabd12) . "<br>";
    echo "d20: " . implode(",", $tabd20) . "<br>";
    echo "d100: " . implode(",", $tabd100) . "<br>";

    // On récupère le total des valeirs de chaques tableaux
    $totald2 = array_sum($tabd2);
    $totald4 = array_sum($tabd4);
    $totald6 = array_sum($tabd6);
    $totald8 = array_sum($tabd8);
    $totald10 = array_sum($tabd10);
    $totald12 = array_sum($tabd12);
    $totald20 = array_sum($tabd20);
    $totald100 = array_sum($tabd100);


    // On additionne toutes les valeurs de chaque tableaux 
    $b = array("a" => $totald2, "b" => $totald4, "c" => $totald6, "d" => $totald8, "e" => $totald10, "f" => $totald12, "g" => $totald20, "h" => $totald100);
    $total = array_sum($b);

    // On Affiche le résultat
    $resultat = $total + $_POST["user_number"];
    echo $hours;
    printf($name . " a eu ");
    echo $resultat . "points";



    // On Insert les résultat dans la table intégré à la bdd WP 
    $wpdb->insert(
        $wpdb->prefix . 'dice',
        array(
            'dice_user' => $name, // On intègre le pseudo de l'utilisateur 
            'dice_result' => $resultat // On intègre le resultat
        ),
        array(
            '%s', // intègre le type de données au champ de la table ici on ajoute une chaine de caractère
            '%d' // intègre le type de données au champ de la table ici on ajoute un entier
        )
    );
    showALL(); // Appel de la fonction qui récupère tous les 500 derniers resultats
    install();
}

// On insère la table à la bdd quand l'utilisateur valide sont lancer
function install(){
    global $wpdb;
    $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}dice (dice_id INT AUTO_INCREMENT PRIMARY KEY, dice_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP, dice_result int(100) NOT NULL, dice_user VARCHAR(255) NOT NULL);");
}

function showALL()
{
    // Requêtes Sql qui me permet de selectionner les 500 derniers resultats
    global $wpdb;
    // get_results renvois le resultats d'une table WP
    $showResult = $wpdb->get_results("SELECT * FROM `{$wpdb->prefix}dice` ORDER BY `dice_id` DESC LIMIT 500");
?>
    <!-- Création d'un tableau qui affichera les 500 derniers résultats -->
    <table>
        <thead>
            <tr>
                <th colspan="2">Score Joueurs</th>
            </tr>
        </thead>
        <tbody>


        <?php

        // Utilisation d'un forEach pour parcourir le tableau renvoyé par la requête SQL
        foreach ($showResult as $values) {
            echo "<tr><th>" . $values->dice_user . "</th>";
            echo "<th>" . $values->dice_result . "</th>";
            echo "<th>" . $values->dice_date . "</th></tr>";
        }
    }

        ?>


        </tbody>
    </table>