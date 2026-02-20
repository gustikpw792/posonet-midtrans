<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Pending</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .pdf-container {
            max-width: 100%;
            height: 600px;
            border: 1px solid #ccc;
            background-color: #fff;
        }
        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>
<body>
    <h1>Payment Pending - Invoice PDF</h1>
    <div class="pdf-container">
        <iframe src="https://app.sandbox.midtrans.com/snap/v1/transactions/a1cd040d-19b7-434f-afe5-796bdae9fbea/pdf" title="Invoice PDF"></iframe>
    </div>
</body>
</html>
