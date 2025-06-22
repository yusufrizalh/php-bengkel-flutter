<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login_form.php');
    exit;
}
?>

<?php include '../../includes/header.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'store.php';
}
?>

<section class="hero mt-3">
    <center>
        <h2>Teknologi Mobile Terkini</h2>
        <p>Update terbaru seputar Flutter, React Native, dan Framework Mobile Lainnya</p>
    </center>
</section>

<section class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-danger text-center">
                    <h3 class="fw-bold text-white">
                        Create New User
                    </h3>
                </div>
                <div class="card-body">
                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-3 form-group">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" value="<?= htmlspecialchars($_POST['name'] ?? ''); ?>" autocomplete="off" required>
                        </div>
                        <div class="mb-3 form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address" value="<?= htmlspecialchars($_POST['email'] ?? ''); ?>" autocomplete="off" required>
                        </div>
                        <div class="mb-3 form-group">
                            <label for="password" class="form-label">Password</label>
                            <input type="text" class="form-control" id="password" name="password" placeholder="Enter your password" value="<?= htmlspecialchars($_POST['password'] ?? ''); ?>" autocomplete="off" required>
                        </div>
                        <div class="mb-3 form-group">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" value="<?= htmlspecialchars($_POST['phone'] ?? ''); ?>" autocomplete="off" required>
                        </div>
                        <div class="mb-3 form-group">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" rows="3" name="address" placeholder="Enter your address" autocomplete="off" required><?= htmlspecialchars($_POST['address'] ?? ''); ?></textarea>
                        </div>
                        <div class="mb-3 form-group">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="admin">Admin</option>
                                <option value="user" selected>User</option>
                            </select>
                        </div>
                        <!-- <div class="mb-3 form-group">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" class="form-control" id="photo" name="photo">
                        </div> -->
                        <div class="mt-5">
                            <button type="submit" class="btn btn-danger">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include '../../includes/footer.php'; ?>