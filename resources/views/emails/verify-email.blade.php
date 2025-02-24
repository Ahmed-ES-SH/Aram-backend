<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفعيل حسابك</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 30px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #333;
        }

        p {
            color: #666;
            font-size: 16px;
            line-height: 1.6;
        }

        .btn {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 18px;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>مرحبًا {{ $user->name }},</h2>
        <p>شكرًا لك على التسجيل في موقعنا. يرجى تفعيل حسابك بالنقر على الزر أدناه:</p>
        <p>
            <a href="{{ $url }}" class="btn">تفعيل الحساب</a>
        </p>
        <p class="footer">إذا لم تقم بالتسجيل، يمكنك تجاهل هذا البريد.</p>
    </div>
</body>

</html>
