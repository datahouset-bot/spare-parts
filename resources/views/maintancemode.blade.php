<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Site Under Maintenance</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #f8f9fa, #e9ecef);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .message {
            background-color: #ffffff;
            padding: 40px 50px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            text-align: center;
            max-width: 500px;
        }
        h1 {
            font-size: 32px;
            color: #343a40;
            margin-bottom: 20px;
        }
        p {
            font-size: 18px;
            color: #6c757d;
            margin: 10px 0;
        }
        .emoji {
            font-size: 50px;
        }
    </style>
</head>
<body>
    <div class="message">
        <div class="emoji">🚧</div>
        <h1>Site Under Maintenance</h1>
        <p>We are currently performing some scheduled maintenance.</p>
        <p>We'll be back online by <strong>{{ $maintinacemode->end_time }}</strong>.</p>
        <p>Thank you for your patience!</p>
        <p>{{$maintinacemode->message1}}</p>
        <p>{{$maintinacemode->message2}}</p>
        <p>{{$maintinacemode->message3}}</p>
    </div>
</body>
</html>
