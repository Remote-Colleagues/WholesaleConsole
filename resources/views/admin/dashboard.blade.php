
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <script src="{{ asset('js/dashboard.js') }}" defer></script>
</head>
<body>
    <div class="dashboard-container">
        <div class="header">
            <h1>Partner</h1>
        </div>
        @if (session('success'))
            <p style="color: green; text-align: center;">{{ session('success') }}</p>
        @elseif (session('error'))
            <p style="color: red; text-align: center;">{{ session('error') }}</p>
        @endif
        <div class="main-content">
            <div class="sidebar">
                <div class="sidebar-menu">
                <a href="#">Auction Name</a><br><br>
                    <ul>
                        <li><a href="#">partner</a></li>
                        <li><a href="{{ route('consolers.create') }}">Consolers</a></li>
                        <li><a href="#">Promote your listing</a></li>
                        <li><a href="#">Upcoming Event</a></li>
                        <li><a href="#">Promote your event</a></li>
                        <li><a href="#">invoices</a></li>
                        <li><a href="#">Username</a></li>
                        <li><a href="#">Our Profiles</a></li>
                        <li><a href="#">Raise Tickets</a></li>
                        <li><a href="#">Terms and conditions</a></li>
                    </ul>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
            <div class="middle-section">
                <h2>Welcome to the Admin Dashboard</h2>
                <p>This is where you can manage all your admin-related tasks. Choose from the sidebar options to navigate.</p>              
            </div>
        </div>
    </div>
</body>
</html>
