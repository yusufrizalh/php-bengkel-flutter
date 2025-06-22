<?php
// include '../config/header.php';
include '../config/koneksi.php';

$response = ['success' => false, 'message' => ''];
$errors = [];

try {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data) {
        $data = $_POST;
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
        $checkUser = "SELECT * FROM users WHERE email = :email";
        $stmtCheckUser = $conn->prepare($checkUser);
        $stmtCheckUser->bindParam(':email', $data['email'], PDO::PARAM_STR);
        $stmtCheckUser->execute();

        $user = $stmtCheckUser->fetch(PDO::FETCH_ASSOC);
        $rowCount = $stmtCheckUser->rowCount();

        if ($rowCount > 0) {
            if (!password_verify($data['password'], $user['password'])) {
                $response['message'] = 'Invalid password!';
            } else {
                $token = bin2hex(random_bytes(16));
                $response = [
                    'success' => true,
                    'message' => 'Login successful!',
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'address' => $user['address'],
                    'phone' => $user['phone'],
                    'photo' => $user['photo'],
                    'token' => $token,
                ];

                session_start();
                $_SESSION['id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['address'] = $user['address'];
                $_SESSION['phone'] = $user['phone'];
                $_SESSION['photo'] = $user['photo'];
                $_SESSION['token'] = $token;
                $_SESSION['loggedin'] = true;

                session_regenerate_id(true);

                //* redirect to dashboard
                header('Location: dashboard.php');
                exit();
            }
        } else {
            $response['message'] = 'Email not found!';
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
// echo json_encode($response);
