<?php

require_once __DIR__ . '/../config/connectInstitutionDb.php';

class AdminController
{
    private $db;

    public function __construct($institutionDbName)
    {
        $this->db = connectToInstitutionDB($institutionDbName);
    }

    // Get dashboard data
    public function getDashboardData()
    {
        // Example: count users, teachers, students
        $stmt = $this->db->query("SELECT COUNT(*) as total_users FROM users");
        $users = $stmt->fetch(PDO::FETCH_ASSOC);

        return [
            'total_users' => $users['total_users']
        ];
    }

    // Example: get current admin profile
    public function getProfile($adminId)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$adminId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Example: update admin profile
    public function updateProfile($adminId, $name, $email)
    {
        $stmt = $this->db->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        return $stmt->execute([$name, $email, $adminId]);
    }
}
