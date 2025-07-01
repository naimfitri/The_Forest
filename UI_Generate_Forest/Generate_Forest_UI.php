 <?php include_once("../nav.php"); ?>  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forest Generator</title>
    <link rel="stylesheet" href="./style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <style>
        :root {
            --color-primary: #2ecc71;
            --color-primary-dark: #27ae60;
            --color-secondary: #3498db;
            --color-tertiary: #1abc9c;
            --color-white: #ffffff;
            --color-black: #2c3e50;
            --color-light-grey: #f8f9fa;
            --color-mid-grey: #e9ecef;
            --shadow-color: rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--color-light-grey);
            color: var(--color-black);
        }

        /* Hero styling */
        .hero {
            min-height: calc(100vh - 80px);
            background: linear-gradient(rgba(39, 174, 96, 0.1), rgba(52, 152, 219, 0.1)), 
                        url('./bg.jpg') no-repeat center center/cover;
            padding: 40px 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Form styling */
        .form {
            background: var(--color-white);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
            width: 90%;
            max-width: 800px;
            padding: 30px;
            margin: 20px auto;
            overflow: hidden;
            position: relative;
        }

        .form h2 {
            color: var(--color-black);
            font-weight: 600;
            font-size: 28px;
            margin-bottom: 30px;
            text-align: center;
            position: relative;
        }

        .form h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 70px;
            height: 3px;
            background: var(--color-primary);
            border-radius: 2px;
        }

        /* Progress bar styling */
        .progressbar {
            position: relative;
            display: flex;
            justify-content: space-between;
            margin: 40px 0;
            z-index: 1;
        }

        .progressbar::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 0;
            height: 4px;
            width: 100%;
            background-color: var(--color-mid-grey);
            transform: translateY(-50%);
            z-index: -1;
            border-radius: 2px;
        }

        .progress {
            position: absolute;
            top: 50%;
            left: 0;
            height: 4px;
            width: 0%;
            background-color: var(--color-primary);
            transform: translateY(-50%);
            z-index: -1;
            border-radius: 2px;
            transition: width 0.4s ease;
        }

        .progress-step {
            width: 35px;
            height: 35px;
            background-color: var(--color-mid-grey);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            transition: all 0.3s ease;
        }

        .progress-step::before {
            content: attr(data-title);
            position: absolute;
            top: 45px;
            font-size: 14px;
            font-weight: 500;
            color: var(--color-black);
            white-space: nowrap;
        }

        .progress-step::after {
            content: attr(data-number);
            color: var(--color-white);
            font-weight: 500;
            font-size: 14px;
        }

        .progress-step-active {
            background-color: var(--color-primary);
            color: var(--color-white);
            transform: scale(1.1);
            box-shadow: 0 0 10px rgba(46, 204, 113, 0.5);
        }

        /* Form steps styling */
        .form-step {
            display: none;
            animation: fadeIn 0.5s ease;
        }

        .form-step-active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .input-group {
            margin-bottom: 30px;
        }

        .input-group h3 {
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 20px;
            color: var(--color-black);
            line-height: 1.5;
        }

        /* Button styling */
        .btn {
            font-family: 'Poppins', sans-serif;
            padding: 12px 24px;
            background-color: var(--color-primary);
            color: var(--color-white);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s ease;
            margin: 5px;
            display: inline-block;
            text-decoration: none;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        }

        .btn:hover {
            background-color: var(--color-primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btns-group {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-prev {
            background-color: var(--color-mid-grey);
            color: var(--color-black);
        }

        .btn-prev:hover {
            background-color: #d8d8d8;
        }

        .btn-next {
            background-color: var(--color-primary);
        }

        .width-50 {
            width: 50%;
        }

        .ml-auto {
            margin-left: auto;
        }

        /* Loading overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            display: none;
            backdrop-filter: blur(3px);
        }

        .loading-overlay.active {
            display: flex;
        }

        .loading-spinner {
            width: 70px;
            height: 70px;
            border: 8px solid rgba(255, 255, 255, 0.3);
            border-top: 8px solid var(--color-primary);
            border-radius: 50%;
            animation: spin 1.5s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Regime button variants */
        .btn-regime-45 {
            background-color: #27ae60;
        }
        .btn-regime-50 {
            background-color: #2980b9;
        }
        .btn-regime-55 {
            background-color: #8e44ad;
        }
        .btn-regime-60 {
            background-color: #c0392b;
        }

        /* Success message */
        .success-message {
            background-color: rgba(46, 204, 113, 0.1);
            border-left: 4px solid var(--color-primary);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
        }
    </style>
</head>
<body>
    
     
    
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>
    
    <div class="hero">
      <!-- Form Begins -->
      <form action="#" class="form">
        <h2>Generate Forest</h2>

        <!-- Progress Bar  -->
        <div class="progressbar">
            <div class="progress" id="progress"></div>
            <div class="progress-step progress-step-active" data-title="Create Forest" data-number="1"></div>
            <div class="progress-step" data-title="Calculate Forest" data-number="2"></div>
            <div class="progress-step" data-title="Find Victim" data-number="3"></div>
            <div class="progress-step" data-title="Simulate Growth" data-number="4"></div>
        </div>

        <!-- Form item - Generate Forest -->
        <div class="form-step form-step-active">
            <div class="input-group">
                <?php
                // Database connection
                DEFINE('DB_USER', 'root');
                DEFINE('DB_PASSWORD', '');
                DEFINE('DB_HOST', 'localhost');
                DEFINE('DB_NAME', 'tree');

                $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die('Could not connect to MySQL: ' . mysqli_connect_error());
                mysqli_set_charset($conn, 'utf8');

                // Check if the forest already exists
                $sql = "SELECT * FROM new_forest";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo '<div class="success-message"><i class="fas fa-info-circle"></i> It appears you already have a forest generated!</div>';
                    echo '<button type="button" id="generateBtn" class="btn"><i class="fas fa-tree"></i> Generate New Forest</button>';
                } else {
                    echo '<div class="success-message"><i class="fas fa-info-circle"></i> No forest data found. You can generate a new forest.</div>';
                    echo '<button type="button" id="generateBtn" class="btn"><i class="fas fa-tree"></i> Generate New Forest</button>';
                }
                ?>
            </div>
            <div>
                <a href="#" class="btn btn-next width-50 ml-auto">Next <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>

        <!-- Form item - Calculate Data -->
        <div class="form-step">
            <div class="input-group">
                <h3><i class="fas fa-calculator"></i> Calculate all necessary data based on cutting regime</h3>
                <button type="button" id="regime" class="btn btn-regime-45"><i class="fas fa-leaf"></i> Regime 45</button>
                <button type="button" id="regime50" class="btn btn-regime-50"><i class="fas fa-leaf"></i> Regime 50</button>
                <button type="button" id="regime55" class="btn btn-regime-55"><i class="fas fa-leaf"></i> Regime 55</button>
                <button type="button" id="regime60" class="btn btn-regime-60"><i class="fas fa-leaf"></i> Regime 60</button>
            </div>
            <div class="btns-group">
                <a href="#" class="btn btn-prev"><i class="fas fa-arrow-left"></i> Back</a>
                <a href="#" class="btn btn-next">Next <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>

        <!-- Form item - Calculate Damage -->
        <div class="form-step">
            <div class="input-group">
                <h3><i class="fas fa-search"></i> Find victims based on cutting regime</h3>
                <button type="button" id="Vregime" class="btn btn-regime-45"><i class="fas fa-leaf"></i> Regime 45</button>
                <button type="button" id="Vregime50" class="btn btn-regime-50"><i class="fas fa-leaf"></i> Regime 50</button>
                <button type="button" id="Vregime55" class="btn btn-regime-55"><i class="fas fa-leaf"></i> Regime 55</button>
                <button type="button" id="Vregime60" class="btn btn-regime-60"><i class="fas fa-leaf"></i> Regime 60</button>
            </div>
            <div class="btns-group">
                <a href="#" class="btn btn-prev"><i class="fas fa-arrow-left"></i> Back</a>
                <a href="#" class="btn btn-next">Next <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>

        <!-- Form item - Calculate Growth -->
        <div class="form-step">
            <div class="input-group">
                <h3><i class="fas fa-chart-line"></i> Simulate tree growth based on cutting regime</h3>
                <button type="button" id="Gregime" class="btn btn-regime-45"><i class="fas fa-leaf"></i> Regime 45</button>
                <button type="button" id="Gregime50" class="btn btn-regime-50"><i class="fas fa-leaf"></i> Regime 50</button>
                <button type="button" id="Gregime55" class="btn btn-regime-55"><i class="fas fa-leaf"></i> Regime 55</button>
                <button type="button" id="Gregime60" class="btn btn-regime-60"><i class="fas fa-leaf"></i> Regime 60</button>
            </div>
            <div class="btns-group">
                <a href="#" class="btn btn-prev"><i class="fas fa-arrow-left"></i> Back</a>
                <a href="/deforest/GraphBar/GraphBar.php" class="btn btn-next">View Results <i class="fas fa-chart-bar"></i></a>
            </div>
        </div>
      </form>
    </div>
    
    <script src="./script.js"></script>
    <script>

        function showLoading() {
            console.log("Loading spinner triggered");  // This will log when showLoading is called
            document.getElementById('loadingOverlay').classList.add('active');
        }

        function hideLoading() {
            console.log("Loading spinner hidden");  // This will log when hideLoading is called
            document.getElementById('loadingOverlay').classList.remove('active');
        }

        //Form1
        document.getElementById('generateBtn').addEventListener('click', function() {
            if (confirm("This will clear and generate a new forest. Do you want to proceed?")) {
                showLoading();

                    fetch('truncate.php')
                    .then(response => response.text())
                    .then(data => {
                        console.log(data); // For debugging
                        alert("Congrats on making our forest green again! Click Next");
                        hideLoading();
                        location.reload();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        hideLoading();  // Hide loading spinner in case of an error
                    });
            }
        });
        //Form2
        document.getElementById('regime50').addEventListener('click', function() {
            if (confirm("Calculate regime 50 and store into regime 50 table. Do you want to proceed?")) {
                showLoading();

                fetch('http://localhost/deforest/Calculate.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ regime: 'regime50' })
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data); // For debugging
                    alert("regime 50 Stored Success! Click Next");
                    hideLoading();
                    
                })
                .catch(error => {
                    console.error('Error:', error);
                    hideLoading();  // Hide loading spinner in case of an error
                });
            }
        });

        document.getElementById('regime55').addEventListener('click', function() {
            if (confirm("Calculate regime 55 and store into regime 55 table. Do you want to proceed?")) {
                showLoading();
                fetch('http://localhost/deforest/Calculate.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ regime: 'regime55' })
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data); // For debugging
                    alert("regime 55 Stored Success! Click Next");
                    hideLoading();
                    
                })
                .catch(error => {
                    console.error('Error:', error);
                    hideLoading();  // Hide loading spinner in case of an error
                });
            }
        });

        document.getElementById('regime60').addEventListener('click', function() {
            if (confirm("Calculate regime 60 and store into regime 60 table. Do you want to proceed?")) {
                showLoading();
                fetch('http://localhost/deforest/Calculate.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ regime: 'regime60' })
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data); // For debugging
                    alert("regime 60 Stored Success! Click Next");
                    hideLoading();
                    
                })
                .catch(error => {
                    console.error('Error:', error);
                    hideLoading();  // Hide loading spinner in case of an error
                });
            }
        });

        document.getElementById('regime').addEventListener('click', function() {
            if (confirm("Calculate regime 45 and store into regime 45 table. Do you want to proceed?")) {
                showLoading();
                fetch('http://localhost/deforest/Calculate.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ regime: 'regime' })
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data); // For debugging
                    alert("regime 45 Stored Success! Click Next");
                    hideLoading();
                    
                })
                .catch(error => {
                    console.error('Error:', error);
                    hideLoading();  // Hide loading spinner in case of an error
                });
            }
        });

        //Form3
        document.getElementById('Vregime50').addEventListener('click', function() {
            if (confirm("Calculate and store into regime 50 table. Do you want to proceed?")) {
                showLoading();
                fetch('http://localhost/deforest/Calculate_Damage.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ regime: 'regime50' })
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data); // For debugging
                    alert("Stored Success! Click Next");
                    hideLoading();
                    
                })
                .catch(error => {
                    console.error('Error:', error);
                    hideLoading();  // Hide loading spinner in case of an error
                });
            }
        });

        document.getElementById('Vregime55').addEventListener('click', function() {
            if (confirm("Calculate and store into regime 55 table. Do you want to proceed?")) {
                showLoading();
                fetch('http://localhost/deforest/Calculate_Damage.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ regime: 'regime55' })
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data); // For debugging
                    alert("Stored Success! Click Next");
                    hideLoading();
                    
                })
                .catch(error => {
                    console.error('Error:', error);
                    hideLoading();  // Hide loading spinner in case of an error
                });
            }
        });

        document.getElementById('Vregime60').addEventListener('click', function() {
            if (confirm("Calculate and store into regime 60 table. Do you want to proceed?")) {
                showLoading();
                fetch('http://localhost/deforest/Calculate_Damage.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ regime: 'regime60' })
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data); // For debugging
                    alert("Stored Success! Click Next");
                    hideLoading();
                    
                })
                .catch(error => {
                    console.error('Error:', error);
                    hideLoading();  // Hide loading spinner in case of an error
                });
            }
        });

        document.getElementById('Vregime').addEventListener('click', function() {
            if (confirm("Calculate and store into regime 45 table. Do you want to proceed?")) {
                showLoading();
                fetch('http://localhost/deforest/Calculate_Damage.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ regime: 'regime' })
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data); // For debugging
                    alert("Stored Success! Click Next");
                    hideLoading();
                    
                })
                .catch(error => {
                    console.error('Error:', error);
                    hideLoading();  // Hide loading spinner in case of an error
                });
            }
        });

        //FOrm4
        document.getElementById('Gregime50').addEventListener('click', function() {
            if (confirm("Calculate and store into regime 50 table. Do you want to proceed?")) {
                showLoading();
                fetch('http://localhost/deforest/growth.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ regime: 'regime50' })
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data); // For debugging
                    alert("Stored Success! Click Next");
                    hideLoading();
                    
                })
                .catch(error => {
                    console.error('Error:', error);
                    hideLoading();  // Hide loading spinner in case of an error
                });
            }
        });

        document.getElementById('Gregime55').addEventListener('click', function() {
            if (confirm("Calculate and store into regime 55 table. Do you want to proceed?")) {
                showLoading();
                fetch('http://localhost/deforest/growth.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ regime: 'regime55' })
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data); // For debugging
                    alert("Stored Success! Click Next");
                    hideLoading();
                    
                })
                .catch(error => {
                    console.error('Error:', error);
                    hideLoading();  // Hide loading spinner in case of an error
                });
            }
        });

        document.getElementById('Gregime60').addEventListener('click', function() {
            if (confirm("Calculate and store into regime 60 table. Do you want to proceed?")) {
                showLoading();
                fetch('http://localhost/deforest/growth.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ regime: 'regime60' })
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data); // For debugging
                    alert("Stored Success! Click Next");
                    hideLoading();
                    
                })
                .catch(error => {
                    console.error('Error:', error);
                    hideLoading();  // Hide loading spinner in case of an error
                });
            }
        });

        document.getElementById('Gregime').addEventListener('click', function() {
            if (confirm("Calculate and store into regime 45 table. Do you want to proceed?")) {
                showLoading();
                fetch('http://localhost/deforest/growth.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ regime: 'regime' })
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data); // For debugging
                    alert("Stored Success! Click Next");
                    hideLoading();  // Ensure this is only called after the fetch completes
                })
                .catch(error => {
                    console.error('Error:', error);
                    hideLoading();  // Hide loading spinner in case of an error
                });
            }
        });



        function goToNextStep() {
            document.querySelector('.form-step-active').classList.remove('form-step-active');
            document.querySelectorAll('.form-step')[1].classList.add('form-step-active');
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

