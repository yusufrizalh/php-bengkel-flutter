<?php
include '../includes/header.php';
?>

<section class="hero mt-5">
    <center>
        <h2>Teknologi Mobile Terkini</h2>
        <p>Update terbaru seputar Flutter, React Native, dan Framework Mobile Lainnya</p>
    </center>
</section>
<section class="container-fluid">
    <?php
    include '../config/koneksi.php';
    $sql = "SELECT aut.name AS author_name, COUNT(a.id) AS count_of_articles
        FROM authors AS aut 
            JOIN articles AS a ON aut.id = a.author_id
            JOIN categories AS c ON c.id = a.category_id
        GROUP BY aut.name;";
    $result = $conn->query($sql);
    $chartAuthors = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $chartAuthors[] = $row;
    }
    ?>
    <div class="row">
        <div class="col-md-10">
            <!-- Bar Chart -->
            <div class="chart-container">
                <div class="chart-title">Count of articles by Author</div>
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>

</section>

<script>
    const data = <?php echo json_encode($chartAuthors); ?>;

    const labels = data.map(item => item.author_name);
    const values = data.map(item => item.count_of_articles);

    // Bar Chart
    const barCtx = document.getElementById('barChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Count of articles',
                data: values,
                backgroundColor: 'rgba(255, 0, 0, 1)',
                borderColor: 'rgba(100, 0, 0, 1)',
                borderWidth: 1,
                hoverBackgroundColor: 'rgba(255, 0, 0, 0.8)',
                hoverBorderColor: 'rgba(100, 0, 0, 0.8)'
            }]
        },
        options: {
            maintainAspectRatio: true,
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 14
                        },
                        usePointStyle: true,
                        padding: 10,
                        boxWidth: 10,
                        boxHeight: 10,
                        boxPadding: 5,
                        boxMargin: 5,
                        pointStyle: 'circle',
                        pointRadius: 5,
                        pointHitRadius: 10,
                        pointHoverRadius: 10,
                        pointHoverBorderWidth: 2,
                        pointHoverBorderColor: 'rgba(100, 0, 0, 1)',
                        pointHoverBackgroundColor: 'rgba(255, 0, 0, 1)',
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        font: {
                            size: 14
                        }
                    }

                }
            }
        }
    });
</script>

<?php include '../includes/footer.php'; ?>