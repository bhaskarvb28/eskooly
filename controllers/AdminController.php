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
    // public function getDashboardData()
    // {
    //     // Example: count users, teachers, students
    //     $stmt = $this->db->query("SELECT COUNT(*) as total_users FROM users");
    //     $users = $stmt->fetch(PDO::FETCH_ASSOC);

    //     return [
    //         'total_users' => $users['total_users']
    //     ];
    // }

    // Example: get current admin profile
    public function getProfile(/*$adminId*/)
    {
        // $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt = $this->db->prepare("SELECT * FROM root_user");
        $stmt->execute(/*[$adminId]*/);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Example: update admin profile
    public function updateProfile($adminId, $name, $email)
    {
        $stmt = $this->db->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        return $stmt->execute([$name, $email, $adminId]);
    }

    public function addStaff($staffData)
    {
        // echo '<pre>';
        // print_r($staffData);
        // echo '</pre>';



        try {
            //     //     // Begin transaction
            $this->db->beginTransaction();

            //     //     // Insert into staff table
            //     //     $staffSql = "INSERT INTO staff (
            //     //     role_id, first_name, last_name, designation, 
            //     //     father_name, mother_name, email, gender,
            //     //     date_of_birth, date_of_joining, mobile, emergency_mobile,
            //     //     staff_photo, driving_license, current_address, permanent_address,
            //     //     qualifications, experience, epf_number, basic_salary,
            //     //     bank_account_name, bank_account_number, bank_name, branch_name,
            //     //     facbook_url, twitter_url, linkedin_url, instagram_url,
            //     //     resume, joining_letter, other_documents
            //     // ) VALUES (
            //     //     :role_id, :first_name, :last_name, :designation,
            //     //     :father_name, :mother_name, :email, :gender,
            //     //     :date_of_birth, :date_of_joining, :mobile, :emergency_mobile,
            //     //     :staff_photo, :driving_license, :current_address, :permanent_address,
            //     //     :qualifications, :experience, :epf_number, :basic_salary,
            //     //     :bank_account_name, :bank_account_number, :bank_name, :branch_name,
            //     //     :facbook_url, :twitter_url, :linkedin_url, :instagram_url,
            //     //     :resume, :joining_letter, :other_documents
            //     // )";

            $defaultPassword = password_hash('1234', PASSWORD_BCRYPT);

            $stmt = $this->db->prepare("
            INSERT INTO staff (
                role_id, first_name, last_name, designation, department,
                email, password
            ) VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

            $stmt->execute([
                $staffData['role_id'],
                $staffData['first_name'],
                $staffData['last_name'],
                $staffData['designation'],
                $staffData['department'] ?? null,
                $staffData['email'],
                $defaultPassword
            ]);

            //     $stmt->execute([

            //     ]);

            $staffId = $this->db->lastInsertId();

            // If role is teacher (role_id 2) and department is provided
            if ($staffData['role_id'] == 2 && !empty($staffData['department'])) {
                $teacherStmt = $this->db->prepare("
                INSERT INTO teachers (staff_id, department) 
                VALUES (?, ?)
            ");
                $teacherStmt->execute([
                    $staffId,
                    $staffData['department']
                ]);
            }

            $this->db->commit();

            return ['success' => true, 'staff_id' => $staffId];
        } catch (Exception $e) {
            $this->db->rollBack();
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
