<!-- @extends('components.layouts') -->



<nav class="menu">
    <ul class="menu-list">
        <li>
                <a href="{{ url('/dashboard') }}">Home</a>
            </li>
            <li >
                <a href="{{ url('/staff/list') }}">Staff List</a>
            </li>
            <li >
                <a href="{{ url('/staff/logs') }}">Logs</a>
            </li>
            <li >
                <a href="{{ url('/entry') }}">Add New Staff</a>
            </li>
            <li><a href="{{ url('/logout') }}">Log Out</a></li>
    </ul>
</nav>

<table class="center table table-bordered mt-4">
    <thead>
        <tr>
            <th>No. #</th>
            <th>ID Number</th>
            <th>Time In</th>
            <th>Time Out</th>
        </tr>
    </thead>
    <tbody>
        @foreach($staff_list as $index => $staff)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $staff->id_number }}</td>
            <td>{{ \Carbon\Carbon::parse($staff->time_in)->format('F j, Y g:i a') }}</td>
            <td>{{ \Carbon\Carbon::parse($staff->time_out)->format('F j, Y g:i a') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>



@section('styles')
<style>
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

.center {
    margin: 0 auto;
    text-align: center;
}
</style>
@endsection
