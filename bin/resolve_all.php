<?php

$files = glob('public/uploads/gallery_photos/*.{jpg,webp, png, jpeg}', GLOB_BRACE);

foreach ($files as $file) {
    echo "Processing $file...\n";
    exec("php bin/console liip:imagine:cache:resolve " . escapeshellarg(str_replace('public/', '', $file)));
}
