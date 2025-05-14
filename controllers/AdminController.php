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

            // Check if the email already exists
            $emailCheckStmt = $this->db->prepare("SELECT COUNT(*) FROM staff WHERE email = ?");
            $emailCheckStmt->execute([$staffData['email']]);
            $emailExists = $emailCheckStmt->fetchColumn();

            if ($emailExists > 0) {
                // Rollback transaction and return error if email exists
                $this->db->rollBack();
                return ['success' => false, 'error' => 'Email already exists.'];
            }

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
                email, password, gender, mobile_number
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

            $stmt->execute([
                $staffData['role_id'],
                $staffData['first_name'],
                $staffData['last_name'],
                $staffData['designation'],
                $staffData['department'] ?? null,
                $staffData['email'],
                $defaultPassword,
                $staffData['gender'],
                $staffData['mobile_number']
            ]);

            //     $stmt->execute([

            //     ]);

            $staffId = $this->db->lastInsertId();

            $this->db->commit();

            return ['success' => true, 'staff_id' => $staffId];
        } catch (Exception $e) {
            $this->db->rollBack();
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function saveCategory($name)
    {
        try {
            $this->db->beginTransaction();
            $stmt = $this->db->prepare("
                INSERT INTO book_categories (
                    name
                ) VALUES (
                    :name
                )
            ");

            $stmt->execute(['name' => $name]);
            $this->db->commit();
            return ['success' => true, 'category_id' => $this->db->lastInsertId()];
        } catch (Exception $e) {
            $this->db->rollBack();
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function saveBook($bookData)
    {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("
            INSERT INTO book (
                title, category_id, subject_id, book_no,
                isbn, publisher, author, rack_no, quantity, price, description
            ) VALUES (
                :title, :category_id, :subject_id, :book_no,
                :isbn, :publisher, :author, :rack_no, :quantity, :price, :description
            )
        ");

            $stmt->execute([
                'title' => $bookData['title'],
                'category_id' => $bookData['category_id'],
                'subject_id' => $bookData['subject_id'],
                'book_no' => $bookData['book_no'],
                'isbn' => $bookData['isbn'] ?? null,
                'publisher' => $bookData['publisher'] ?? null,
                'author' => $bookData['author'] ?? null,
                'rack_no' => $bookData['rack_no'] ?? null,
                'quantity' => $bookData['quantity'],
                'price' => $bookData['price'] ?? null,
                'description' => $bookData['description'] ?? null
            ]);

            $this->db->commit();

            return ['success' => true, 'book_id' => $this->db->lastInsertId()];
        } catch (Exception $e) {
            $this->db->rollBack();
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function getTeachers()
    {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM staff WHERE role_id = 2");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->db->commit();

            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            $this->db->rollBack();
            // Optional: log the error or handle it as needed
            return 0;
        }
    }


    public function addMember($memberData)
    {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("
            INSERT INTO libraryMembers (
                memberType, memberEmail
            ) VALUES (
                :type, :email
            )
        ");

            $stmt->execute([
                'type' => $memberData['memberType'],
                'email' => $memberData['memberEmail']
            ]);

            $this->db->commit();

            return ['success' => true, 'member_id' => $this->db->lastInsertId()];
        } catch (Exception $e) {
            $this->db->rollBack();
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
