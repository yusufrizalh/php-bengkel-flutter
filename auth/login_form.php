<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'login.php';
}
?>

<?php include '../includes/header.php'; ?>

<section class="hero mt-3">
    <center>
        <h2>Teknologi Mobile Terkini</h2>
        <p>Update terbaru seputar Flutter, React Native, dan Framework Mobile Lainnya</p>
    </center>
</section>
<section class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-danger text-white">
                    <h5 class="card-title">Login</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li><?= htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($response) && $response['success'] == true): ?>
                        <div class="alert alert-success">
                            <?= htmlspecialchars($response['message']); ?>
                        </div>
                    <?php endif; ?>
                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                        <div class="form-group mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="text" class="form-control <?= !empty($errors['email']) ? 'is-invalid' : ''; ?>"
                                value="<?= htmlspecialchars($_POST['email'] ?? ''); ?>"
                                placeholder="Enter your email address"
                                id="email" name="email" autocomplete="off">
                            <?php if (!empty($errors['email'])): ?>
                                <div class="invalid-feedback">
                                    <?= $errors['email']; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <input type="password" class="form-control <?= !empty($errors['password']) ? 'is-invalid' : ''; ?>"
                                value="<?= htmlspecialchars($_POST['password'] ?? ''); ?>"
                                placeholder="Enter your password"
                                id="password" name="password" autocomplete="off">
                            <?php if (!empty($errors['password'])): ?>
                                <div class="invalid-feedback">
                                    <?= $errors['password']; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="mt-5">
                            <button type="submit" class="btn btn-danger">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</section>

<?php include '../includes/footer.php'; ?>