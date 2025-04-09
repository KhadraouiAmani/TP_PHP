<?php
require_once 'Repository.php';
class SectionClassRepo {
    private $conn;
    private Repository $repo;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
        $this->repo = new Repository($dbConnection, 'sections');
    }

    // Utilise repository
    public function getAll() {
        return $this->repo->findAll();
    }


    public function getById($id) {
        return $this->repo->findById($id);
    }


    public function create($designation, $description) {
        return $this->repo->create([
            'designation' => $designation,
            'description' => $description
        ]);
    }


    public function delete($id) {
        return $this->repo->delete($id);
    }
}

?>
