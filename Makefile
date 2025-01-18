# Commande par défaut
all: process

# Conversion et génération des miniatures
process:
	@echo "🖼️ Conversion en WebP et génération des miniatures..."
	php bin/process_images.php

# Exécuter Gulp
gulp:
	@echo "🚀 Exécution de Gulp..."
	npx gulp

# Lancer le watcher manuellement
watcher:
	@echo "👀 Lancement du watcher pour surveiller les changements dans le dossier public/uploads/gallery_photos..."
	@bash bin/start_watcher.sh
