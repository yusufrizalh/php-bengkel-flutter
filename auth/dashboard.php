<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login_form.php');
    exit;
} else {
?>
    <?php include '../includes/header.php'; ?>

    <section class="hero mt-3">
        <center>
            <h2>Teknologi Mobile Terkini</h2>
            <p>Update terbaru seputar Flutter, React Native, dan Framework Mobile Lainnya</p>
        </center>
    </section>

    <section class="container-fluid">
        <?php if (isset($_SESSION['loggedin'])): ?>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header bg-danger">
                            <h3 class="fw-bold text-white">
                                Admin Dashboard
                            </h3>
                        </div>
                        <div class="card-body">
                            <span">
                                <img src="<?php echo $_SESSION['photo']; ?>" alt="profile-pic" class="img-fluid img-thumbnail rounded-circle mx-auto d-block" style="width: 250px; height: 250px">
                                </span>
                                <p><b>Name:</b> <?= $_SESSION['name']; ?></p>
                                <p><b>Email:</b> <?= $_SESSION['email']; ?></p>
                                <p><b>Address:</b> <?= $_SESSION['address']; ?></p>
                                <p><b>Phone:</b> <?= $_SESSION['phone']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </section>

    <?php include '../includes/footer.php'; ?>
<?php
}
?>