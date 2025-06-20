<?php include './includes/header.php'; ?>

<section class="hero mt-3 mb-3">
    <center>
        <h2>Teknologi Mobile Terkini</h2>
        <p>Update terbaru seputar Flutter, React Native, dan Framework Mobile Lainnya</p>
    </center>
</section>

<section class="container-fluid">
    <div class="row">
        <?php
        include './config/koneksi.php';
        $sql = "SELECT articles.*, categories.name AS category_name, authors.name AS author_name 
                FROM articles 
                JOIN categories ON articles.category_id = categories.id
                JOIN authors ON articles.author_id = authors.id
                ORDER BY published_at DESC";
        $result = $conn->query($sql);
        ?>
        <?php
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        ?>
                <div class="col-md-4">
                    <a href="crud/show_article.php?id=<?php echo $row['id']; ?>" class="btn">
                        <div class="card shadow">
                            <div class="card-header">
                                <img class="card-img-top" src="https://imageholdr.com/400x250/760c0c/ffffff?font-size=25&font-family=impact&text=<?php echo $row["title"]; ?>" />
                            </div>
                            <div class=" card-body">
                                <h5><?php echo $row["title"]; ?></h5>
                                <p>
                                    <?php echo substr($row["content"], 0, 100); ?>...
                                </p>
                            </div>
                            <div class="card-footer">
                                Category: <p class="badge rounded-pill text-bg-danger">
                                    <?php echo $row['category_name']; ?>
                                </p> <br>
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
                                        <p class="badge rounded-pill text-bg-danger">
                                            <?php
                                            echo $row1['tag_name'];
                                            ?>
                                        </p>
                                <?php
                                    }
                                }
                                ?>
                                <br>
                                Author: <p class="badge rounded-pill text-bg-danger"> <?php echo $row['author_name']; ?> </p>
                                <br>
                                Published: <?php echo date('d M Y', strtotime($row['published_at'])); ?>
                            </div>
                        </div>
                    </a>
                </div>

        <?php
            }
        }
        ?>
    </div>

    <!-- <div class="articles-grid">
        <?php
        include './config/koneksi.php';
        $sql = "SELECT articles.*, categories.name AS category_name, authors.name AS author_name 
                FROM articles 
                JOIN categories ON articles.category_id = categories.id
                JOIN authors ON articles.author_id = authors.id
                ORDER BY published_at DESC";
        $result = $conn->query($sql);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<a href="crud/show_article.php?id=' . $row['id'] . '" class="article-card text-decoration-none">';
                echo '<img src="https://imageholdr.com/600x400/760c0c/ffffff?font-size=30&font-family=impact&text=' . urlencode($row['title']) . '" alt="' . $row['title'] . '">';
                echo '<div class="article-content">';
                echo '<span class="category-badge">' . $row['category_name'] . '</span>';
                echo '<h3>' . $row['title'] . '</h3>';
                echo '<p>' . substr($row['content'], 0, 100) . '...</p>';
                echo '<p><small>by: ' . $row['author_name'] . ' | ' . date('d M Y', strtotime($row['published_at'])) . '</small></p>';
                echo '</div></a>';
            }
        } else {
            echo "<p>No articles found...</p>";
        }
        ?>
    </div> -->
</section>

<?php include './includes/footer.php'; ?>