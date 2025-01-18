#!/bin/bash

WATCH_DIR="public/uploads/gallery_photos"

echo "👀 Surveillance du dossier : $WATCH_DIR"

fswatch -o $WATCH_DIR | while read event
do
    echo "🖼️ Nouveau fichier détecté. Exécution de la commande..."
    make process
done
