<!-- resources/views/payment_success.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            background-color: #1d72b8;
            color: #ffffff;
            padding: 10px 0;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 20px;
        }

        .content p {
            font-size: 16px;
        }

        .content ul {
            list-style-type: none;
            padding: 0;
        }

        .content ul li {
            margin: 10px 0;
            font-size: 16px;
        }

        .img {
            width: 40px;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .footer {
            text-align: center;
            font-size: 14px;
            color: #999;
            padding: 10px 0;
        }

        .btn {
            display: inline-block;
            background-color: #1d72b8;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: #155a8a;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h1>Booking request!</h1>
        </div>
        <div class="content">
            <p>Hello, {{ $organizationName }}</p>
            <p>Your reservation has been sent successfully. You will be replied to by the medical center in a new email. Below are the reservation details:</p>
            <ul>
                <li><strong>Booking Day:</strong> {{ $bookingDetails['book_day'] }}</li>
                <li><strong>Booking Time:</strong> {{ $bookingDetails['book_time'] }}</li>
                <li><strong>Additional Notes:</strong> {{ $bookingDetails['additional_notes'] }}</li>
            </ul>
            <p>Thank you for your trust!</p>
            <!-- Optional: Add a call-to-action button -->
            <a href="http://" class="btn">View Details</a>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} Gulf Aram Limited . All rights reserved.</p>
        </div>
    </div>
</body>

</html>
