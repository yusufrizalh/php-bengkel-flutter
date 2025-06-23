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

  $id = $_GET['id'] ?? null;
  if (!$id) {
    echo "<h1>Invalid user id...</h1>";
    exit;
  }

  $checkUser = "SELECT * FROM users WHERE id = :id";
  $stmtCheckUser = $conn->prepare($checkUser);
  $stmtCheckUser->bindParam(':id', $id);
  $stmtCheckUser->execute();
  $user = $stmtCheckUser->fetch(PDO::FETCH_ASSOC);

  if (!$user) {
    echo "<h1>User not found...</h1>";
    exit;
  } else {
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

    //* address validation
    if (empty($data['address'])) {
      $errors[] = 'Address cannot be empty!';
      $response['message'] = 'Address cannot be empty!';
    } else {
      $data['address'] = htmlspecialchars($data['address'], ENT_QUOTES, 'UTF-8');
    }

    //* phone validation
    if (empty($data['phone'])) {
      $errors[] = 'Phone cannot be empty!';
      $response['message'] = 'Phone cannot be empty!';
    } else {
      $data['phone'] = htmlspecialchars($data['phone'], ENT_QUOTES, 'UTF-8');
    }

    //* role validation
    if (empty($data['role'])) {
      $errors[] = 'Role cannot be empty!';
      $response['message'] = 'Role cannot be empty!';
    } else {
      $data['role'] = htmlspecialchars($data['role'], ENT_QUOTES, 'UTF-8');
    }

    //* check for unique email except for this email
    $sql = "SELECT COUNT(*) FROM users 
            WHERE id != :id AND email = :email 
            GROUP BY email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':email', $data['email']);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_COLUMN);
    if ($stmt->rowCount() > 0) {
      $errors[] = 'Email already exists!';
      $response['message'] = 'Email already exists!';
    }

    function uploadPhoto($file)
    {
      $target_dir = "uploads/";
      $target_file = $target_dir . basename($file["name"]);
      $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

      //* Check if image file is a actual image
      $check = getimagesize($file["tmp_name"]);
      if ($check === false) {
        return ['success' => false, 'message' => 'File is not an image.'];
      }

      //* Check file size (max 6MB)
      if ($file["size"] > 6000000) {
        return ['success' => false, 'message' => 'File is too large (max 6MB).'];
      }

      //* Allow certain file formats
      if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
        return ['success' => false, 'message' => 'Only JPG, JPEG, PNG & GIF files are allowed.'];
      }

      //* Generate unique filename
      $new_filename = uniqid() . '.' . $imageFileType;
      $target_path = $target_dir . $new_filename;

      if (move_uploaded_file($file["tmp_name"], $target_path)) {
        return ['success' => true, 'filename' => $new_filename];
      } else {
        return ['success' => false, 'message' => 'Error uploading file.'];
      }
    }

    function deletePhoto($filename)
    {
      if ($filename && file_exists("uploads/" . $filename)) {
        unlink("uploads/" . $filename);
      }
    }

    $current_photo = $user['photo'];
    $photo = $current_photo;
    if (!empty($_FILES['photo']['name'])) {
      $upload_result = uploadPhoto($_FILES['photo']);
      if ($upload_result['success']) {
        //* Delete old photo
        if ($current_photo) {
          deletePhoto($current_photo);
        }
        $photo = $upload_result['filename'];
      } else {
        $photo_err = $upload_result['message'];
      }
    }

    $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

    //* if no errors then process to database
    if (empty($errors)) {
      $sql = "UPDATE users SET name = :name, email = :email, 
              password = :password, address = :address, 
              phone = :phone, photo = :photo, role = :role 
              WHERE id = :id";
      $stmt = $conn->prepare($sql);

      $stmt->bindParam(':name', $data['name']);
      $stmt->bindParam(':email', $data['email']);
      $stmt->bindParam(':password', $hashedPassword);
      $stmt->bindParam(':address', $data['address']);
      $stmt->bindParam(':phone', $data['phone']);
      $stmt->bindParam(':photo', $photo);
      $stmt->bindParam(':role', $data['role']);
      $stmt->bindParam(':id', $id);
      $stmt->execute();

      $rowCount = $stmt->rowCount();
      if ($rowCount > 0) {
        $token = bin2hex(random_bytes(16));
        $lastId = $conn->lastInsertId();
        $response = [
          'success' => true,
          'message' => 'Update user successful!',
          'id' => $lastId,
          'name' => $data['name'],
          'email' => $data['email'],
          'address' => $data['address'],
          'phone' => $data['phone'],
          'photo' => $photo,
          'role' => $data['role'],
          'token' => $token,
        ];

        // echo "<script> location.href='index.php'; </script>";
        // exit;
      } else {
        //* Delete new photo if success to upload but failed to update 
        if ($photo != $current_photo) {
          deletePhoto($photo);
        }

        $response = [
          'success' => false,
          'message' => 'Edit user failed!',
          'id' => '',
          'name' => '',
          'email' => '',
          'address' => '',
          'phone' => '',
          'photo' => '',
          'role' => '',
          'token' => '',
        ];
        // echo "Failed to edit user!";
        $errors[] = 'Failed to edit user!!';
        $response = [
          'success' => false,
          'message' => implode(', ', $errors),
        ];
        // exit;
      }
    } else {
      $errors[] = 'Edit user failed!';
      $response = [
        'success' => false,
        'message' => implode(', ', $errors),
      ];
    }
  }
} catch (PDOException $e) {
  $response['message'] = $e->getMessage();
} finally {
  $conn = null;
}
//* only for development purpose
// echo json_encode($response);
