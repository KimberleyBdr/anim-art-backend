<?php
class User {
    private $conn;
    private $table_name = "users";

    // Propriétés de l'utilisateur
    public $id;
    public $username;
    public $email;
    public $password;
    public $created_at;

    // Constructeur
    public function __construct($db) {
        $this->conn = $db;
    }

    // Méthode pour créer un utilisateur
    public function create() {
        // Requête SQL pour insérer un nouvel utilisateur
        $query = "INSERT INTO " . $this->table_name . " SET username=:username, email=:email, password=:password, created_at=:created_at";

        // Préparation de la requête
        $stmt = $this->conn->prepare($query);

        // Nettoyage des données
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->created_at = htmlspecialchars(strip_tags($this->created_at));

        // Liaison des paramètres
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":created_at", $this->created_at);

        // Exécution de la requête
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Méthode pour lire tous les utilisateurs
    public function readAll() {
        // Requête SQL pour sélectionner tous les utilisateurs
        $query = "SELECT id, username, email, created_at FROM " . $this->table_name;

        // Préparation de la requête
        $stmt = $this->conn->prepare($query);

        // Exécution de la requête
        $stmt->execute();

        return $stmt;
    }

    // Méthode pour trouver un utilisateur par email
    public function findByEmail($email) {
        // Requête SQL pour sélectionner un utilisateur par email
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email LIMIT 0,1";

        // Préparation de la requête
        $stmt = $this->conn->prepare($query);

        // Liaison du paramètre email
        $stmt->bindParam(':email', $email);

        // Exécution de la requête
        $stmt->execute();

        // Retourner le résultat sous forme de tableau associatif
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
