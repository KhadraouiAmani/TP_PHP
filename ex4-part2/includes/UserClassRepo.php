<?php
require_once 'Repository.php';
class UserClassRepo {
    private $conn;
    private Repository $repo;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
        $this->repo = new Repository($dbConnection, 'users');
    }

    
    public function getAll() {
        return $this->repo->findAll();
    }


    public function getById($id) {
        return $this->repo->findById($id);
    }


    public function create($username, $email, $role) {
        return $this->repo->create([
            'username' => $username,
            'email' => $email, 
            'role' => $role
        ]);
    }


    public function delete($id) {
        return $this->repo->delete($id);
    }
}

?>
