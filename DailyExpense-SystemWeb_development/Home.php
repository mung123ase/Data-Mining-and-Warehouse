<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Finance Tracker</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
            color: #333;
        }

        /* Navbar */
        nav {
            background-color: #2C3E50;
            padding: 15px 40px; /* Increased padding for spacing */
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        nav .logo {
            display: flex;
            align-items: center;
        }

        nav .logo img {
            width: 50px;
            margin-right: 10px;
        }

        nav .logo-text {
            font-size: 1.6rem;
            color: white;
            font-weight: bold;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        nav ul li {
            margin-left: 30px;
        }

        nav ul li a {
            color: white;
            font-size: 1.1rem;
            text-decoration: none;
            padding: 8px 15px;
            transition: background-color 0.3s ease;
        }

        nav ul li a:hover {
            background-color: #18BC9C;
            border-radius: 5px;
        }

        /* Home Section */
        .home-content {
            background: url('banner-bg.jpg') no-repeat center center/cover;
            color: white;
            text-align: center;
            padding: 150px 20px;
            box-shadow: inset 0 0 0 1000px rgba(0, 0, 0, 0.5);
        }

        .home-banner h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            letter-spacing: 2px;
        }

        .home-banner p {
            font-size: 1.4rem;
            margin-bottom: 40px;
            max-width: 700px;
            margin: auto;
        }

        .btn-start {
            background-color: #18BC9C;
            padding: 12px 25px; /* Increased padding for emphasis */
            border-radius: 30px;
            font-size: 1rem;
            font-weight: bold;
            transition: all 0.3s ease;
            margin: 10px;
        }

        .btn-start a {
            text-decoration: none;
            color: white;
        }

        .btn-start:hover {
            background-color: #16A085;
        }

        /* Features Section */
        .features {
            display: flex;
            justify-content: space-around;
            padding: 60px 40px; /* Padding adjusted for balanced spacing */
            background-color: #fff;
            flex-wrap: wrap;
            text-align: center;
            gap: 30px; /* Adds spacing between items */
        }

        .feature {
            width: 22%;
            margin: 20px 0;
            padding: 30px;
            background-color: #f7f7f7;
            border: 1px solid #ddd;
            border-radius: 10px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .feature:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .feature h2 {
            font-size: 1.8rem;
            color: #18BC9C;
            margin-bottom: 15px;
        }

        .feature p {
            font-size: 1rem;
            color: #555;
            margin: 0;
            padding: 0 10px;
        }

        /* Footer */
        .footer {
            background-color: #2C3E50;
            color: white;
            padding: 40px 0;
            text-align: center;
        }

        .footer h3 {
            color: #18BC9C;
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .footer-section {
            margin-bottom: 30px;
        }

        .footer-section p {
            font-size: 1rem;
            color: #ddd;
            max-width: 600px;
            margin: auto;
        }

        .footer ul {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .footer ul li a {
            color: #ddd;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer ul li a:hover {
            color: #18BC9C;
        }

        .footer-bottom {
            margin-top: 20px;
            font-size: 0.9rem;
            color: #bbb;
        }

        /* Media Queries */
        @media (max-width: 992px) {
            .features {
                flex-direction: column;
                align-items: center;
                padding: 40px 20px;
            }

            .feature {
                width: 80%;
                margin: 20px 0;
            }

            nav ul {
                flex-direction: column;
                align-items: flex-start;
                padding: 10px 0;
            }

            nav ul li {
                margin-bottom: 10px;
            }
        }

        @media (max-width: 600px) {
            .home-banner h1 {
                font-size: 2.5rem;
            }

            .home-banner p {
                font-size: 1.1rem;
            }

            .btn-start {
                padding: 8px 18px;
                font-size: 0.9rem;
            }

            .footer ul {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav>
        <div class="logo">
            <img src="finLogo.png" alt="Finance Tracker Logo">
            <span class="logo-text">Finance Tracker</span>
        </div>
        <ul>
            <li><a href="Home.php">Home</a></li>
            <li><a href="Contact.php">Contact</a></li>
            <li><a href="About.php">About Us</a></li>
            <li><a href="register.php">Register</a></li>
        </ul>
    </nav>

    <!-- Home Section -->
    <section class="home-content">
        <div class="home-banner">
            <h1>Welcome to Finance Tracker</h1>
            <p>Manage your finances with ease and control. Plan your expenses, track your savings, and achieve financial freedom.</p>
            <button class="btn-start"><a href="register.php">Get Started Now</a></button>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="feature">
            <h2>Track Expenses</h2>
            <p>Stay on top of your spending habits by tracking your daily expenses easily.</p>
        </div>
        <div class="feature">
            <h2>Budget Planner</h2>
            <p>Create budgets for specific goals and get alerts when you're about to exceed them.</p>
        </div>
        <div class="feature">
            <h2>Investment Insights</h2>
            <p>Get insights on how to grow your wealth through personalized investment recommendations.</p>
        </div>
        <div class="feature">
            <h2>Secure Platform</h2>
            <p>All your financial data is encrypted and safely stored, ensuring maximum privacy.</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>About Finance Tracker</h3>
                    <p>Finance Tracker is your go-to platform for managing your personal finances. Track expenses, set budgets,
                        and get insights tailored to your financial goals.</p>
                </div>
                <div class="footer-section links">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Expenses</a></li>
                        <li><a href="#">Budgets</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>
                <div class="footer-section contact">
                    <h3>Contact Us</h3>
                    <p>Email: support@financetracker.com</p>
                    <p>Phone: +123 456 7890</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Finance Tracker | All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>

