<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bengkel Flutter</title>
    <link rel="icon" href="https://i.ibb.co/xtgVFHyg/Rizal-Studio-Logo.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            width: 75%;
            display: inline-block;
            margin: 10px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .chart-title {
            text-align: center;
            font-size: 28px;
            margin-bottom: 15px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <header>
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg fixed-top" style="background-color: #800000;" data-bs-theme="light"">
                <div class=" container-fluid">
                <a class="navbar-brand" href="https://inixindo.id">
                    <img src="https://i.ibb.co/xtgVFHyg/Rizal-Studio-Logo.png" alt="RZ-STUDIO" width="30" height="30" class="d-inline-block align-text-top me-3">
                    <span class="text-white">Bengkel Flutter</span>
                </a>
                <button class="navbar-toggler" type="button" style="background-color: white;" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <?php
                    if (isset($_SESSION['loggedin'])) {
                    ?>
                        <!-- admin navbar -->
                        <ul class="navbar-nav nav-underline me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link text-white active" aria-current="page" href="index.php">Home</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link text-white dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Manage
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Users</a></li>
                                    <li><a class="dropdown-item" href="#">Authors</a></li>
                                    <li><a class="dropdown-item" href="#">Articles Native</a></li>
                                    <li><a class="dropdown-item" href="#">Categories</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link text-white dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Charts
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="chart_by_author.php">by Author</a></li>
                                    <li><a class="dropdown-item" href="chart_by_category.php">by Category</a></li>
                                    <li><a class="dropdown-item" href="chart_by_tag.php">by Tag</a></li>
                                </ul>
                            </li>
                        </ul>
                    <?php
                    } else {
                    ?>
                        <!-- guest navbar -->
                        <ul class="navbar-nav nav-underline me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link text-white active" aria-current="page" href="index.php">
                                    Beranda
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link text-white dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Tutorials
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">JavaScript</a></li>
                                    <li><a class="dropdown-item" href="#">Flutter</a></li>
                                    <li><a class="dropdown-item" href="#">React Native</a></li>
                                    <li><a class="dropdown-item" href="#">Framework7</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link text-white dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Charts
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="chart_by_author.php">by Author</a></li>
                                    <li><a class="dropdown-item" href="chart_by_category.php">by Category</a></li>
                                    <li><a class="dropdown-item" href="chart_by_tag.php">by Tag</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="#">
                                    About
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="#">
                                    Contact
                                </a>
                            </li>
                        </ul>
                    <?php
                    }
                    ?>
                    <?php
                    if (isset($_SESSION['loggedin'])) {
                    ?>
                        <ul class="navbar-nav mb-2 mb-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link text-white dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    User Area
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="">Profile</a></li>
                                    <li><a class="dropdown-item" href="../auth/logout.php">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    <?php
                    } else {
                    ?>
                        <ul class="navbar-nav mb-2 mb-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link text-white dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    User Area
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="auth/register_form.php">Register</a></li>
                                    <li><a class="dropdown-item" href="auth/login_form.php">Login</a></li>
                                </ul>
                            </li>
                        </ul>
                    <?php
                    }
                    ?>
                </div>
        </div>
        </nav>
        </div>
    </header>

    <div id="carouselExampleCaptions" class="carousel slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img style="width: 100%; height: 300px; object-fit: cover;" src="https://fastly.picsum.photos/id/0/5000/3333.jpg?hmac=_j6ghY5fCfSD6tvtcV74zXivkJSPIfR9B8w34XeQmvU" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>First slide label</h5>
                    <p>Some representative placeholder content for the first slide.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img style="width: 100%; height: 300px; object-fit: cover;" src="https://fastly.picsum.photos/id/1/5000/3333.jpg?hmac=Asv2DU3rA_5D1xSe22xZK47WEAN0wjWeFOhzd13ujW4" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Second slide label</h5>
                    <p>Some representative placeholder content for the second slide.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img style="width: 100%; height: 300px; object-fit: cover;" src="https://fastly.picsum.photos/id/2/5000/3333.jpg?hmac=_KDkqQVttXw_nM-RyJfLImIbafFrqLsuGO5YuHqD-qQ" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Third slide label</h5>
                    <p>Some representative placeholder content for the third slide.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>