<!-- Optional Layout Include -->
{{-- @extends('components.layouts') --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CDN (for basic styles and responsiveness) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4"></script>
    <style>
        /* Menu Styling */
        .menu {
            background-color: #333;
            padding: 12px 20px;
        }

        .menu-list {
            display: flex;
            flex-wrap: wrap;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .menu-list li {
            margin-right: 20px;
        }

        .menu-list li a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            font-size: 16px;
        }

        .menu-list li.active a {
            color: #ffcc00;
        }

        .menu-list li:hover a {
            color: #ccc;
        }

        /* Table Styling */
        .container {
            margin-top: 40px;
        }

        table {
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        td, th {
            vertical-align: middle !important;
        }

        input.form-control {
            height: 38px;
            font-size: 14px;
        }
        .center {
    margin: 0 auto;
    text-align: center;
}
#lineChart {
    max-width: 1000px;
    max-height: 700px;
}

#chart-container {
    width: 70%;
    margin: 30px auto;
}

        /* Responsive Tweaks */
        @media (max-width: 768px) {
            .menu-list {
                flex-direction: column;
            }

            .menu-list li {
                margin-bottom: 10px;
            }

            table {
                font-size: 14px;
            }

            input.form-control {
                font-size: 13px;
            }
        }
    </style>
</head>
<body>
@if(session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Great...',
                    text: @json(session('success')),
                    confirmButtonText: 'OK'
                });
            </script>
    @endif
    @if(session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Opps...',
                    text: @json(session('error')),
                    confirmButtonText: 'OK'
                });
            </script>
    @endif
    <!-- Navigation Menu -->
    <nav class="menu">
        <ul class="menu-list">
            <li><a href="{{ url('/dashboard') }}">Home</a></li>
            <li><a href="{{ url('/staff/list') }}">Staff List</a></li>
            <li><a href="{{ url('/staff/logs') }}">Logs</a></li>
            <li><a href="{{ url('/entry') }}">Add New Staff</a></li>
            <li><a href="{{ url('/logout') }}">Log Out</a></li>
        </ul>
    </nav>

<!-- Chart Title -->
<h1 class="center mt-4">Bar Chart</h1>

<!-- Chart -->
<div id="chart-container">
    <canvas id="lineChart"></canvas>
</div>

</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = @json($labels);
    const data = @json($data);

    const ctx = document.getElementById('lineChart').getContext('2d');
    const lineChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Staff Attendance Data',
                data: data,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                barThickness: 20,  // fixed smaller bar width
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // lets you control size manually
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                },
                x: {
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            }
        }
    });
</script>

