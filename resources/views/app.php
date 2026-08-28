<?php

declare(strict_types=1);

use Yiisoft\Html\Html;

/**
 * @var string $charset
 * @var string $id
 * @var string $language
 * @var string $pageJson
 * @var string $title
 * @var array<string, mixed> $viewData
 * @var string $viteTags
 */
$defaultDescription = 'A working Yii 3 application with Inertia 3, Vue 3.5, and Vite 8.';
$description = $viewData['description'] ?? $defaultDescription;
$documentTitle = $viewData['title'] ?? $title;

if (!is_string($description)) {
    $description = $defaultDescription;
}

if (!is_string($documentTitle)) {
    $documentTitle = $title;
}
?>
<!DOCTYPE html>
<html lang="<?= Html::encodeAttribute($language) ?>">
<head>
    <meta charset="<?= Html::encodeAttribute($charset) ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">
    <meta name="theme-color" content="#f8fcfd">
    <meta data-inertia="description" name="description" content="<?= Html::encodeAttribute($description) ?>">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= Html::encodeAttribute($documentTitle) ?>">
    <meta property="og:description" content="A working Yii 3 application with Inertia 3, Vue 3.5, and Vite 8.">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="<?= Html::encodeAttribute($documentTitle) ?>">
    <meta name="twitter:description" content="A working Yii 3 application with Inertia 3, Vue 3.5, and Vite 8.">
    <script data-theme-bootstrap>
        (() => {
            const root = document.documentElement;
            let theme = null;

            try {
                const stored = window.localStorage.getItem('theme');
                theme = stored === 'dark' || stored === 'light' ? stored : null;
            } catch {
                theme = null;
            }

            theme ??= window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            root.classList.toggle('dark', theme === 'dark');
            root.dataset.theme = theme;
            root.style.colorScheme = theme;
            document.querySelector('meta[name="theme-color"]').content = theme === 'dark' ? '#07151c' : '#f8fcfd';
        })();
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600;700&amp;family=Manrope:wght@400;500;600;700;800&amp;family=Space+Grotesk:wght@500;600;700&amp;display=swap" rel="stylesheet">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="icon" href="/favicon.ico" sizes="any">
    <title data-inertia><?= Html::encode($documentTitle) ?></title>
    <?= $viteTags ?>
</head>
<body>
    <script data-page="<?= Html::encodeAttribute($id) ?>" type="application/json"><?= $pageJson ?></script>
    <div id="<?= Html::encodeAttribute($id) ?>"></div>
    <noscript>This Yii 3 application requires JavaScript to render its Inertia pages.</noscript>
</body>
</html>
