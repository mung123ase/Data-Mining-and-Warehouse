<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* About Section */
.about-section {
    padding: 80px 0;
    background-color: #f0f0f0;
}

.container {
    width: 85%;
    margin: 0 auto;
    text-align: center;
}

.section-title {
    font-size: 2.5rem;
    margin-bottom: 40px;
    color: #2C3E50;
}

.about-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 30px;
}

.about-text {
    width: 60%;
    text-align: left;
}

.about-text p {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #555;
    margin-bottom: 20px;
}

.about-text .btn-learn-more {
    background-color: #18BC9C;
    padding: 12px 30px;
    border-radius: 50px;
    font-size: 1rem;
    font-weight: bold;
    text-transform: uppercase;
    transition: all 0.3s ease;
}

.about-text .btn-learn-more a {
    text-decoration: none;
    color: white;
}

.about-text .btn-learn-more:hover {
    background-color: #16A085;
}

.about-image {
    width: 35%;
}

.about-image img {
    width: 100%;
    border-radius: 10px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
}

/* Media Queries for About Section */
@media (max-width: 768px) {
    .about-content {
        flex-direction: column;
        text-align: center;
    }

    .about-text {
        width: 100%;
    }

    .about-image {
        width: 100%;
        margin-top: 30px;
    }
}

    </style>
</head>
<body>
<section id="about" class="about-section">
    <div class="container">
        <h2 class="section-title">About Our Finance Tracker</h2>
        <div class="about-content">
            <div class="about-text">
                <p>
                    Finance Tracker is a comprehensive personal finance management tool designed to help users gain control over their financial future. Whether you're tracking expenses, setting budgets, or planning for long-term goals, our platform provides you with powerful insights to make informed financial decisions.
                </p>
                <p>
                    Our mission is to simplify financial management and make it accessible to everyone, regardless of your financial background. With user-friendly interfaces and smart algorithms, we ensure that tracking your money is no longer a hassle but an empowering experience.
                </p>
                <p>
                    Join thousands of users today and take the first step towards mastering your finances. Your journey to financial freedom starts here!
                </p>
                <button class="btn-learn-more"><a href="register.php">Learn More</a></button>
            </div>
            <div class="about-image">
                <img src="About.jpeg" alt="About Finance Tracker">
            </div>
        </div>
    </div>
</section>
</body>
</html>