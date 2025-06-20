<?php
include '../includes/header.php';
?>

<section class="hero mt-5 mb-5">
    <center>
        <h2>Teknologi Mobile Terkini</h2>
        <p>Update terbaru seputar Flutter, React Native, dan Framework Mobile Lainnya</p>
    </center>
</section>
<section class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <?php
            include '../config/koneksi.php';
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                echo "<p>Invalid article ID...</p>";
                exit;
            } else {
                $id = $_GET['id'];
            }
            $sql = "SELECT articles.*, 
                categories.name AS category_name, 
                authors.name AS author_name 
                FROM articles 
                JOIN categories ON articles.category_id = categories.id
                JOIN authors ON articles.author_id = authors.id
                WHERE articles.id = $id";
            $result = $conn->query($sql);
            if ($result->rowCount() > 0) {
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <div class="card shadow">
                        <div class="card-header">
                            <img src=" https://imageholdr.com/800x400/760c0c/ffffff?font-size=25&font-family=impact&text=<?php echo $row["title"]; ?>" style="width: 100%;" />
                        </div>
                        <div class=" card-body">
                            <h5><?php echo $row["title"]; ?></h5>
                            <p>
                                <?php echo $row["content"]; ?>
                            </p>
                        </div>
                        <div class="card-footer">
                            Category: <a href="show_category.php?cat=<?php echo $row['category_name']; ?>" class="badge rounded-pill text-bg-danger text-decoration-none">
                                <?php echo $row['category_name']; ?>
                            </a> <br><br>
                            <?php
                            $sql1 = "SELECT a.id, a.title AS article_title, t.name AS tag_name
                                    FROM articles AS a JOIN article_tags AS atag ON a.id = atag.article_id JOIN tags AS t ON t.id = atag.tag_id WHERE a.id = " . $row['id'] . ";";
                            $result1 = $conn->query($sql1);
                            if ($result1->rowCount() > 0) {
                            ?>
                                Tags:
                                <?php
                                while ($row1 = $result1->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <a href="show_tag.php?tag=<?php echo $row1['tag_name']; ?>" class="badge rounded-pill text-bg-danger text-decoration-none">
                                        <?php
                                        echo $row1['tag_name'];
                                        ?>
                                    </a>
                            <?php
                                }
                            }
                            ?>
                            <br><br>
                            Author: <a href="show_author.php?aut=<?php echo $row['author_name']; ?>" class="badge rounded-pill text-bg-danger text-decoration-none"> <?php echo $row['author_name']; ?> </a>
                            <br><br>
                            Published: <?php echo date('d M Y', strtotime($row['published_at'])); ?>
                        </div>
                    </div>
        </div>
<?php
                }
            } else {
                echo "<p>Article not found...</p>";
            }
?>
<div class="col-md-4">
    <h4>Other Articles</h4>
    <?php
    $sql = "SELECT * FROM articles ORDER BY id DESC LIMIT 6";
    $result = $conn->query($sql);
    if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    ?>
            <ul class="list-group">
                <a href="show_article.php?id=<?php echo $row["id"]; ?>" class="list-group-item list-group-item-action">
                    <?php echo $row["title"]; ?>
                </a>
            </ul>
    <?php
        }
    } else {
        echo "<p>Article not found...</p>";
    }
    ?>
</div>
    </div>

</section>

<?php include '../includes/footer.php'; ?>