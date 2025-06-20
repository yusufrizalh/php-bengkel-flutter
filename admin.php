<?php
// session_start();
// if (!isset($_SESSION['loggedin'])) {
//     header('Location: login.php');
//     exit;
// }

include './config/koneksi.php';
?>

<?php include './includes/header.php'; ?>

<section class="admin-panel">
    <!-- <h2>Admin Dashboard</h2> -->

    <!-- Tab Navigation -->
    <!-- <div class="tabs">
        <button class="tab-btn active" data-tab="articles">Artikel</button>
        <button class="tab-btn" data-tab="categories">Kategori</button>
        <button class="tab-btn" data-tab="authors">Penulis</button>
    </div>

    <hr>
    <br><br> -->

    <!-- Articles Tab -->
    <div id="articles" class="tab-content active">
        <!-- <h3>Kelola Artikel</h3> -->
        <a href="crud/create_article.php" class="btn">New Article</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Author</th>
                    <th>Published at</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT articles.*, categories.name AS category_name, authors.name AS author_name 
                        FROM articles 
                        JOIN categories ON articles.category_id = categories.id
                        JOIN authors ON articles.author_id = authors.id";
                $result = $conn->query($sql);

                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['title']}</td>
                        <td>{$row['category_name']}</td>
                        <td>{$row['author_name']}</td>
                        <td>" . date('d M Y', strtotime($row['published_at'])) . "</td>
                        <td>
                            <a href='crud/update_article.php?id={$row['id']}' class='btn'>Edit</a>
                            <a href='crud/delete_article.php?id={$row['id']}' class='btn' onclick='return confirm(\"Sure?\")'>Delete</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <hr>
    <br><br>

    <!-- Categories Tab -->
    <div id="categories" class="tab-content">
        <!-- Konten Kelola Kategori -->
        <a href="crud/create_category.php" class="btn">New Category</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM categories ORDER BY name ASC";
                $result = $conn->query($sql);

                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>
                            <a href='crud/update_category.php?id={$row['id']}' class='btn'>Edit</a>
                            <a href='crud/delete_category.php?id={$row['id']}' class='btn' onclick='return confirm(\"Sure?\")'>Delete</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <hr>
    <br><br>

    <!-- Authors Tab -->
    <div id="authors" class="tab-content">
        <!-- Konten Kelola Penulis -->
        <div id="authors" class="tab-content">
            <!-- Konten Kelola Kategori -->
            <a href="crud/create_author.php" class="btn">New Author</a>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Author Name</th>
                        <th>Email Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM authors ORDER BY name ASC";
                    $result = $conn->query($sql);

                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>
                            <a href='crud/update_author.php?id={$row['id']}' class='btn'>Edit</a>
                            <a href='crud/delete_author.php?id={$row['id']}' class='btn' onclick='return confirm(\"Sure?\")'>Delete</a>
                        </td>
                    </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php include './includes/footer.php'; ?>