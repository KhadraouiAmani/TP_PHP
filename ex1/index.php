<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats des étudiants</title>
    <style>
        .container {
            display: flex;
            gap: 20px;
        }
        .student {
            border: 1px solid #ccc;
            text-align: center;
            border-radius: 5px;
            padding: 10px;
            width: 250px;
            background: #f9f9f9;
        }
        .note {
            padding: 5px;
            text-align: center;
            border-radius: 3px;
            margin: 3px 0;
            font-weight: bold;
        }
        .red { background-color: #f8d7da; }  /* Rouge pour notes < 10 */
        .green { background-color: #d4edda; } /* Vert pour notes > 10 */
        .orange { background-color: #ffeeba; } /* Orange pour notes = 10 */
        .average {
            background-color: #cce5ff;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>

<?php
class Etudiant {
    public $nom;
    public $notes;

    public function __construct($nom, $notes) {
        $this->nom = $nom;
        $this->notes = $notes;
    }

    public function afficherNotes() {
        foreach ($this->notes as $note) {
            $class = ($note < 10) ? "red" : (($note > 10) ? "green" : "orange");
            echo "<div class='note $class'>$note</div>";
        }
    }

    public function calculerMoyenne() {
        return array_sum($this->notes) / count($this->notes);
    }

    public function estAdmis() {
        return $this->calculerMoyenne() >= 10 ? "Admis" : "Non Admis";
    }

    public function afficherResultats() {
        echo "<div class='student'><h3>{$this->nom}</h3>";
        $this->afficherNotes();
        echo "<div class='average'>Votre moyenne est " . round($this->calculerMoyenne(), 2) . "</div>";
        echo "</div>";
    }
}

// Création des étudiants
$etudiant1 = new Etudiant("Aymen", [11, 13, 18, 7, 10, 13, 2, 5, 1]);
$etudiant2 = new Etudiant("Skander", [15, 9, 8, 16]);

echo "<div class='container'>";
$etudiant1->afficherResultats();
$etudiant2->afficherResultats();
echo "</div>";
?>

</body>
</html>