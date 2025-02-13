<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .email-header {
            background-color: #007BFF;
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }

        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }

        .email-body {
            padding: 20px;
            color: #333333;
        }

        .email-body h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .email-body p {
            font-size: 16px;
            line-height: 1.5;
        }

        .verification-code {
            display: inline-block;
            background-color: #007BFF;
            color: #ffffff;
            font-size: 24px;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 5px;
            margin: 20px 0;
        }

        .email-footer {
            text-align: center;
            padding: 10px;
            background-color: #f4f4f4;
            color: #777777;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>Verification Code</h1>
        </div>

        <!-- Body -->
        <div class="email-body">
            <h2>Hello,</h2>
            <p>You have requested to reset your password. Please use the following verification code to proceed:</p>
            <div class="verification-code">{{ $code }}</div>
            <p>If you did not request this code, please ignore this email.</p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} Your Company Name. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
