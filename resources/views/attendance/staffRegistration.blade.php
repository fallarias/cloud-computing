<!DOCTYPE html>
<html>
<head>
    <title>Staff Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4"></script>
    <style>
    body {
        background-color: #f5f7fa; /* Soft light blue-gray */
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .menu {
        background-color: #333;
        padding: 10px 20px;
    }

    .menu-list {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .menu-list li {
        margin: 0 10px;
    }

    .menu-list li a {
        color: white;
        text-decoration: none;
        font-weight: bold;
    }

    .menu-list li.active a {
        color: #ffcc00;
    }

    .menu-list li:hover a {
        color: #ccc;
    }

    .form-container {
        margin-top: 50px;
    }

    .card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        background-color: white; /* Ensure card stays white */
    }

    .card-body {
        padding: 30px;
    }

    .form-control {
        margin-bottom: 15px;
    }

    .btn-primary {
        width: 100%;
        padding: 10px;
    }

    label {
        font-weight: 600;
    }
    label {
    font-weight: 600;
    margin-top: 10px;      /* space above each label */
    display: block;        /* make sure label takes full width */
}

.form-control {
    margin-bottom: 20px;   /* space below each input */
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
<nav class="menu">
    <ul class="menu-list">
            <li><a href="{{ url('/dashboard') }}">Home</a></li>
            <li><a href="{{ url('/staff/list') }}">Staff List</a></li>
            <li><a href="{{ url('/staff/logs') }}">Logs</a></li>
            <li><a href="{{ url('/entry') }}">Add New Staff</a></li>
            <li><a href="{{ url('/logout') }}">Log Out</a></li>
        </ul>
</nav>

<div class="container form-container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white text-center rounded-top">
                    <h5 class="mb-0">Staff Registration</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('attendance.staffRegistration') }}">
                        @csrf
                        <label for="id">ID Number:</label>
                        <input type="text" name="id" id="id" placeholder="ID Number" class="form-control" required>

                        <label for="first">First Name:</label>
                        <input type="text" name="first" id="first" placeholder="First Name" class="form-control" required>

                        <label for="last">Last Name:</label>
                        <input type="text" name="last" id="last" placeholder="Last Name" class="form-control" required>

                        <label for="middle">Middle Initial:</label>
                        <input type="text" name="middle" id="middle" placeholder="Middle Initial" class="form-control" required>

                        <label for="department">Department:</label>
                        <input type="text" name="department" id="department" placeholder="Department" class="form-control" required>

                        <button type="submit" class="btn btn-primary mt-3">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
