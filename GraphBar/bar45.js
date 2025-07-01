// Fetch data from the backend
async function fetchData() {
    const response = await fetch("fetchdata.php"); // Replace with your PHP file URL
    return await response.json();
}

// Render the chart
async function renderChart() {
    const data = await fetchData();

    // Data for the chart
    const chartData = {
        labels: ["Regime 45", "Regime 50", "Regime 55", "Regime 60"],
        datasets: [
            {
                label: "Production",
                data: [
                    data.Production, // Production for all regimes
                    data.Production,
                    data.Production,
                    data.Production,
                ],
                backgroundColor: "rgba(75, 192, 192, 0.6)",
                borderColor: "rgba(75, 192, 192, 1)",
                borderWidth: 1,
            },
            {
                label: "Regime-Specific Production",
                data: [
                    data.production3045, // Regime 45
                    data.production3050, // Regime 50
                    data.production3055, // Regime 55
                    data.production3060, // Regime 60
                ],
                backgroundColor: "rgba(153, 102, 255, 0.6)",
                borderColor: "rgba(153, 102, 255, 1)",
                borderWidth: 1,
            },
        ],
    };

    // Chart configuration
    const config = {
        type: "bar",
        data: chartData,
        options: {
            responsive: true,
            scales: {
                x: {
                    beginAtZero: true,
                },
                y: {
                    beginAtZero: true,
                },
            },
        },
    };

    // Render the chart
    const ctx = document.getElementById("barChart").getContext("2d");
    new Chart(ctx, config);
}

// Call the render function
renderChart();
