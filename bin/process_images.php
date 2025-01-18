<?php

$sourceDir = 'public/uploads/gallery_photos/';
$webpDir = $sourceDir . 'webp/';
$thumbSmallCacheDir = 'public/media/cache/thumb_small/';
$thumbBigCacheDir = 'public/media/cache/thumb_big/';

// Créer les répertoires nécessaires s'ils n'existent pas
if (!is_dir($webpDir)) {
    mkdir($webpDir, 0755, true);
}

// Fonction pour supprimer les fichiers associés (WebP + miniatures)
function deleteAssociatedFiles(string $basename, string $webpDir, string $thumbSmallCacheDir, string $thumbBigCacheDir): void
{
    // Construire les chemins des fichiers associés
    $webpFile = $webpDir . $basename . '.webp';
    $thumbSmallFile = $thumbSmallCacheDir . $basename . '.webp';
    $thumbBigFile = $thumbBigCacheDir . $basename . '.webp';

    // Supprimer les fichiers WebP et les miniatures si elles existent
    foreach ([$webpFile, $thumbSmallFile, $thumbBigFile] as $file) {
        if (file_exists($file)) {
            unlink($file);
            echo "🗑️ Fichier supprimé : $file\n";
        }
    }
}

// Étape 1 : Conversion des nouvelles images en WebP ou régénération si modifiées
$files = glob($sourceDir . '*.{jpg,jpeg,png}', GLOB_BRACE);

if (empty($files)) {
    echo "Aucune image à convertir dans le dossier $sourceDir.\n";
} else {
    foreach ($files as $file) {
        $basename = pathinfo($file, PATHINFO_FILENAME);
        $webpPath = $webpDir . $basename . '.webp';

        // Convertir ou régénérer si le fichier source est plus récent
        if (!file_exists($webpPath) || filemtime($file) > filemtime($webpPath)) {
            if (file_exists($webpPath)) {
                echo "🔄 Fichier source modifié : régénération pour $file\n";
                deleteAssociatedFiles($basename, $webpDir, $thumbSmallCacheDir, $thumbBigCacheDir);
            }

            try {
                $imagick = new Imagick($file);
                $imagick->setImageFormat('webp');
                $imagick->writeImage($webpPath);
                $imagick->clear();
                $imagick->destroy();

                echo "✅ Fichier converti en WebP : $webpPath\n";
            } catch (Exception $e) {
                echo "❌ Erreur lors de la conversion en WebP : " . $e->getMessage() . "\n";
            }
        } else {
            echo "ℹ️ Fichier WebP déjà existant et à jour : $webpPath\n";
        }
    }
}

// Étape 2 : Nettoyage des fichiers associés pour les fichiers supprimés
$webpFiles = glob($webpDir . '*.{webp}', GLOB_BRACE);

if (!empty($webpFiles)) {
    foreach ($webpFiles as $webpFile) {
        $basename = pathinfo($webpFile, PATHINFO_FILENAME);
        $originalFiles = glob($sourceDir . $basename . '.{jpg,jpeg,png}', GLOB_BRACE);

        // Si aucun fichier original n'existe, supprimer les fichiers associés
        if (empty($originalFiles)) {
            echo "🗑️ Fichier source introuvable pour : $webpFile. Suppression des fichiers associés...\n";
            deleteAssociatedFiles($basename, $webpDir, $thumbSmallCacheDir, $thumbBigCacheDir);
        }
    }
}

// Étape 3 : Génération des miniatures pour les fichiers WebP
$webpFiles = glob($webpDir . '*.{webp}', GLOB_BRACE);

if (empty($webpFiles)) {
    echo "Aucune image WebP trouvée dans le dossier $webpDir pour générer des miniatures.\n";
} else {
    foreach ($webpFiles as $webpFile) {
        $relativePath = str_replace('public/', '', $webpFile);
        $thumbSmallPath = $thumbSmallCacheDir . basename($webpFile);
        $thumbBigPath = $thumbBigCacheDir . basename($webpFile);

        // Génération de la miniature "small"
        if (!file_exists($thumbSmallPath)) {
            echo "🔄 Génération de la miniature small pour $webpFile...\n";
            exec("php bin/console liip:imagine:cache:resolve " . escapeshellarg($relativePath), $output, $returnVar);
            if ($returnVar !== 0) {
                echo "❌ Erreur lors de la génération de thumb_small pour $webpFile\n";
            } else {
                echo "✅ Miniature thumb_small générée pour $webpFile\n";
            }
        } else {
            echo "ℹ️ Miniature thumb_small déjà existante pour $webpFile\n";
        }

        // Génération de la miniature "big"
        if (!file_exists($thumbBigPath)) {
            echo "🔄 Génération de la miniature big pour $webpFile...\n";
            exec("php bin/console liip:imagine:cache:resolve " . escapeshellarg($relativePath), $output, $returnVar);
            if ($returnVar !== 0) {
                echo "❌ Erreur lors de la génération de thumb_big pour $webpFile\n";
            } else {
                echo "✅ Miniature thumb_big générée pour $webpFile\n";
            }
        } else {
            echo "ℹ️ Miniature thumb_big déjà existante pour $webpFile\n";
        }
    }
}

echo "✅ Toutes les images ont été traitées : conversions, nettoyages et miniatures.\n";
exit(0);
