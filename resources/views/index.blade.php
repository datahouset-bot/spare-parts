<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your custom CSS file -->
<style>
    body, html {
    height: 100%;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
}

.container {
    text-align: center;
}

.button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007bff; /* Example background color */
    color: #fff; /* Example text color */
    text-decoration: none;
    border-radius: 5px;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.button:hover {
    background-color: #0056b3; /* Example hover background color */
}

</style>
</head>
<body>
    <div class="container">
        <a href="{{ route('second_index') }}" class="button">ENTER Your Software</a>
    </div>
</body>
</html>
