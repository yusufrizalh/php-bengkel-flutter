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
    <?php
    include '../config/koneksi.php';
    if (!isset($_GET['cat']) || empty($_GET['cat'])) {
        echo "<p>Invalid category name...</p>";
        exit;
    } else {
        $cat = $_GET['cat'];
    }
    $sql = "SELECT c.name AS category_name, a.id AS id,
                a.title AS title, a.content AS content, a.published_at AS published_at, aut.name AS author_name
                FROM categories AS c 
                    JOIN articles AS a ON c.id = a.category_id
                    JOIN authors AS aut ON aut.id = a.author_id
                WHERE c.name = '$cat';";
    $result = $conn->query($sql);
    ?>
    <h3>Category: <span class="fw-bold"><?php echo $cat; ?></span></h3>
    <hr>
    <div class="row">
        <?php
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        ?>
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-header">
                            <img src=" https://imageholdr.com/800x400/760c0c/ffffff?font-size=25&font-family=impact&text=<?php echo $row["title"]; ?>" style="width: 100%;" />
                        </div>
                        <div class=" card-body">
                            <h5><?php echo $row["title"]; ?></h5>
                            <p>
                                <?php echo substr($row["content"], 0, 100); ?>...
                            </p>
                        </div>
                        <div class="card-footer">
                            Category: <span class="badge rounded-pill text-bg-danger">
                                <?php echo $row['category_name']; ?>
                            </span> <br><br>
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
                </div>
        <?php
            }
        } else {
            echo "<h3>Category not found...</h3>";
        }
        ?>
    </div>

</section>

<?php include '../includes/footer.php'; ?>