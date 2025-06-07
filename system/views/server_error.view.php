<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internal Server Error</title>
    <style>
        *{
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: sans-serif;
        }
        .error-message-wrapper{
            padding: 15px;
        }
        .error-message-container{
            background-color: black;
            color: yellow;
            font-size: 18px;
            font-weight: 700;
            padding: 10px;
        }
        h1{
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="error-message-wrapper">
        <h1>Internel Server Error</h1>
        <div class="error-message-container">
            <?= $error_message ?>
        </div>
    </div>
</body>
</html>