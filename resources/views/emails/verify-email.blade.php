<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفعيل حسابك</title>
    <style>
        body {
            font-family: 'Tajawal', Arial, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        a {
            color: white !important;
        }

        .container {
            max-width: 100%;
            margin: 20px;
            background: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #2c3e50;
            font-size: 28px;
            margin-bottom: 20px;
        }

        p {
            color: #555;
            font-size: 18px;
            line-height: 1.8;
            margin-bottom: 25px;
        }

        .btn {
            display: inline-block;
            background-color: #3498db;
            color: white;
            padding: 14px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin: 10px;
        }

        .btn:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn-secondary {
            background-color: #2ecc71;
        }

        .btn-secondary:hover {
            background-color: #27ae60;
        }

        .footer {
            margin-top: 25px;
            font-size: 14px;
            color: #888;
        }

        /* إضافة بعض اللمسات الإضافية */
        .container {
            border: 1px solid #e0e0e0;
        }

        .btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 300%;
            height: 300%;
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(0);
            transition: transform 0.5s ease;
        }

        .btn:hover::after {
            transform: translate(-50%, -50%) scale(1);
        }
    </style>
    <!-- رابط خط Tajawal للعربية -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h2>مرحبًا {{ $user->name }},</h2>
        <p>شكرًا لك على التسجيل في موقعنا. يرجى تفعيل حسابك بالنقر على الزر أدناه:</p>
        <p>
            <a href="{{ $url }}" class="btn">تفعيل الحساب</a>
        </p>
        <p>يمكنك أيضًا تنزيل اتفاقية التعاون بالنقر على الزر التالي:</p>
        <p>
            <a href="https://datafromapi-2.aram-gulf.com/api/download-cooperation-pdf" class="btn btn-secondary" download>تنزيل اتفاقية التعاون</a>
        </p>
        <p class="footer">إذا لم تقم بالتسجيل، يمكنك تجاهل هذا البريد.</p>
    </div>

</body>

</html>
