<?php
class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
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
