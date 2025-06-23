<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login_form.php');
    exit;
}
?>

<?php include '../../includes/header.php'; ?>

<section class="hero mt-3">
    <center>
        <h2>Teknologi Mobile Terkini</h2>
        <p>Update terbaru seputar Flutter, React Native, dan Framework Mobile Lainnya</p>
    </center>
</section>

<section class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <?php
            include '../../config/koneksi.php';
            if (!isset($_GET['name']) || empty($_GET['name'])) {
                echo "<p>Invalid user name...</p>";
                exit;
            } else {
                $name = $_GET['name'];
            }
            $sql = "SELECT * FROM users WHERE name = :name";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="card shadow">
                <div class="card-header bg-danger">
                    <h3 class="fw-bold text-white text-center">
                        User Detail with ID: <?= $user['id']; ?>
                    </h3>
                </div>
                <div class="card-body">
                    <img src="uploads/<?= $user['photo']; ?>" alt="profile-pic" class="img-fluid img-thumbnail rounded-circle mx-auto mb-3 d-block" style="width: 250px; height: 250px">
                    <h5 class="card-title">
                        <b>Name:</b> <?= $user['name']; ?>
                    </h5>
                    <h5 class="card-title">
                        <b>Email:</b> <?= $user['email']; ?>
                    </h5>
                    <h5 class="card-title">
                        <b>Address:</b> <?= $user['address']; ?>
                    </h5>
                    <h5 class="card-title">
                        <b>Phone:</b> <?= $user['phone']; ?>
                    </h5>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include '../../includes/footer.php'; ?>
</body>

</html>