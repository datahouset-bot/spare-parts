{{-- resources/views/subscription_expired.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Expired</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
    <div class="text-center">
        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">Your Software Subscription Has Expired</h4>
            <p>Please contact your service provider or call <strong>7999663696,8871702803</strong> for assistance.</p>
            <hr>
            <a href="{{ url('/') }}" class="btn btn-primary">Return to Home</a>
        </div>
    </div>
</body>
</html>
