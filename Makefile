# Makefile

# Commande par défaut
all: thumbs

# Génère les miniatures des images
thumbs:
	@echo "🖼️ Génération des miniatures des photos..."
	php bin/resolve_all.php

# Exécuter Gulp
gulp:
	@echo "🚀 Exécution de Gulp..."
	npx gulp
