<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Time In / Out</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body {
      background: linear-gradient(to right, #e0f7fa, #e1f5fe);
      font-family: 'Roboto', sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
    }

    .card {
      border: none;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .form-control {
      border-radius: 10px;
      font-size: 1.1rem;
    }

    .btn {
      font-size: 1.1rem;
      border-radius: 10px;
    }

    .btn-success {
      background-color: #43a047;
    }

    .btn-danger {
      background-color: #e53935;
    }

    label {
      font-weight: bold;
    }

    .student-info {
      background-color: #f1f8e9;
      padding: 15px;
      border-radius: 10px;
      margin-top: 15px;
      text-align: left;
    }

    .image-box {
  position: fixed; /* fixed so it stays on top-left even on scroll */
  top: 20px;       /* add some spacing from top */
  left: 20px;      /* add some spacing from left */
  z-index: 1000;   /* ensure it's on top */
}

.image-box .btn {
  font-size: 1.2rem;
  padding: 10px 20px;
}

.logo {
  width: 250px;  /* bigger */
  height: 250px; /* bigger */
  margin: 0 auto 40px auto; /* center horizontally with bigger bottom margin */

}

.card {
  border-radius: 25px;
  box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
  padding: 40px 50px;
}

.form-control {
  font-size: 1.3rem;
  padding: 15px 10px;
  border-radius: 12px;
}

.btn {
  font-size: 1.3rem;
  padding: 12px 0;
  border-radius: 12px;
}

.col-lg-6 {
  max-width: 600px; /* increase container width for form and image */
}


  </style>
</head>
<body>
  <div class="container">
    <div class="image-box">
      <a href="{{ route('attendance.login') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Back
      </a>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-6 text-center">
        <img src="{{ asset('FINAL_SEAL.png') }}" alt="Logo" class="logo mb-4" />

        <!-- SweetAlert Feedback -->
        @if(session('message'))
        <script>
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: @json(session('message')),
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

        @if(session('success'))
        <script>
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: @json(session('success')),
            confirmButtonText: 'OK'
          });
        </script>
        @endif

        <div class="card p-4">
          <h4 class="mb-4 fw-bold">Student Time In / Out</h4>

          <div class="mb-3">
            <label for="shared_id" class="form-label">ID Number</label>
            <input type="text" id="shared_id" class="form-control text-center" placeholder="Enter your ID" required>
          </div>

          <div class="row">
            <div class="col-md-6 mb-2">
              <form method="POST" action="{{ url('/time-in') }}" onsubmit="return attachId(this)">
                @csrf
                <input type="hidden" name="id">
                <button type="submit" class="btn btn-success w-100">
                  <i class="fas fa-sign-in-alt"></i> Time In
                </button>
              </form>
            </div>

            <div class="col-md-6 mb-2">
              <form method="POST" action="{{ url('/time-out') }}" onsubmit="return attachId(this)">
                @csrf
                <input type="hidden" name="id">
                <button type="submit" class="btn btn-danger w-100">
                  <i class="fas fa-sign-out-alt"></i> Time Out
                </button>
              </form>
            </div>
          </div>

          @if(session('student'))
          <div class="student-info">
            <p class="mb-1"><strong>{{ session('student.last') }}, {{ session('student.first') }}</strong></p>
            <p class="mb-0">{{ session('student.department') }} - {{ session('student.id_number') }}</p>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  <script>
    function attachId(form) {
      const sharedId = document.getElementById('shared_id').value.trim();
      if (!sharedId) {
        Swal.fire({
          icon: 'warning',
          title: 'Missing ID',
          text: 'Please enter your ID number.',
          confirmButtonText: 'OK'
        });
        return false;
      }
      form.querySelector('input[name="id"]').value = sharedId;
      return true;
    }
  </script>
</body>
</html>
