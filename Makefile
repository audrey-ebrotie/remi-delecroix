# Makefile

# Commande par défaut
all: generate_thumbnails

# Génère les miniatures des images
generate_thumbnails:
	@echo "🖼️ Génération des miniatures des photos..."
	php bin/resolve_all.php
