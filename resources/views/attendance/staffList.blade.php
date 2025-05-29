<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Staff List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- FontAwesome for icons -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
      rel="stylesheet"
    />
    <style>
      /* Navigation menu */
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
        transition: color 0.3s ease;
      }
      .menu-list li.active a {
        color: #ffcc00;
      }
      .menu-list li:hover a {
        color: #ccc;
      }

      /* Container styling */
      .container {
        margin-top: 40px;
        max-width: 1200px;
        box-shadow: 0 4px 12px rgb(0 0 0 / 0.1);
        background-color: #fff;
        border-radius: 8px;
        padding: 20px;
      }

      /* Table Styling */
      table {
        border-collapse: separate;
        border-spacing: 0 8px; /* Adds vertical spacing between rows */
      }
      thead th {
        background-color:rgb(86, 167, 228) !important;
        color: #fff !important;
        font-weight: 600;
        border: none;

        }
      tbody tr {
        background-color: #ffffff;
        transition: background-color 0.2s ease;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgb(0 0 0 / 0.05);
      }
      tbody tr:hover {
        background-color: #f1f1f1;
      }
      tbody tr td {
        vertical-align: middle !important;
        padding: 10px 12px;
        border: none;
      }

      input.form-control {
        height: 38px;
        font-size: 14px;
        border-radius: 5px;
      }

      button.btn-sm {
        min-width: 70px;
        font-size: 14px;
        cursor: pointer;
      }

      /* Spacing between buttons */
      .btn-group {
        display: flex;
        gap: 8px;
        justify-content: center;
      }

      /* Responsive tweaks */
      @media (max-width: 768px) {
        .menu-list {
          flex-direction: column;
          padding-left: 0;
        }
        .menu-list li {
          margin-bottom: 10px;
          margin-right: 0;
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
          title: 'Oops...',
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

    <!-- Main Content -->
    <div class="container">
      <table class="table table-borderless table-hover text-center">
        <thead>
          <tr>
            <th>No. #</th>
            <th>ID Number</th>
            <th>Firstname</th>
            <th>Middle Initial</th>
            <th>Lastname</th>
            <th>Department</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($staff_list as $index => $staff)
          <tr>
            <form action="{{ route('attendance.staffListEdit', $staff->id) }}" method="POST" class="d-flex align-items-center">
              @csrf
              <td class="align-middle">{{ $index + 1 }}</td>
              <td><input type="text" name="id_number" value="{{ $staff->id_number }}" class="form-control"></td>
              <td><input type="text" name="first" value="{{ $staff->first }}" class="form-control"></td>
              <td><input type="text" name="middle" value="{{ $staff->middle }}" class="form-control"></td>
              <td><input type="text" name="last" value="{{ $staff->last }}" class="form-control"></td>
              <td><input type="text" name="department" value="{{ $staff->department }}" class="form-control"></td>
              <td>
                <div class="btn-group">
                  <button type="submit" class="btn btn-sm btn-primary" title="Edit Staff">
                    <i class="fas fa-edit"></i> Edit
                  </button>
                </form>

                <form action="{{ route('attendance.staffLists', $staff->id) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE') <!-- Use DELETE method -->
                  <button type="submit" class="btn btn-sm btn-danger" title="Delete Staff" onclick="return confirm('Are you sure you want to delete this staff?');">
                    <i class="fas fa-trash-alt"></i> Delete
                  </button>
                </form>
                </div>
              </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
