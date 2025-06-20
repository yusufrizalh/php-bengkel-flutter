<?php
// session_start();
// if (!isset($_SESSION['loggedin'])) {
//     header('Location: ../login.php');
//     exit;
// }

include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'];
    $author_id = $_SESSION['user_id'];

    $sql = "INSERT INTO articles (title, content, category_id, author_id) 
            VALUES (:title, :content, :category_id, :author_id)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':category_id', $category_id);
    $stmt->bindParam(':author_id', $author_id);

    if ($stmt->execute()) {
        header('Location: ../admin.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!-- Form untuk membuat artikel -->