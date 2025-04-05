<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Image upload handling
    if (isset($_FILES['image']['tmp_name'])) {
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_name = $_FILES['image']['name'];
        
        // Check if the uploaded file is an image
        $image_file_type = mime_content_type($image_tmp_name);
        if (strpos($image_file_type, 'image/') === false) {
            echo "Please upload a valid image file.";
            exit;
        }

        // Save the uploaded image to the server (you can adjust the folder path)
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir);
        }

        $image_path = $upload_dir . basename($image_name);
        move_uploaded_file($image_tmp_name, $image_path);

        // You can now perform actions based on the uploaded image, for example:
        // 1. Process the image to create a QR code
        // 2. Store or display the image as needed.

        // For demonstration, just show the image and the QR code form.
        echo "<p>Image uploaded successfully. Here's the image:</p>";
        echo "<img src='$image_path' alt='Uploaded Image' style='max-width: 300px;'>";
    }

    // QR Code Generation Logic
    $uipathUrl = "https://cloud.uipath.com/atlrldxjq/DefaultTenant/orchestrator_/t/707506f9-b295-41e7-9eee-a886167502f0/qqqqqq";
    $clientId = "8DEv1AMNXczW3y4U15LL3jYf62jK93n5";
    $accessToken = "rt_180F63F88BF2D7993B1DD038A915B8BD0F80A2FDF9D030BFB192B3D778A72C60-1";
    $data = ["textToEncode" => "Sample QR Code Text"];

    $ch = curl_init($uipathUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        "Authorization: Bearer $accessToken",
        "X-ClientId: $clientId"
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    if ($response) {
        $response_data = json_decode($response, true);
        if (isset($response_data['qr_code_url'])) {
            $qr_code_url = $response_data['qr_code_url'];
            $qr_image_data = file_get_contents($qr_code_url);

            if ($qr_image_data) {
                $file_name = 'qr_code_' . date('Y-m-d_H-i-s') . '.png';

                // Send headers to force the browser to download the image
                header('Content-Type: image/png');
                header('Content-Disposition: attachment; filename="' . $file_name . '"');
                header('Content-Length: ' . strlen($qr_image_data));

                // Output the QR code image
                echo $qr_image_data;
                exit; // Stop further processing
            } else {
                echo "Failed to download the QR code image.";
            }
        } else {
            echo "Wait, your AI generator is working!";
        }
    } else {
        echo "Failed to generate QR code.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate QR Code</title>
    <style>
        body {
            background: -webkit-linear-gradient(left, #000000, #6c65c8);
            background: linear-gradient(to right, #531c1c, #181833);
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form#generateQRCodeForm {
            background-color: #ffffff;
            padding: 20px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        form#generateQRCodeForm button {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        form#generateQRCodeForm button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        form#generateQRCodeForm button:active {
            background-color: #003f7f;
            transform: scale(0.95);
        }
    </style>
</head>
<body>

<!-- HTML Form to Upload Image and Generate QR Code -->


</body>
</html>
