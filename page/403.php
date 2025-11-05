<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .error-container {
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .error-code {
            font-size: 8rem;
            font-weight: 700;
            color: #2563eb;
        }

        .error-message {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: #4b5563;
        }

        .error-description {
            font-size: 1rem;
            color: #6b7280;
            margin-bottom: 30px;
        }

        .btn-home {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-home:hover {
            background: linear-gradient(135deg, #4f46e5, #4338ca);
            transform: translateY(-2px);
        }

        .fa-exclamation-triangle {
            color: #dc2626;
            margin-right: 10px;
        }

        @media (max-width: 576px) {
            .error-code {
                font-size: 5rem;
            }

            .error-message {
                font-size: 1.2rem;
            }
        }
    </style>
</head>

<body>

    <div class="error-container">
        <div class="error-code">404</div>
        <div class="error-message"><i class="fas fa-exclamation-triangle"></i> Page Not Found</div>
        <div class="error-description">
            Oops! The page you are looking for does not exist or has been moved.
        </div