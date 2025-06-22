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
    <?php if (isset($_SESSION['loggedin'])): ?>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-danger text-center">
                        <h3 class="fw-bold text-white">
                            User List
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive-sm">
                            <table class="table table-sm table-hover table-borderless">
                                <caption>List of users</caption>
                                <thead>
                                    <tr class="table-danger">
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php
                                include '../../config/koneksi.php';
                                $sql = "SELECT * FROM users ORDER BY id ASC";
                                $result = $conn->query($sql);
                                ?>
                                <?php
                                if ($result->rowCount() > 0) {
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                        <tbody class="table-group-divider">
                                            <tr>
                                                <td><?= $row['id']; ?></td>
                                                <td>
                                                    <a href="show.php?name=<?= $row['name']; ?>" class="text-primary text-decoration-none">
                                                        <?= $row['name']; ?>
                                                    </a>
                                                </td>
                                                <td><?= $row['email']; ?></td>
                                                <td><?= $row['role']; ?></td>
                                                <td>
                                                    <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-primary">
                                                        <i class="bi bi-solid bi-pencil-square"></i>
                                                    </a> &nbsp;
                                                    <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this user?');"">
                                                    <i class=" bi bi-solid bi-trash"></i></a ?>
                                                    <!-- <a href=" delete_user.php?id=<?= $row['id']; ?>" type=" button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                        <i class="bi bi-solid bi-trash"></i>
                                                    </a> -->
                                                </td>
                                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete User</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <span>Are you sure to delete this user?</span>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="button" class="btn btn-sm btn-danger">Delete</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </tr>
                                        </tbody>
                                <?php
                                    }
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>

<?php include '../../includes/footer.php'; ?>