<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Forest - Home</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9fafc;
            color: #333;
        }
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, rgba(106, 154, 135, 0.9), rgba(60, 110, 113, 0.9)),
                url('images/forest_background.jpg') no-repeat center center/cover;
            color: white;
            text-align: center;
            padding: 150px 20px;
        }

        .hero-section h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .hero-section p {
            font-size: 1.5rem;
            font-weight: 300;
            margin-bottom: 30px;
        }

        /* Content Section */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .card-title {
            font-weight: 600;
            color: #3c6e71;
        }

        .btn-custom {
            background-color: #3c6e71;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 1rem;
            font-weight: 500;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #6a9a87;
        }

        /* Description Section */
        .description-section {
            background-color: #f4f8f9;
            padding: 60px 20px;
        }

        .description-section h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #3c6e71;
        }

        .description-section p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #555;
        }

        /* Footer */
        .footer {
            background-color: #3c6e71;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }

        .footer a {
            color: #a7d7c5;
            text-decoration: none;
            margin: 0 10px;
        }

        .footer a:hover {
            text-decoration: underline;
        }
        .dropdown-menu {
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item {
            font-size: 1rem;
            color: #333;
            transition: background-color 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: #6a9a87;
            color: white;
        }
    </style>
</head>
<body>
    <?php
    include_once("nav.php");
    ?>

    <!-- Hero Section -->
    <div class="hero-section">
        <h1><i class="fas fa-tree"></i> Welcome to The Forest</h1>
        <p><i class="fas fa-leaf"></i> Preserving Nature, Managing Ecosystems, and Driving Sustainability</p>
    </div>

        <!-- About The Forest Section -->
        <div class="description-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h2 class="mb-4" style="display: flex; align-items: center;">
                            <i class="fas fa-tree me-3 text-success" style="font-size: 2.5rem;"></i> About The Forest
                        </h2>
                        <p style="font-size: 1.1rem; color: #555; line-height: 1.8;">
                            The Forest is a digital platform designed to manage, analyze, and visualize forest data effectively.
                            By leveraging the platform, users can gain insights into forest dynamics, such as growth patterns, 
                            tree distribution, and species composition. This information is vital for forest conservation 
                            and sustainable management practices.
                        </p>
                    </div>
                    <div class="col-md-6 text-center">
                        <img src="forest_icon.jpg" alt="Forest Icon" class="img-fluid" style="max-height: 250px;">
                    </div>
                </div>
            </div>
        </div>

        <!-- About The Malaysian Rainforest Section -->
        <div class="about-section" style="background-color: #f4f8f9; padding: 60px 0;">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Image Section -->
                    <div class="col-lg-6 text-center">
                        <img src="malaysian_rainforest.jpg" alt="Malaysian Rainforest" class="img-fluid rounded shadow-sm" style="max-height: 350px; object-fit: cover;">
                    </div>
                    <!-- Text Section -->
                    <div class="col-lg-6">
                        <h2 class="mb-4" style="display: flex; align-items: center; font-weight: 700;">
                            <i class="fas fa-leaf me-3 text-success" style="font-size: 2.5rem;"></i> About The Malaysian Rainforest
                        </h2>
                        <p style="font-size: 1.1rem; color: #555; line-height: 1.8;">
                            The Malaysian Rainforest, one of the world’s oldest tropical rainforests, is a biodiversity hotspot with over 130 million years of history. Spanning more than 20 million hectares, it is home to iconic species like the Malayan Tiger, Orangutan, and Rafflesia, the largest flower on Earth. This rainforest plays a critical role in carbon storage, water cycle regulation, and providing habitats for thousands of plant and animal species.
                        </p>
                        <p style="font-size: 1.1rem; color: #555; line-height: 1.8;">
                            Despite its ecological significance, the Malaysian Rainforest faces threats like deforestation, illegal poaching, and climate change. Conservation efforts, including reforestation and the establishment of national parks, are crucial to preserving this global treasure for future generations.
                        </p>
                        <ul class="list-unstyled mt-4">
                            <li class="mb-2" style="display: flex; align-items: center;">
                                <i class="fas fa-seedling text-success me-2" style="font-size: 1.5rem;"></i>
                                <span style="font-size: 1rem; color: #333;">Home to over 14,500 plant species</span>
                            </li>
                            <li class="mb-2" style="display: flex; align-items: center;">
                                <i class="fas fa-paw text-success me-2" style="font-size: 1.5rem;"></i>
                                <span style="font-size: 1rem; color: #333;">Shelters endangered wildlife like the Malayan Tiger and Orangutan</span>
                            </li>
                            <li style="display: flex; align-items: center;">
                                <i class="fas fa-globe text-success me-2" style="font-size: 1.5rem;"></i>
                                <span style="font-size: 1rem; color: #333;">Essential for global climate regulation</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>


    <!-- Content Section -->
    <div class="container my-5">
        <div class="row g-4">
            <!-- Generate Forest -->
            <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                <i class="fas fa-tree fa-3x text-success mb-3"></i>
                    <h5 class="card-title">Generate Forest</h5>
                    <p class="card-text">Create and manage forest data efficiently to ensure sustainability and growth.</p>
                    <a href="/deforest/UI_Generate_Forest/Generate_Forest_UI.php" class="btn btn-custom">Go to Generate Forest</a>
                </div>
            </div>
        </div>

            <!-- Production -->
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                    <i class="fas fa-chart-bar fa-3x text-success mb-3"></i>
                        <h5 class="card-title">Production</h5>
                        <p class="card-text">A visual description combining geographic location with bar chart to illustrate data trend across regions.</p>
                        <a href="/deforest/GraphBar/bar.php" class="btn btn-custom">Go to Distribution</a>
                    </div>
                </div>
            </div>

            <!-- Regime 50 -->
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                    <i class="fas fa-seedling fa-3x text-success mb-3"></i>
                        <h5 class="card-title">Regime 50</h5>
                        <p class="card-text">Select between Map or Stand Table for detailed forest analysis.</p>
                        <!-- Dropdown Menu -->
                        <div class="dropdown">
                            <button class="btn btn-custom dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                Select Option
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <!-- <li><a class="dropdown-item" href="/deforest/Regime50/plot.php">Map</a></li> -->
                                <li><a class="dropdown-item" href="/deforest/Regime50/StandTable.php">Stand Table</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Regime 55-->
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                    <i class="fas fa-seedling fa-3x text-success mb-3"></i>
                        <h5 class="card-title">Regime 55</h5>
                        <p class="card-text">Select between Map or Stand Table for detailed forest analysis.</p>
                        <!-- Dropdown Menu -->
                        <div class="dropdown">
                            <button class="btn btn-custom dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                Select Option
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <!-- <li><a class="dropdown-item" href="/deforest/Regime55/plot.php">Map</a></li> -->
                                <li><a class="dropdown-item" href="/deforest/Regime55/StandTable.php">Stand Table</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Regime 60 -->
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                    <i class="fas fa-seedling fa-3x text-success mb-3"></i>
                        <h5 class="card-title">Regime 60</h5>
                        <p class="card-text">Select between Map or Stand Table for detailed forest analysis.</p>
                        <!-- Dropdown Menu -->
                        <div class="dropdown">
                            <button class="btn btn-custom dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                Select Option
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <!-- <li><a class="dropdown-item" href="/deforest/Regime60/plot.php">Map</a></li> -->
                                <li><a class="dropdown-item" href="/deforest/Regime60/StandTable.php">Stand Table</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 The Forest. Designed for a sustainable future. | <a href="#">Contact Us</a></p>
    </footer>

    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
