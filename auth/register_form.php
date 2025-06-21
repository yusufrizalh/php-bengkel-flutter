<?php include '../includes/header.php'; ?>

<section class="hero mt-3">
    <center>
        <h2>Teknologi Mobile Terkini</h2>
        <p>Update terbaru seputar Flutter, React Native, dan Framework Mobile Lainnya</p>
    </center>
</section>
<section class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header bg-danger text-white">
                    <h5 class="card-title">Register</h5>
                </div>
                <div class="card-body">
                    <form action="register.php" method="POST">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label fw-bold">Name</label>
                            <input type="text" class="form-control"
                                placeholder="Enter your name"
                                id="name" name="name" autocomplete="off">
                                <small class="text-danger">*Name is required</small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control"
                                placeholder="Enter your email address"
                                id="email" name="email" autocomplete="off">
                                <small class="text-danger">*Email is required</small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <input type="password" class="form-control"
                                placeholder="Enter your password"
                                id="password" name="password" autocomplete="off">
                                <small class="text-danger">*Password is required</small>
                        </div>
                        <div class="mt-5">
                            <button type="submit" class="btn btn-danger">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</section>

<?php include '../includes/footer.php'; ?>