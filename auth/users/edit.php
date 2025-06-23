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
  require_once 'update.php';
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
      <?php
      include '../../config/koneksi.php';
      if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo "<p>Invalid user id...</p>";
        exit;
      } else {
        $id = $_GET['id'];
      }
      $sql = "SELECT id, name, email, phone, address, role, photo FROM users WHERE id = :id";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':id', $id);
      $stmt->execute();
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
      $selectedRole = $user['role'];
      ?>
      <div class="card shadow">
        <div class="card-header bg-danger text-center">
          <h3 class="fw-bold text-white">
            Edit User
          </h3>
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
          <form action="update.php?id=<?php echo $user['id']; ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3 form-group">
              <label for="photo" class="form-label">Photo</label>
              <?php if ($user['photo']): ?>
                <img src="uploads/<?= htmlspecialchars($user['photo'] ?? ''); ?>" alt="ProfilePicture" class="img-thumbnail" width="500">
              <?php else: ?>
                <span>No photo found</span>
              <?php endif; ?>
              <input type="file" class="form-control" id="photo" name="photo">
              <small class="text-muted">Ignores current photo if no photo is uploaded</small>
            </div>
            <div class="mb-3 form-group">
              <input type="text" class="form-control" disabled readonly id="id" name="id" value="<?= 'ID: ' . htmlspecialchars($user['id'] ?? ''); ?>">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" value="<?= htmlspecialchars($user['name'] ?? ''); ?>" autocomplete="off">
            </div>
            <div class="mb-3 form-group">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address" value="<?= htmlspecialchars($user['email'] ?? ''); ?>" autocomplete="off">
            </div>
            <div class="mb-3 form-group">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" value="<?php echo htmlspecialchars($user['password'] ?? 'Pa$$w0rd'); ?>" autocomplete="off">
            </div>
            <div class="mb-3 form-group">
              <label for="phone" class="form-label">Phone</label>
              <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" value="<?= htmlspecialchars($user['phone'] ?? ''); ?>" autocomplete="off">
            </div>
            <div class="mb-3 form-group">
              <label for="address" class="form-label">Address</label>
              <textarea class="form-control" id="address" rows="3" name="address" placeholder="Enter your address" autocomplete="off"><?= htmlspecialchars($user['address'] ?? ''); ?></textarea>
            </div>
            <div class="mb-3 form-group">
              <label for="role" class="form-label">Role</label>
              <select class="form-control" id="role" name="role">
                <option value="admin" <?= ($selectedRole == 'admin') ? 'selected' : '' ?>>Admin</option>
                <option value="user" <?= ($selectedRole == 'user') ? 'selected' : '' ?>>User</option>
              </select>
            </div>
            <!-- <div class="mb-3 form-group">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" class="form-control" id="photo" name="photo">
                        </div> -->
            <div class="mt-5">
              <button type="submit" class="btn btn-danger">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include '../../includes/footer.php'; ?>