<?php include_once("../nav.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forest Volume Analysis</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <style>
        /* Root variables for consistent theme colors */
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

        /* Global resets */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styling */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--color-light-grey);
            color: var(--color-black);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-bottom: 60px;
        }

        /* Page header styling */
        .page-header {
            width: 100%;
            text-align: center;
            padding: 40px 20px 20px;
            background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);
            color: var(--color-white);
            margin-bottom: 30px;
            box-shadow: 0 4px 6px var(--shadow-color);
        }

        .page-header h1 {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        /* Controls container styling */
        .controls-container {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 20px;
            width: 90%;
            max-width: 1200px;
            margin: 0 auto 30px;
            padding: 25px;
            background-color: var(--color-white);
            border-radius: 12px;
            box-shadow: 0 4px 15px var(--shadow-color);
        }

        .select-wrapper {
            position: relative;
            min-width: 200px;
        }

        .select-wrapper select {
            appearance: none;
            width: 100%;
            padding: 12px 20px;
            font-size: 16px;
            font-family: 'Poppins', sans-serif;
            background-color: var(--color-light-grey);
            border: 2px solid var(--color-mid-grey);
            border-radius: 8px;
            color: var(--color-black);
            cursor: pointer;
            transition: var(--transition);
        }

        .select-wrapper::after {
            content: '\f107';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--color-primary);
            pointer-events: none;
        }

        .select-wrapper select:focus,
        .select-wrapper select:hover {
            border-color: var(--color-primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(46, 204, 113, 0.2);
        }

        .btn {
            background: var(--color-primary);
            color: var(--color-white);
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn:hover {
            background: var(--color-primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn i {
            font-size: 18px;
        }

        /* Chart container styling */
        .chart-container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto 40px;
            padding: 30px;
            background-color: var(--color-white);
            border-radius: 12px;
            box-shadow: 0 4px 15px var(--shadow-color);
            text-align: center;
            transition: var(--transition);
        }

        .chart-container:hover {
            box-shadow: 0 8px 25px var(--shadow-color);
        }

        .chart-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 25px;
            color: var(--color-black);
            position: relative;
            display: inline-block;
        }

        .chart-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: var(--color-primary);
            border-radius: 2px;
        }

        /* Sustainability result styling */
        .sustainability-result {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 25px;
            background-color: var(--color-white);
            border-radius: 12px;
            box-shadow: 0 4px 15px var(--shadow-color);
            transition: var(--transition);
        }
        
        .sustainability-result:hover {
            box-shadow: 0 8px 25px var(--shadow-color);
        }
        
        .sustainability-result h3 {
            color: var(--color-primary-dark);
            margin-bottom: 15px;
            font-size: 20px;
            font-weight: 600;
        }
        
        #comparisonResult {
            margin-bottom: 20px;
            line-height: 1.7;
            color: var(--color-black);
            font-size: 15px;
        }
        
        #conclusion {
            background: linear-gradient(to right, rgba(46, 204, 113, 0.1), rgba(52, 152, 219, 0.1));
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid var(--color-primary);
            font-size: 16px;
            line-height: 1.8;
        }
        
        /* Loading indicator */
        .loading-indicator {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }
        
        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid rgba(46, 204, 113, 0.3);
            border-radius: 50%;
            border-top-color: #2ecc71;
            animation: spin 1s ease-in-out infinite;
            margin-bottom: 15px;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Volume unit info */
        .volume-unit {
            font-size: 14px;
            color: var(--color-black);
            opacity: 0.7;
            margin-top: 15px;
            text-align: center;
            font-style: italic;
        }

        /* Responsive styling */
        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 26px;
            }
            
            .controls-container {
                flex-direction: column;
                align-items: stretch;
                padding: 20px;
            }
            
            .select-wrapper {
                width: 100%;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
            
            .chart-title {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Include navigation bar -->
    
    <!-- Header Section -->
    <div class="page-header">
        <h1>Forest Volume Analysis</h1>
        <p>Compare wood volume production across different regimes</p>
    </div>

    <!-- Controls Section -->
    <div class="controls-container">
        <div class="select-wrapper">
            <select id="table">
                <option value="new_forest">Regime 45</option>
                <option value="new_forest_50">Regime 50</option>
                <option value="new_forest_55">Regime 55</option>
                <option value="new_forest_60">Regime 60</option>
            </select>
        </div>
        <button class="btn" onclick="fetchAndRenderGraph()">
            <i class="fas fa-chart-bar"></i> Generate Graph
        </button>
    </div>

    <!-- Chart Section -->
    <div class="chart-container">
        <div class="chart-title">Volume Production Comparison</div>
        <canvas id="barChart" width="400" height="200"></canvas>
        <div class="volume-unit">* Volume measured in cubic meters (m³)</div>
    </div>

    <!-- Results Section -->
    <div class="sustainability-result">
        <h3>Sustainability Analysis</h3>
        <p id="comparisonResult"></p>
        <div id="conclusion"></div>
    </div>

    <script>
    let chart; // To hold the Chart.js instance

    /**
     * Fetch data from the server and render the graph.
     */
    async function fetchAndRenderGraph() {
        const table = document.getElementById('table').value; // Get selected table
        
        // Show loading indicator
        const chartContainer = document.querySelector('.chart-container');
        chartContainer.innerHTML = `
            <div class="chart-title">Volume Production Comparison</div>
            <div class="loading-indicator">
                <div class="spinner"></div>
                <p>Loading volume data...</p>
            </div>
            <div class="volume-unit">* Volume measured in cubic meters (m³)</div>
        `;
        
        try {
            // Fetch data from backend
            const response = await fetch(`fetchdatavolume.php?table=${table}`);
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const data = await response.json();

            if (data.error) {
                throw new Error(data.error);
            }

            // Restore chart canvas
            chartContainer.innerHTML = `
                <div class="chart-title">Volume Production Comparison</div>
                <canvas id="barChart" width="400" height="200"></canvas>
                <div class="volume-unit">* Volume measured in cubic meters (m³)</div>
            `;

            // Prepare chart data with enhanced colors
            const chartData = {
                labels: ['Regime 45', 'Regime 50', 'Regime 55', 'Regime 60'],
                datasets: [
                    {
                        label: 'Volume Year 0',
                        data: [
                            data.Sum_Volume_Production,
                            data.Sum_Volume_Production,
                            data.Sum_Volume_Production,
                            data.Sum_Volume_Production,
                        ],
                        backgroundColor: 'rgba(46, 204, 113, 0.7)',
                        borderColor: 'rgba(39, 174, 96, 1)',
                        borderWidth: 1,
                    },
                    {
                        label: 'Volume Year 30',
                        data: [
                            data.Sum_Volume30_3045,
                            data.Sum_Volume30_3050,
                            data.Sum_Volume30_3055,
                            data.Sum_Volume30_3060,
                        ],
                        backgroundColor: 'rgba(52, 152, 219, 0.7)',
                        borderColor: 'rgba(41, 128, 185, 1)',
                        borderWidth: 1,
                    },
                ],
            };

            // Calculate Rate of Change (slope) for each regime
            const productionAt0 = [
                data.Sum_Volume_Production,
                data.Sum_Volume_Production,
                data.Sum_Volume_Production,
                data.Sum_Volume_Production
            ];

            const productionAt30 = [
                data.Sum_Volume30_3045,
                data.Sum_Volume30_3050,
                data.Sum_Volume30_3055,
                data.Sum_Volume30_3060
            ];

            let rateOfChange = [];

            // Loop to calculate the rate of change for each regime
            for (let i = 0; i < 4; i++) {
                const P0 = productionAt0[i];
                const P30 = productionAt30[i];
                const rate = (P30 - P0) / 30;
                rateOfChange.push(rate);
            }

            // Sort rates and compare them
            const regimes = ['Regime 45', 'Regime 50', 'Regime 55', 'Regime 60'];
            const ratesWithRegimes = rateOfChange.map((rate, index) => ({
                regime: regimes[index],
                rate: rate.toFixed(2)
            }));

            // Sort by the rate of change
            ratesWithRegimes.sort((a, b) => b.rate - a.rate);

            // Generate comparison text with better formatting
            let comparisonText = '<ul style="list-style-type: none; padding: 0;">';
            ratesWithRegimes.forEach((item, index) => {
                comparisonText += `<li style="margin-bottom: 10px; padding-left: 20px; position: relative;">
                    <span style="position: absolute; left: 0; color: #27ae60;"><i class="fas fa-circle"></i></span>
                    <strong>${item.regime}</strong> has a rate of change of <span style="color: #2980b9; font-weight: 500;">${item.rate} m³ per year</span>
                </li>`;
            });
            comparisonText += '</ul>';

            // Enhanced conclusion with better formatting
            const conclusion = `
                <p style="margin-bottom: 15px;"><strong style="color: var(--color-primary-dark);">${ratesWithRegimes[0].regime}</strong> demonstrates the highest volume increase at <strong>${ratesWithRegimes[0].rate} m³ per year</strong>, indicating the most productive growth over the 30-year period.</p>
                
                <p style="margin-bottom: 15px;"><strong style="color: var(--color-secondary);">${ratesWithRegimes[1].regime}</strong> shows a moderate volume increase (${ratesWithRegimes[1].rate} m³ per year).</p>
                
                <p><strong>${ratesWithRegimes[3].regime}</strong> shows the lowest volume increase (${ratesWithRegimes[3].rate} m³ per year), suggesting it may be the least productive option for long-term forest management.</p>`;

            // Display the result
            document.getElementById('comparisonResult').innerHTML = comparisonText;
            document.getElementById('conclusion').innerHTML = conclusion;

            // Render chart with enhanced options
            const ctx = document.getElementById('barChart').getContext('2d');

            if (chart) {
                chart.destroy(); // Destroy existing chart if any
            }

            chart = new Chart(ctx, {
                type: 'bar',
                data: chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                font: {
                                    family: "'Poppins', sans-serif",
                                    size: 14
                                },
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'rectRounded'
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(44, 62, 80, 0.9)',
                            titleColor: '#ffffff',
                            bodyColor: '#ffffff',
                            bodyFont: {
                                family: "'Poppins', sans-serif"
                            },
                            titleFont: {
                                family: "'Poppins', sans-serif",
                                weight: 'bold'
                            },
                            padding: 12,
                            cornerRadius: 6,
                            displayColors: true,
                            borderColor: 'rgba(255, 255, 255, 0.2)',
                            borderWidth: 1
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    family: "'Poppins', sans-serif"
                                },
                                color: '#2c3e50'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)',
                                lineWidth: 1
                            },
                            ticks: {
                                font: {
                                    family: "'Poppins', sans-serif"
                                },
                                color: '#2c3e50',
                                callback: function(value) {
                                    return value + ' m³';
                                }
                            },
                            title: {
                                display: true,
                                text: 'Volume (cubic meters)',
                                font: {
                                    family: "'Poppins', sans-serif",
                                    size: 14,
                                    weight: 'bold'
                                },
                                color: '#2c3e50',
                                padding: {top: 10, bottom: 10}
                            }
                        }
                    },
                    animation: {
                        duration: 1500,
                        easing: 'easeOutQuart'
                    },
                    layout: {
                        padding: 20
                    },
                    elements: {
                        bar: {
                            borderRadius: 6
                        }
                    }
                },
            });

        } catch (error) {
            console.error('Error:', error);
            
            // Show elegant error message
            chartContainer.innerHTML = `
                <div class="chart-title">Volume Production Comparison</div>
                <div style="text-align: center; padding: 30px; color: #e74c3c;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 15px;">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <h3 style="font-size: 20px; margin-bottom: 10px;">Unable to Load Data</h3>
                    <p style="color: #7f8c8d; margin-top: 5px; font-size: 16px;">${error.message}</p>
                    <button onclick="fetchAndRenderGraph()" style="margin-top: 20px; background: #3498db; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-family: 'Poppins', sans-serif;">
                        Try Again
                    </button>
                </div>
                <div class="volume-unit">* Volume measured in cubic meters (m³)</div>
            `;
            
            // Clear results
            document.getElementById('comparisonResult').innerHTML = '';
            document.getElementById('conclusion').innerHTML = '';
        }
    }
    
    // Automatically load the graph when the page loads
    document.addEventListener('DOMContentLoaded', function() {
        fetchAndRenderGraph();
    });
</script>
</body>
</html>
