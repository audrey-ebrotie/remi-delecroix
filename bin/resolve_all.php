<?php

$directory = 'public/uploads/gallery_photos/';
$files = glob($directory . '*.{jpg,webp,png,jpeg}', GLOB_BRACE);

if (empty($files)) {
    echo "Aucune image trouvée dans le dossier $directory.\n";
    exit;
}

foreach ($files as $file) {
    $relativePath = str_replace('public/', '', $file);
    $thumbSmallPath = 'public/media/cache/thumb_small/' . basename($file);
    $thumbBigPath = 'public/media/cache/thumb_big/' . basename($file);

    // Vérification de l'existence de la miniature "small"
    if (!file_exists($thumbSmallPath)) {
        echo "🔄 Génération de la miniature small pour $file...\n";
        exec("php bin/console liip:imagine:cache:resolve " . escapeshellarg($relativePath), $output, $returnVar);
        if ($returnVar !== 0) {
            echo "❌ Erreur lors de la génération de thumb_small pour $file\n";
        } else {
            echo "✅ Miniature thumb_small générée pour $file\n";
        }
    } else {
        echo "ℹ️ Miniature thumb_small déjà existante pour $file\n";
    }

    // Vérification de l'existence de la miniature "big"
    if (!file_exists($thumbBigPath)) {
        echo "🔄 Génération de la miniature big pour $file...\n";
        exec("php bin/console liip:imagine:cache:resolve " . escapeshellarg($relativePath), $output, $returnVar);
        if ($returnVar !== 0) {
            echo "❌ Erreur lors de la génération de thumb_big pour $file\n";
        } else {
            echo "✅ Miniature thumb_big générée pour $file\n";
        }
    } else {
        echo "ℹ️ Miniature thumb_big déjà existante pour $file\n";
    }
}

echo "✅ Toutes les miniatures ont été vérifiées et générées si nécessaire.\n";
