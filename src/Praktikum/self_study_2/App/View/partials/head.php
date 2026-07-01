<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Pizzaservice') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- [SS2] Fonts and icons load here. -->
    <link href="https://fonts.googleapis.com/css2?family=Bitcount+Single:wght@100..900&family=Source+Serif+4:ital,opsz,wght@0,8..60,200..900;1,8..60,200..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= htmlspecialchars(Router::generateUrl('assets/css/style.css')) ?>?v=1.3">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <?php if (!empty($pageScripts) && is_array($pageScripts)): ?>
        <!-- Pro Seite werden nur die wirklich benötigten JavaScript-Dateien eingebunden. -->
        <?php foreach ($pageScripts as $jsFile): ?>
            <script src="<?= htmlspecialchars(Router::generateUrl($jsFile)) ?>?v=1.0" defer></script>
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>
