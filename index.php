<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Advanced Grading System for efficient grading, packaging, and transportation of agricultural products.">
    <meta name="author" content="Your Team">
    <meta name="keywords" content="Grading, Packaging, Transport, Agricultural System">
    <title>Advanced Grading System</title>
    
    <!-- Bootstrap 5 CSS for layout & responsiveness -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts for Typography -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    
    <!-- Icon Pack for Stylish UI -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <style>
        /* General Reset */
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #212529;
        }

        /* Navbar Styles */
        .navbar {
            padding: 0.8rem 1rem;
            transition: background 0.3s ease;
        }

        .navbar-brand img {
            max-height: 50px;
        }

        .navbar .nav-link {
            font-size: 16px;
            padding: 0.5rem 1rem;
            transition: color 0.3s ease;
        }

        .navbar .nav-link:hover {
            color: #f8c303;
        }

        .navbar.sticky {
            background: rgba(0, 0, 0, 0.9);
        }

        /* Hero Section */
        .hero {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: #fff;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .hero p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
        }

        .hero .btn {
            font-size: 1rem;
            font-weight: 600;
            padding: 0.8rem 1.5rem;
            background: #f8c303;
            color: #000;
            border: none;
            border-radius: 30px;
            transition: all 0.3s ease;
        }

        .hero .btn:hover {
            background: #d0a700;
            color: #fff;
        }

        /* Features Section */
        .card {
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .card-text {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .btn-primary {
            background: #007bff;
            border: none;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .btn-primary:hover {
            background: #0056b3;
        }

        /* Report Section */
        .report-card {
            border: none;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .report-card:hover {
            transform: translateY(-10px);
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.15);
        }

        /* Footer */
        footer {
            background: #212529;
            color: #fff;
            padding: 20px 0;
            font-size: 0.9rem;
        }

        footer p {
            margin: 0;
            line-height: 1.5;
        }

        footer .text-danger {
            color: #e3342f !important;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .btn {
                font-size: 0.875rem;
            }

            .card {
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="assets/img/logo.png" alt="Grading System" class="img-fluid">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="grading/index.php">Grading</a></li>
                    <li class="nav-item"><a class="nav-link" href="packaging/index.php">Packaging</a></li>
                    <li class="nav-item"><a class="nav-link" href="transport/index.php">Transport</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item"><a class="nav-link" href="auth/logout.php">Logout</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="auth/login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" style="background: url('https://images7.alphacoders.com/428/thumb-1920-428202.jpg') no-repeat center center/cover;">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">Welcome to the Advanced Grading System</h1>
            <p class="lead mb-4">Efficiently manage grading, packaging, and transportation of agricultural products.</p>
            <a href="grading/index.php" class="btn btn-light btn-lg"><i class="fas fa-check-circle"></i> Start Grading</a>
        </div>
    </section>

    <!-- Report Section -->
    <section class="container py-5">
        <div class="row text-center">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card report-card shadow-sm border-0 rounded">
                    <div class="card-body">
                        <h5 class="card-title">View Reports</h5>
                        <p class="card-text">Access and view detailed reports on grading, packaging, and transport activities.</p>
                        <a href="report/index.php" class="btn btn-primary">View Report</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4 mt-5">
        <div class="container">
            <p class="mb-0">© 2024 Grading System. All Rights Reserved.</p>
            <p>Designed with <span class="text-danger">❤</span> by Your Team</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animation when user scrolls down
        window.addEventListener('scroll', function() {
            const header = document.querySelector('nav');
            header.classList.toggle('sticky', window.scrollY > 0);
        });
    </script>
</body>
</html>
