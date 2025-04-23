<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QubeStat - Backend API</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            color: #333;
            background-color: #f5f5f5;
        }

        h1 {
            color: #6a1b9a;
            text-align: center;
            border-bottom: 2px solid #6a1b9a;
            padding-bottom: 10px;
        }

        .card {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            background-color: #6a1b9a;
            color: #fff;
            padding: 10px 15px;
            border-radius: 4px;
            text-decoration: none;
            margin-right: 10px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #8e24aa;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 0.9em;
        }
    </style>
</head>

<body>
    <h1>QubeStat - Backend API</h1>

    <div class="card">
        <h2>API Documentation</h2>
        <p>Explore the API endpoints and learn how to integrate with QubeStat services.</p>
        <a href="http://localhost/QubeStat/backend/api/docs"  class="btn">View API Documentation</a>
    </div>


    <div class="card">
        <h2>API Status</h2>
        <p>The QubeStat API is currently running.</p>
        <p>Server Time: <?php echo date('Y-m-d H:i:s'); ?></p>
        <p>Environment: <?php echo getenv('APP_ENV') ?: 'development'; ?></p>
    </div>

    <footer>
        &copy; <?php echo date('Y'); ?> QubeStat - Full Stack LAMP Architecture
    </footer>
</body>

</html>
