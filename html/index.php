<?php
session_start();
include('db_config.php'); // Ensure this file establishes a PDO connection as $pdo 

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the word from the form
    $word = $_POST['word'];

    try {
        // Use a prepared statement to safely query the database
        $stmt = $pdo->prepare("SELECT definition FROM words WHERE word = :word");
        $stmt->execute(['word' => $word]);

        // Check if the word exists in the dictionary
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $definition = "Definition of '$word': " . htmlspecialchars($row['definition']);
        } else {
            $definition = "Word not found in the dictionary.";
        }

        // Store result in session and redirect
        $_SESSION['definition'] = $definition;
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        die("Database query failed: " . $e->getMessage());
    }
}

// Display result after redirect
$message = $_SESSION['definition'] ?? null;
if ($message) {
    unset($_SESSION['definition']); // Clear session after displaying
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dictionary Lookup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            text-align: center;
        }
        h1 {
            font-size: 24px;
            color: #333333;
            margin-bottom: 20px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #cccccc;
            border-radius: 4px;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .message {
            margin-top: 20px;
            font-size: 18px;
            color: #333333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dictionary Lookup</h1>
        <form action="index.php" method="post">
            <input type="text" name="word" placeholder="Enter a word" required>
            <input type="submit" value="Search">
        </form>

        <!-- Display result -->
        <?php if ($message): ?>
            <div class="message"><?= $message ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
