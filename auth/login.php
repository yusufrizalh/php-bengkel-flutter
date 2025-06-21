<?php
include '../config/header.php';
include '../config/koneksi.php';

$response = ['success' => false, 'message' => ''];

try {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data) {
        $data = $_POST;
    }

    if (empty($data['email']) || empty($data['password'])) {
        $response['message'] = 'All fields are required!';
    }

    $checkUser = "SELECT id, name, email, password FROM users WHERE email = :email";
    $stmtCheckUser = $conn->prepare($checkUser);
    $stmtCheckUser->bindParam(':email', $data['email'], PDO::PARAM_STR);
    $stmtCheckUser->execute();

    $user = $stmtCheckUser->fetch(PDO::FETCH_ASSOC);

    if ($user) {
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
                'token' => $token,
            ];

            session_start();
            $_SESSION['id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];

            session_regenerate_id(true);

            //* redirect to dashboard
        }
    } else {
        $response['message'] = 'Email not found!';
    }
} catch (PDOException $e) {
    $response['message'] = $e->getMessage();
} finally {
    $conn = null;
}

echo json_encode($response);
