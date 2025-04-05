 <?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Generate and fetch QR codes using UiPath and Flask APIs.">
    <title>Generate QR Code</title>
    <style>
        /* General Styles */
    body {
    font-family: Arial, sans-serif;
    background: linear-gradient(to left, #181833, #531c1c); /* Fixed property for gradient */
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
}

/* Header Style */
h1 {
    color: white;
    font-size: 2rem;
    margin-bottom: 20px;
    text-align: center;
}

/* Button Style */
form button {
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

form button:hover {
    background-color: #0056b3;
    transform: scale(1.05);
}

form button:active {
    background-color: #003f7f;
    transform: scale(1);
}

/* Form Centering */
form {
    text-align: center;
}

/* Success/Failure Message */
.response-message {
    margin-top: 20px;
    font-size: 1rem;
    text-align: center;
}

.response-message.success {
    color: green;
}

.response-message.error {
    color: red;
}

/* QR Code Image */
.qr-code {
    margin-top: 15px;
}

.qr-code img {
    max-width: 70px;  /* Make the image smaller */
    height: auto;     /* Maintain aspect ratio */
    border: 2px solid #fff;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    align-self: flex-start;  /* Align the image to the left */
}


    </style>
</head>
<body>
    <div>
        <img src="Artboard.png" alt="Header Image" style="width: 200px; margin-bottom: 0px;">
    </div>
    <h1>Generate QR Code For Attendance</h1>
    <?php if (!empty($message)): ?>
        <p class="response-message <?php echo $messageClass; ?>">
            <?php echo htmlspecialchars($message); ?>
        </p>
    <?php endif; ?>
    <?php if (!empty($qr_code_url)): ?>
        <div class="qr-code">
            <img src="<?php echo htmlspecialchars($qr_code_url); ?>" alt="Latest QR Code">
        </div>
    <?php endif; ?>
</body>
</html>
<?php
// Include config file
include('qr-config.php');

// Database connection
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$success = $error = "";
$latestLecture = null;

// Handle form submission to save lecture name and QR code
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['saveLecture'])) {
    $lectureName = $conn->real_escape_string($_POST['lectureName']);
    if (!empty($lectureName)) {
        // Generate QR Code URL
        $qrCodeUrl = QR_API_URL . urlencode($lectureName);

        // Save data to the database
        $sql = "INSERT INTO lectures (name, qr_code_url) VALUES ('$lectureName', '$qrCodeUrl')";
        if ($conn->query($sql) === TRUE) {
            $success = "Lecture name saved successfully! Please wait 30 seconds for the QR code to generate.";
            $latestLecture = ['name' => $lectureName, 'qr_code_url' => $qrCodeUrl];
        } else {
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $error = "Please enter a valid lecture name.";
    }
}

// Fetch the latest lecture data from the database
if (!$latestLecture) {
    $sql = "SELECT name, qr_code_url FROM lectures ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);
    $latestLecture = $result->fetch_assoc();
}
?>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 70%;
            max-width: 700px;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        input, button {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .message {
            text-align: center;
            margin: 10px 0;
        }
        .qr-section img {
            display: block;
            max-width: 150px;
            margin: 20px auto;
        }
        .disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="container">
        

        <!-- Display messages -->
        <?php if (!empty($success)): ?>
            <p class="message" style="color: green;"><?= $success; ?></p>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <p class="message" style="color: red;"><?= $error; ?></p>
        <?php endif; ?>

        <!-- Form to save lecture name -->
        <form method="POST">
            <label for="lectureName">Enter Lecture Name:</label>
            <input type="text" id="lectureName" name="lectureName" placeholder="e.g., Introduction to AI" required>
            <button type="submit" name="saveLecture">Save Lecture Name</button>
        </form>

        <!-- Section to trigger UiPath -->
        <?php if (!empty($latestLecture['name'])): ?>
            <div style="margin-top: 30px;">
                <h2>UiPath Trigger</h2>
                <form action="test.php" method="POST">
                    <button type="submit" name="trigger" >Run UiPath Automation</button>
                </form>
            </div>
        <?php endif; ?>

        <!-- Section to display QR code -->
        <?php if (!empty($latestLecture)): ?>
            <div class="qr-section" style="margin-top: 30px;">
                <h2>Generated QR Code</h2>
                <p><strong>Lecture Name:</strong> <?= htmlspecialchars($latestLecture['name']); ?></p>
                <div id="qr-code">
                    <p>Please wait for the QR code to load...</p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Delay fetching the QR code by 30 seconds
        setTimeout(() => {
            const qrCodeUrl = '<?= $latestLecture['qr_code_url'] ?? ""; ?>';
            if (qrCodeUrl) {
                const qrCodeDiv = document.getElementById('qr-code');
                qrCodeDiv.innerHTML = `<img src="${qrCodeUrl}" alt="QR Code">`;
            }
        }, );
    </script>
</body>
</html>
