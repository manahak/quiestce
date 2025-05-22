<?php
$perso = [
    "Alice"     => "10000",
    "Bob"       => "01001",
    "Charlie"   => "00110",
    "Diana"     => "11000",
    "Eve"       => "10011",
    "Frank"     => "01110",
    "Grace"     => "10100",
    "Henry"     => "11110",
    "Ivy"       => "00001",
    "Jack"      => "00101",
    "Karen"     => "01100",
    "Leo"       => "00010",
    "Mona"      => "11011",
    "Nick"      => "10111",
    "Olive"     => "11101",
    "Paul"      => "01010"
];

$questions = [
    "Porte-t-il un chapeau ?" => 0,
    "A-t-il des cheveux ?" => 1,
    "Porte-t-il des lunettes ?" => 2,
    "A-t-il une barbe ?" => 3,
    "A-t-il une moustache ?" => 4,
];

$rep_finale = "";
$mensonge = 0;
$resultat_visible = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chapeau   = $_POST['q0'] === 'oui' ? '1' : '0';
    $cheveux   = $_POST['q1'] === 'oui' ? '1' : '0';
    $lunettes  = $_POST['q2'] === 'oui' ? '1' : '0';
    $barbe     = $_POST['q3'] === 'oui' ? '1' : '0';
    $moustache = $_POST['q4'] === 'oui' ? '1' : '0';

    $reponses = [$chapeau, $cheveux, $lunettes, $barbe, $moustache];


    // cherche perso le plus proche
    $meilleur_match = "";
    $min_diff = 5;

    foreach ($perso as $name => $code) { //name = les noms des perso ; code = les numéros d'identification de chaque perso
        $differences = 0;
        for ($i = 0; $i < 5; $i++) {
            if ($reponses[$i] !== $code[$i]) {
                $differences = $differences + 1;
            }
        }
        if ($differences < $min_diff) {
            $min_diff = $differences;
            $meilleur_match = $name;
        }
    }

    $rep_finale = $meilleur_match;
    $mensonge = $min_diff;
    $resultat_visible = true;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    
    <meta charset="UTF-8">
    <title>Qui est-ce ?</title>

    <style>
        body { font-family: Arial, sans-serif; padding: 50px; max-width: 600px; margin: auto; }
        h1 { margin-bottom: 10px; }
        label { display: block; margin: 10px 0 5px; }
        select { padding: 5px; }
        button { padding: 10px 50px; margin-top: 15px; }
        .result { margin-top: 20px; padding: 15px; border-radius: 5px; }

    </style>

</head>
<body>

    <h1>Qui est-ce ?</h1>
    <p>Choisissez un personnage et répondez aux questions;</p>

    <div class="images">
        <img src="https://raw.githubusercontent.com/manahak/quiestce/refs/heads/main/1000007595.jpg" width="40%" alt="Image 1">
        <img src="https://raw.githubusercontent.com/manahak/quiestce/refs/heads/main/1000007594.jpg" width="40%" alt="Image 2">
    </div>


    <form method="post">
        <?php foreach ($questions as $question => $index): ?>
            <label><?= htmlspecialchars($question) ?></label>
            <select name="q<?= $index ?>" required>

                <option value="">Choisir</option>
                <option value="oui" <?= (isset($_POST["q$index"]) && $_POST["q$index"] === "oui") ? 'selected' : '' ?>>Oui</option>
                <option value="non" <?= (isset($_POST["q$index"]) && $_POST["q$index"] === "non") ? 'selected' : '' ?>>Non</option>

            </select>
        <?php endforeach; ?>

            <br>
        <button type="submit">Deviner</button>

    </form>

    <?php if ($resultat_visible): ?>
        <div class="result">
            <h2>Le personnage est <?= htmlspecialchars($rep_finale) ?></h2>
            <p>Vous avez menti <strong><?= $mensonge ?></strong> fois.</p>
        </div>
    <?php endif; ?>

</body>
</html>
