<?php
session_start(); // Start the session (Im storing values between the page reloads)

// Reading numbers from input.txt and sortiing them
$numbers = file('data/input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
if ($numbers === false) {
    die("Error: Unable to read input.txt. Check if the file exists.");
}

$numbers = array_map('intval', $numbers);
sort($numbers);

// Retrieving the highest value
if (!isset($_SESSION['highest'])) {
    $_SESSION['highest'] = end($numbers);
}

// Handle form submission to increase/decrease highest value
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'increase') {
        $_SESSION['highest'] += 5;
    } elseif ($_POST['action'] == 'decrease' && $_SESSION['highest'] > 0) {
        $_SESSION['highest'] -= 5;
    }
}

// Storing the highest value in a variable
$highest = $_SESSION['highest'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sorted Numbers</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .numbers-list {
            list-style-type: none;
            padding: 0;
        }
        .numbers-list li {
            font-size: 18px;
            color: #333;
            padding: 5px 0;
        }
        .highest-box {
            display: flex;
            align-items: center;
            margin-top: 20px;
        }
        .highest-box input {
            width: 60px;
            padding: 5px;
            font-size: 16px;
            text-align: center;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            padding: 5px 10px;
            font-size: 16px;
            cursor: pointer;
            background-color: #ccc;
            color: #333;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin: 0 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Sorted Numbers</h2>
    <ul class="numbers-list">
        <?php foreach ($numbers as $number): ?>
            <li><?php echo $number; ?></li>
        <?php endforeach; ?>
    </ul>
    
    <div class="highest-box">
        <!-- Show the highest number -->
        <input type="number" name="highest" value="<?php echo $highest; ?>" readonly>
        
        <!-- Form to increase/decrease the value -->
        <form method="POST">
            <button type="submit" name="action" value="increase" class="btn">+</button>
            <button type="submit" name="action" value="decrease" class="btn">-</button>
        </form>
    </div>
</div>

</body>
</html>
