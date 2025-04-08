<?php
class Student {
    private $conn;

    // Constructeur
    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Méthode pour récupérer tous les étudiants
    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM students");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour récupérer un étudiant par son ID
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM students WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Méthode pour ajouter un étudiant
    public function create($name, $birthday, $image, $section_id) {
        $stmt = $this->conn->prepare("INSERT INTO students (name, birthday, image, section_id) VALUES (:name, :birthday, :image, :section_id)");
        $stmt->execute([':name' => $name, ':birthday' => $birthday, ':image' => $image, ':section_id' => $section_id]);
    }

    // Méthode pour mettre à jour un étudiant
    public function update($id, $name, $birthday, $image, $section_id) {
        $stmt = $this->conn->prepare("UPDATE students SET name = :name, birthday = :birthday, image = :image, section_id = :section_id WHERE id = :id");
        $stmt->execute([':name' => $name, ':birthday' => $birthday, ':image' => $image, ':section_id' => $section_id, ':id' => $id]);
    }

    // Méthode pour supprimer un étudiant
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM students WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }

    public function getAllWithPagination($limit, $offset) {
        $stmt = $this->conn->prepare("SELECT students.*, sections.designation FROM students
                                      INNER JOIN sections ON students.section_id = sections.id
                                      LIMIT :limit OFFSET :offset");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getTotalStudents() {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM students");
        return $stmt->fetchColumn();
    }

        // Méthode pour récupérer les étudiants par ID de section
    public function getBySectionId($sectionId) {
        $stmt = $this->conn->prepare("SELECT * FROM students WHERE section_id = :section_id");
        $stmt->execute([':section_id' => $sectionId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    


}
?>
