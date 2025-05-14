<?php
session_start();
require "../../../../../core/adminAuth.php";
require "../../../../../controllers/AdminController.php";

$controller = new AdminController($_SESSION['institution']['database_name']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $staffData = [
        'role_id' => $_POST['role_id'],
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'designation' => $_POST['designation'],
        // 'father_name' => $_POST['father_name'],
        // 'mother_name' => $_POST['mother_name'],
        'email' => $_POST['email'],
        'gender' => $_POST['gender'] ?? 'Other',
        // 'date_of_birth' => $_POST['date_of_birth'],
        // 'date_of_joining' => $_POST['date_of_joining'],
        'mobile_number' => $_POST['mobile_number'],
        // 'emergency_mobile' => $_POST['emergency_mobile'],
        // 'staff_photo' => $_POST['staff_photo'], // or handle file upload
        // 'driving_license' => $_POST['driving_license'],
        // 'current_address' => $_POST['current_address'],
        // 'permanent_address' => $_POST['permanent_address'],
        // 'qualifications' => $_POST['qualifications'],
        // 'experience' => $_POST['experience'],
        // 'epf_number' => $_POST['epf_number'],
        // 'basic_salary' => $_POST['basic_salary'],
        // 'bank_account_name' => $_POST['bank_account_name'],
        // 'bank_account_number' => $_POST['bank_account_number'],
        // 'bank_name' => $_POST['bank_name'],
        // 'branch_name' => $_POST['branch_name'],
        // 'facbook_url' => $_POST['facbook_url'],
        // 'twitter_url' => $_POST['twitter_url'],
        // 'linkedin_url' => $_POST['linkedin_url'],
        // 'instagram_url' => $_POST['instagram_url'],
        // 'resume' => $_POST['resume'], // or handle file upload
        // 'joining_letter' => $_POST['joining_letter'], // or handle file upload
        // 'other_documents' => $_POST['other_documents'], // or handle file upload
        // 'department' => $_POST['department'] ?? null  // Only required for teachers
    ];
    $result = $controller->addStaff($staffData);
    print_r($result);

    if ($result['success']) {
        echo "Staff added successfully with ID: " . $result['staff_id'];
    } else {
        echo "Error: " . $result['error'];
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Staff</title>
    <style>
        .teacher-fields {
            display: none;
        }
    </style>
</head>

<body>
    <h2>Add Staff Member</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <label>Role:
            <select name="role_id" id="role_id" onchange="toggleTeacherFields()" required>
                <option value="">--Select--</option>
                <option value="1">Admin</option>
                <option value="2">Teacher</option>
                <option value="3">Accountant</option>
                <!-- Add more roles as needed -->
            </select>
        </label><br><br>

        <!-- Teacher-specific fields -->
        <div id="teacherFields" class="teacher-fields">
            <label>Department: <input type="text" name="department"></label><br><br>
        </div>

        <label>Designation: <input type="text" name="designation" required></label><br><br>

        <label>First Name: <input type="text" name="first_name" required></label><br><br>
        <label>Last Name: <input type="text" name="last_name" required></label><br><br>


        <label>Email: <input type="email" name="email" required></label><br><br>

        <!-- 
                <label>Father's Name: <input type="text" name="father_name"></label><br><br>
        <label>Mother's Name: <input type="text" name="mother_name"></label><br><br> -->

        <label>Gender:
            <select name="gender">
                <option value="Other">Other</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </label><br><br>

        <!-- <label>Date of Birth: <input type="date" name="date_of_birth"></label><br><br>
        <label>Date of Joining: <input type="date" name="date_of_joining"></label><br><br> -->

        <label>Mobile: <input type="text" name="mobile_number"></label><br><br>

        <!-- <label>Emergency Mobile: <input type="text" name="emergency_mobile"></label><br><br>

        <label>Photo: <input type="file" name="staff_photo"></label><br><br>
        <label>Driving License: <input type="text" name="driving_license"></label><br><br>

        <label>Current Address:<br><textarea name="current_address"></textarea></label><br><br>
        <label>Permanent Address:<br><textarea name="permanent_address"></textarea></label><br><br>

        <label>Qualifications: <input type="text" name="qualifications"></label><br><br>
        <label>Experience (in years): <input type="number" name="experience"></label><br><br>

        <label>EPF Number: <input type="text" name="epf_number"></label><br><br>
        <label>Basic Salary: <input type="number" step="0.01" name="basic_salary"></label><br><br>

        <label>Bank Account Name: <input type="text" name="bank_account_name"></label><br><br>
        <label>Bank Account Number: <input type="text" name="bank_account_number"></label><br><br>
        <label>Bank Name: <input type="text" name="bank_name"></label><br><br>
        <label>Branch Name: <input type="text" name="branch_name"></label><br><br>

        <label>Facebook URL: <input type="url" name="facbook_url"></label><br><br>
        <label>Twitter URL: <input type="url" name="twitter_url"></label><br><br>
        <label>LinkedIn URL: <input type="url" name="linkedin_url"></label><br><br>
        <label>Instagram URL: <input type="url" name="instagram_url"></label><br><br>

        <label>Resume: <input type="file" name="resume"></label><br><br>
        <label>Joining Letter: <input type="file" name="joining_letter"></label><br><br>
        <label>Other Documents: <input type="file" name="other_documents"></label><br><br>
    -->
        <input type="submit" value="Add Staff">
    </form>

    <script>
        function toggleTeacherFields() {
            const roleSelect = document.getElementById("role_id");
            const teacherFields = document.getElementById("teacherFields");

            // Assuming '2' is the Teacher role_id
            if (roleSelect.value === "2") {
                teacherFields.style.display = "block";
            } else {
                teacherFields.style.display = "none";
            }
        }
    </script>
</body>

</html>