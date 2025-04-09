<?php

class Section {
    private $conn;
    

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    
    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM sections");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } 

    
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM sections WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } 


    public function searchByName($name) {
        $stmt = $this->conn->prepare("SELECT * FROM sections WHERE designation LIKE :name");
        $stmt->execute([':name' => '%' . $name . '%']); // Ajoutez '%' pour une recherche partielle
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourne TOUS les résultats
    }

    
    public function create($designation, $description) {
        $stmt = $this->conn->prepare("INSERT INTO sections (designation, description) VALUES (:designation, :description)");
        $stmt->execute([':designation' => $designation, ':description' => $description]);
    } 

    
    public function update($id, $designation, $description) {
        $stmt = $this->conn->prepare("UPDATE sections SET designation = :designation, description = :description WHERE id = :id");
        $stmt->execute([':designation' => $designation, ':description' => $description, ':id' => $id]);
    }

    
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM sections WHERE id = :id");
        $stmt->execute([':id' => $id]);
    } 



    public function getStudentsBySection($section_id) {
        $stmt = $this->conn->prepare("SELECT students.id, students.name, students.birthday, students.image 
                                      FROM students 
                                      WHERE students.section_id = :section_id");
        $stmt->execute([':section_id' => $section_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}


?>
