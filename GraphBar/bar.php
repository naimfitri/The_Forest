<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Production Graph Bar</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --color-primary: #0073ff;
            --color-white: #ffffff;
            --color-black: #141d28;
            --color-light-grey: #f5f7fa;
            --shadow-color: rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--color-light-grey);
            color: var(--color-black);
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .menu-bar {
            background-color: var(--color-black);
            height: 60px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 5%;
            box-shadow: 0 2px 5px var(--shadow-color);
        }

        .menu-bar ul {
            list-style: none;
            display: flex;
        }

        .menu-bar ul li {
            padding: 0 15px;
        }

        .menu-bar ul li a {
            font-size: 16px;
            color: var(--color-white);
            text-decoration: none;
            transition: color 0.3s;
        }

        .menu-bar ul li a:hover {
            color: var(--color-primary);
        }

        .chart-container {
            width: 90%;
            max-width: 1200px;
            margin-top: 40px;
            padding: 20px;
            background-color: var(--color-white);
            border-radius: 12px;
            box-shadow: 0px 4px 10px var(--shadow-color);
            text-align: center;
        }

        .chart-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 20px;
            color: var(--color-black);
        }

        canvas {
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .chart-title {
                font-size: 22px;
            }

            .menu-bar ul li a {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
  <?php include_once("../nav.php"); ?>

    <div class="chart-container">
        <div class="chart-title">Production Graph Bar</div>
        <canvas id="regimeChart" width="800" height="400"></canvas>
    </div>

    <script>
        fetch('fetchdata.php')
            .then(response => response.json())
            .then(data => {
                const labels = Object.keys(data);
                const productionData = [];
                const production30Data = [];

                labels.forEach(label => {
                    const regimeGroup = data[label];
                    let productionSum = 0;
                    let production30Sum = 0;

                    regimeGroup.forEach(item => {
                        productionSum += parseFloat(item.Production || 0);
                        production30Sum += parseFloat(item.production30 || 0);
                    });

                    productionData.push(productionSum);
                    production30Data.push(production30Sum);
                });

                const ctx = document.getElementById('regimeChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Production To Year 0',
                                data: productionData,
                                backgroundColor: 'rgba(75, 192, 192, 0.8)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1,
                                borderRadius: 4
                            },
                            {
                                label: 'Production To Year 30',
                                data: production30Data,
                                backgroundColor: 'rgba(153, 102, 255, 0.8)',
                                borderColor: 'rgba(153, 102, 255, 1)',
                                borderWidth: 1,
                                borderRadius: 4
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    font: {
                                        size: 14
                                    }
                                }
                            },
                            tooltip: {
                                enabled: true
                            },
                            datalabels: {
                                anchor: 'end',
                                align: 'top',
                                formatter: (value) => value,
                                font: {
                                    weight: 'bold'
                                },
                                color: '#000'
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Cutting Size',
                                    font: {
                                        size: 16,
                                        weight: '500'
                                    }
                                },
                                ticks: {
                                    font: {
                                        size: 14
                                    }
                                }
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Trees',
                                    font: {
                                        size: 16,
                                        weight: '500'
                                    }
                                },
                                ticks: {
                                    font: {
                                        size: 14
                                    }
                                }
                            }
                        }
                    },
                    plugins: [ChartDataLabels]
                });
            })
            .catch(error => console.error('Error fetching data:', error));
    </script>
</body>
</html>
