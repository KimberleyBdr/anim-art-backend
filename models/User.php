<?php
class User {
    private $conn;
    private $table_name = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Méthode pour trouver un utilisateur par email
    public function findByEmail($email) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function login($email, $password) {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user) {
            if(password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email']
                ];
                return json_encode(['authenticated' => true, 'user' => $_SESSION['user']]);
            } else {
                return json_encode(['authenticated' => false, 'message' => 'Invalid credentials.']);
            }
        } else {
            return json_encode(['authenticated' => false, 'message' => 'User not found.']);
        }
    }
}
?>

