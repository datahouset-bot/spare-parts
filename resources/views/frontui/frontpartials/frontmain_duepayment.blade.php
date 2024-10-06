<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Due Reminder</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 500px;
            padding: 20px;
            text-align: center;
        }

        h1 {
            color: #d9534f;
            font-size: 24px;
            margin-bottom: 10px;
        }

        p {
            color: #333;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #0275d8;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #025aa5;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Payment Due Reminder</h1>
        <p>Dear Customer,<br> Your payment is due. Please clear your outstanding payment at your earliest convenience.</p>
        <p>Once the payment is settled, kindly send a request for activation to your partner.</p>
        <a href="#" class="button">Contact Partner</a>
    </div>

</body>
</html>
