<?php
// include '../config/header.php';
include '../../config/koneksi.php';

$response = ['success' => false, 'message' => ''];
$errors = [];

try {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data) {
        $data = $_POST;
    }

    //* name validation
    if (empty($data['name'])) {
        $errors[] = 'Name cannot be empty!';
        $response['message'] = 'Name cannot be empty!';
    } elseif (strlen(trim($data['name'])) < 8) {
        $errors[] = 'Name at least 8 characters!';
        $response['message'] = 'Name at least 8 characters!';
    } else if (strlen(trim($data['name'])) > 100) {
        $errors[] = 'Name cannot be more than 100 characters!';
        $response['message'] = 'Name cannot be more than 100 characters!';
    } else {
        $data['name'] = htmlspecialchars($data['name'], ENT_QUOTES, 'UTF-8');
    }

    //* email validation
    if (empty($data['email'])) {
        $errors[] = 'Email cannot be empty!';
        $response['message'] = 'Email cannot be empty!';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format!';
        $response['message'] = 'Invalid email format';
    } else {
        $data['email'] = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
    }

    //* password validation
    if (empty($data['password'])) {
        $errors[] = 'Password cannot be empty!';
        $response['message'] = 'Password cannot be empty!';
    } elseif (strlen($data['password']) < 8) {
        $errors[] = 'Password at least 8 characters!';
        $response['message'] = 'Password at least 8 characters!';
    } elseif (!preg_match('/[A-Z]/', $data['password'])) {
        $errors[] = 'Password must contain at least 1 uppercase letter!';
        $response['message'] = 'Password must contain at least 1 uppercase letter!';
    } elseif (!preg_match('/[a-z]/', $data['password'])) {
        $errors[] = 'Password must contain at least 1 lowercase letter!';
        $response['message'] = 'Password must contain at least 1 lowercase letter!';
    } elseif (!preg_match('/[0-9]/', $data['password'])) {
        $errors[] = 'Password must contain at least 1 number!';
        $response['message'] = 'Password must contain at least 1 number!';
    } elseif (!preg_match('/[@$!%*#?&]/', $data['password'])) {
        $errors[] = 'Password must contain at least 1 special character!';
        $response['message'] = 'Password must contain at least 1 special character!';
    } else {
        $data['password'] = htmlspecialchars($data['password'], ENT_QUOTES, 'UTF-8');
    }

    //* if no errors then process to database
    if (empty($errors)) {
        $checkUser = "SELECT id FROM users WHERE email = :email";
        $stmtCheckUser = $conn->prepare($checkUser);
        $stmtCheckUser->bindParam(':email', $data['email']);
        $stmtCheckUser->execute();

        if ($stmtCheckUser->rowCount() > 0) {
            $response['message'] = 'Email already exists!';
        } else {
            $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

            $sql = "INSERT INTO users(name, email, password, address, phone, role) 
            VALUES (:name, :email, :password, :address, :phone, :role)";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':address', $data['address']);
            $stmt->bindParam(':phone', $data['phone']);
            $stmt->bindParam(':role', $data['role']);
            $stmt->execute();

            $token = bin2hex(random_bytes(16));

            $rowCount = $stmt->rowCount();
            if ($rowCount > 0) {
                $lastId = $conn->lastInsertId();
                $response = [
                    'success' => true,
                    'message' => 'Registration successful!',
                    'id' => $lastId,
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'address' => $data['address'],
                    'phone' => $data['phone'],
                    'role' => $data['role'],
                    'token' => $token,
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Registration failed!',
                    'id' => '',
                    'name' => '',
                    'email' => '',
                    'address' => '',
                    'phone' => '',
                    'role' => '',
                    'token' => '',
                ];
            }
        }
    } else {
        $response = [
            'success' => false,
            'message' => implode(', ', $errors),
        ];
    }
} catch (PDOException $e) {
    $response['message'] = $e->getMessage();
} finally {
    $conn = null;
}

//* only for development purpose
echo json_encode($response);
