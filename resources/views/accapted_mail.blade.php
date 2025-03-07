<!-- resources/views/accapted_mail.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Approved</title>
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
            <h1>Your Reservation Has Been Approved!</h1>
        </div>
        <div class="content">
            <p>Hello, {{ $userName }}</p>
            <p>We are happy to inform you that your reservation has been approved! Here are the details:</p>
            <ul>
                <li><strong>Organization Name:</strong> {{ $bookingDetails['organization_name'] }}</li>
                <li><strong>Booking Day:</strong> {{ $bookingDetails['book_day'] }}</li>
                <li><strong>Booking Time:</strong> {{ $bookingDetails['book_time'] }}</li>
                <li><strong>Additional Notes:</strong> {{ $bookingDetails['additional_notes'] }}</li>
            </ul>
            <p>Thank you for choosing us!</p>
            <!-- Optional: Add a call-to-action button -->
            <a href="http://" class="btn">View Booking Details</a>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} Gulf Aram Limited. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
