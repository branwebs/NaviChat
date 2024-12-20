<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation Dialog</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
        }

        .dialog {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            padding: 20px;
        }

        .dialog h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .dialog p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .dialog .buttons {
            display: flex;
            justify-content: space-between;
        }

        .dialog button {
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            color: #fff;
        }

        .dialog button.yes {
            background-color: #32bca6;
        }

        .dialog button.no {
            background-color:rgb(220, 31, 31);
        }

        .dialog button:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

<div class="dialog" id="confirmationDialog">
    <h2>Confirmation</h2>
    <p>Are you sure you want to log out?</p>
    <div class="buttons">
        <button class="yes" onclick="window.location.href='../../Controller/Users/userLogoutController.php'">YES</button>
        <button class="no" onclick="window.history.back()">NO</button>
    </div>
</div>

</body>
</html>
