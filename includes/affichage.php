<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php
    require_once("bdd.php");
    global $wpdp;
    ?>


    <?php

    // Récupère le pseudo de l'utilisateur 
    $current_user = wp_get_current_user();
    $name = esc_html($current_user->user_login);

    $hours =  current_time('mysql') . '<br />';

    ?>


    <h1>Lancer de dés</h1>
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
//error_reporting(0);


// Je vérifie si au moins un champs input est remplis
if (isset($_POST["d2"]) || isset($_POST["d4"]) || isset($_POST["d6"]) || isset($_POST["d8"]) || isset($_POST["d10"]) || isset($_POST["d12"]) || isset($_POST["d20"]) || isset($_POST["d100"])) {



    //$nbLancer = [$_POST["d2"], $_POST["d4"], $_POST["d6"], $_POST["d8"], $_POST["d10"], $_POST["d12"], $_POST["d20"], $_POST["d100"]];


    $dice = $_POST;
    $tabd2 = [];
    $tabd4 = [];
    $tabd6 = [];
    $tabd8 = [];
    $tabd10 = [];
    $tabd12 = [];
    $tabd20 = [];
    $tabd100 = [];


    foreach ($dice as $key => $value) {

        if ($value > 0) {
            //echo $value.$key."<br>";
            # code...
            // Tu rajoutes une fonction pour rajouter un nombre ton dernier champ input
            $typeDes = substr($key, 1); // je recupère le nombre de face en fonction du nom du champ input

            intval($typeDes);

            for ($i = 1; $i <= $value; $i++) {

                $tabDes = "tabd" . $typeDes;
                $table = &$$tabDes;
                array_push($table, rand(1, $typeDes));
            }
        }
    }



    echo "d2: " . implode(",", $tabd2) . "<br>";
    echo "d4: " . implode(",", $tabd4) . "<br>";
    echo "d6: " . implode(",", $tabd6) . "<br>";
    echo "d8: " . implode(",", $tabd8) . "<br>";
    echo "d10: " . implode(",", $tabd10) . "<br>";
    echo "d12: " . implode(",", $tabd12) . "<br>";
    echo "d20: " . implode(",", $tabd20) . "<br>";
    echo "d100: " . implode(",", $tabd100) . "<br>";

    $totald2 = array_sum($tabd2);
    $totald4 = array_sum($tabd4);
    $totald6 = array_sum($tabd6);
    $totald8 = array_sum($tabd8);
    $totald10 = array_sum($tabd10);
    $totald12 = array_sum($tabd12);
    $totald20 = array_sum($tabd20);
    $totald100 = array_sum($tabd100);



    $b = array("a" => $totald2, "b" => $totald4, "c" => $totald6, "d" => $totald8, "e" => $totald10, "f" => $totald12, "g" => $totald20, "h" => $totald100);
    $total = array_sum($b);
    $resultat = $total + $_POST["user_number"];
    echo $hours;
    printf($name . " a eu ");
    echo $resultat . "points";



    // Cette methode me permet de créer la table qui stockera tous les jets réalisés
    function install()
    {

        "CREATE TABLE `dice` (
        `dice_id` int(11) NOT NULL,
        `dice_user` varchar(255) COLLATE utf8mb4_bin NOT NULL,
        `dice_result` int(100) NOT NULL,
        `dice_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin";



        $req = "INSERT INTO `dice`(`dice_user`,`dice_result`) 
            VALUES (:dice_user,:dice_result)";
        $wpdb->insert(
            $wpdb->prefix . 'dice',
            array(
                'dice_user' => $name,
                'dice_result' => $resultat
            ),
            array(
                '%s',
                '%d'
            )
        );

        $reqValue = $GLOBALS['bdd']->prepare($req);

        // Pour question de sécurité la requete est préparé pour éviter une injection SQL 
        // On récupère les informations
        $reqValue->bindValue(":dice_user", $name);
        $reqValue->bindValue(":dice_result", $resultat);


        if ($$reqValue->execute()) {

            // header('Location:../news.php?insertion=réussi');
        } else {
            // header('Location:../news.php?insertion=échec');
        }
    };
    install();
}

// Cette méthode supprime la table de stockage des jets
/*
  function uninstall(){
    "DROP TABLE `dice`";
  };
*/
