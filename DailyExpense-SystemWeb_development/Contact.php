<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Contact Us Section */
.contact-section {
    padding: 80px 0;
    background-color: #f9f9f9;
}

.contact-section .section-title {
    font-size: 2.5rem;
    margin-bottom: 40px;
    color: #2C3E50;
    text-align: center;
}

.contact-content {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 30px;
}

.contact-info {
    width: 50%;
    text-align: left;
}

.contact-info p {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #555;
    margin-bottom: 20px;
}

.contact-info ul {
    list-style: none;
    padding: 0;
}

.contact-info ul li {
    font-size: 1.1rem;
    margin-bottom: 10px;
    color: #2C3E50;
}

.contact-form {
    width: 50%;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-size: 1rem;
    color: #2C3E50;
    margin-bottom: 5px;
}

.form-control {
    width: 100%;
    padding: 10px;
    font-size: 1rem;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-sizing: border-box;
}

.form-control:focus {
    outline: none;
    border-color: #18BC9C;
    box-shadow: 0 0 8px rgba(24, 188, 156, 0.3);
}

.btn-submit {
    background-color: #18BC9C;
    padding: 12px 30px;
    border-radius: 50px;
    font-size: 1rem;
    font-weight: bold;
    text-transform: uppercase;
    color: white;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-submit:hover {
    background-color: #16A085;
}

/* Media Queries for Contact Us Section */
@media (max-width: 768px) {
    .contact-content {
        flex-direction: column;
    }

    .contact-info,
    .contact-form {
        width: 100%;
    }
}

    </style>
</head>
<body>
<section id="contact" class="contact-section">
    <div class="container">
        <h2 class="section-title">Contact Us</h2>
        <div class="contact-content">
            <div class="contact-info">
                <p>If you have any questions, feedback, or need assistance, feel free to reach out to us. We're here to help you manage your finances better!</p>
                <ul>
                    <li><strong>Email:</strong> support@financetracker.com</li>
                    <li><strong>Phone:</strong> +123 456 7890</li>
                    <li><strong>Address:</strong> 123 Finance Blvd, Suite 789, Moneyville</li>
                </ul>
            </div>
            <div class="contact-form">
                <form action="submitForm()" method="POST">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message:</label>
                        <textarea id="message" name="message" rows="5" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="btn-submit">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>
</body>
</html>