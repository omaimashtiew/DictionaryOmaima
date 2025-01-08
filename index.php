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

<!-- HTML Form for submitting word -->
<form action="index.php" method="post">
    <input type="text" name="word" placeholder="Enter word" required>
    <input type="submit" value="Submit">
</form>

<!-- Display result -->
<?php
if ($message) {
    echo $message;
}
?>