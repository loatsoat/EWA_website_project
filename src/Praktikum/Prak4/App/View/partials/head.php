<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Pizzaservice') ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
        }
        
        .visually-hidden {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }
        #order-submit[disabled] {
            background-color: #ccc;
            color: #666;
            cursor: not-allowed;
            border: none;
            padding: 10px 20px;
            opacity: 0.9;
        }
    </style>
    <?php if (!empty($includeScript)): ?>
        <script src="assets/js/script.js" defer></script>
    <?php endif; ?>
</head>
<body>
