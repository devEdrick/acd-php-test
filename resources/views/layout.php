<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your App Title</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/assets/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Other CSS styles -->
    <style>
        /* Custom styles */
    </style>
</head>
<body>
    <!-- Navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Call Logs</a>
        <!-- Add navigation links as needed -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/calls">Calls</a>
                </li>
                <!-- Add more navigation items if required -->
            </ul>
        </div>
    </nav>

    <!-- Main content area -->
    <div class="container mt-4">
        <?= $content ?>
    </div>

    <!-- Bootstrap JS and any additional JS -->
    <script src="/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
