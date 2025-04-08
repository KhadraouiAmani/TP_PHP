<?php
class Section {
    private $conn;

    // Constructeur
    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Méthode pour récupérer toutes les sections
    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM sections");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour récupérer une section par son ID
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM sections WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Méthode pour ajouter une section
    public function create($designation, $description) {
        $stmt = $this->conn->prepare("INSERT INTO sections (designation, description) VALUES (:designation, :description)");
        $stmt->execute([':designation' => $designation, ':description' => $description]);
    }

    // Méthode pour mettre à jour une section
    public function update($id, $designation, $description) {
        $stmt = $this->conn->prepare("UPDATE sections SET designation = :designation, description = :description WHERE id = :id");
        $stmt->execute([':designation' => $designation, ':description' => $description, ':id' => $id]);
    }

    // Méthode pour supprimer une section
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM sections WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }

    // Méthode pour récupérer les étudiants d'une section
    public function getStudentsBySection($section_id) {
        $stmt = $this->conn->prepare("SELECT students.id, students.name, students.birthday, students.image 
                                      FROM students 
                                      WHERE students.section_id = :section_id");
        $stmt->execute([':section_id' => $section_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
