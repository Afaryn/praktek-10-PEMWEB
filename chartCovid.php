<?php
// Koneksi ke database
$host = 'localhost';
$username = 'root';
$password = 'admin';
$database = 'covid_data';

$koneksi = mysqli_connect($host, $username, $password, $database);

// Mengambil data Total Cases dari 10 negara
$query = mysqli_query($koneksi, "SELECT Country, TotalCases FROM covid_stats ORDER BY TotalCases DESC LIMIT 10");

$labels = array();
$data = array();

while ($row = mysqli_fetch_assoc($query)) {
    $labels[] = $row['Country'];
    $data[] = $row['TotalCases'];
}

// Mengonversi data menjadi format JSON
$labels_json = json_encode($labels);
$data_json = json_encode($data);

mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Membuat Grafik Menggunakan Chart.js</title>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div style="width: 800px; height: 800px;">
        <!-- Bar Chart -->
        <canvas id="barChart"></canvas>
    </div>

    <div style="width: 800px; height: 800px;">
        <!-- Pie Chart -->
        <canvas id="pieChart"></canvas>
    </div>

    <script>
        // Bar Chart
        var ctxBar = document.getElementById("barChart").getContext('2d');
        var barChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: <?php echo $labels_json; ?>,
                datasets: [{
                    label: 'Total Cases',
                    data: <?php echo $data_json; ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Pie Chart
        var ctxPie = document.getElementById("pieChart").getContext('2d');
        var pieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: <?php echo $labels_json; ?>,
                datasets: [{
                    label: 'Total Cases',
                    data: <?php echo $data_json; ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                        'rgba(255, 159, 64, 0.5)',
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            }
        });
    </script>
</body>
</html>
