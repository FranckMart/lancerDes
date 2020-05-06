<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
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
/*
interface ModulesDes_widget_interface
{
    // cette méthode construit le widget. Elle devra faire appel au constructeur de la classe parent et accrochera au crochet wp_head le css défini dans la fonction css 
    // afin de pouvoir lister les 500 derniers jets j'ai décidé de créer un shortcode défini par la fonction liste_jets et accroché avec le shortcode liste_jets grâce à la fonction add_shortcode
    public function __construct();

    // la fonction form permet de créer le formulaire de paramétrage du widget
    // ici j'ai 2 paramètres : le nom du widget et la liste des dés que l'on peut lancer
	public function form($instance);

	// Fonction définissant un peu de css
	public function css(); 

	// Cette fonction contient le corps du module, c'est en appelant cette méthode qu'on affiche le widget
    public function widget($args, $instance);

    // Cette methode me permet de créer la table qui stockera tous les jets réalisés
    public static function install();

    // Cette méthode supprime la table de stockage des jets
	public static function uninstall();

	// Cette fonction me permet de renvoyer un tableau contenant $nb nombres compris entre 0 et $max
	public static function alea($max, $nb);

	// C'est dans cette fonction que je détermine le comportement de mon shortcode
	public static function liste_jets($atts, $content);

	// C'est dans cette methode que je vais stocker les éléments des jets
    public static function traitement();
}
*/

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

    function addUserNumber()
    {
        if (isset($_POST["user_number"])) {
            //Ajoute le nombre au résultat
        }
    }



    foreach ($_POST as $key => $value) {

        if ($value > 0) {
            //echo $value.$key."<br>";
            # code...
            // Tu rajoutes une fonction pour rajouter un nombre ton dernier champ input
            $typeDes = substr($key, 1); // je recupère le nombre de face en fonction du nom du champ input


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
    $totalOK = array_sum($b);
    echo $totalOK + $_POST["user_number"];
}
