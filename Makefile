# Makefile

# Commande par défaut
all: composer_update cache_clear generate_thumbnails

# Met à jour les dépendances
composer_update:
	@echo "🔄 Mise à jour des dépendances via Composer..."
	composer update --no-interaction --no-progress --prefer-dist

# Vide le cache Symfony
cache_clear:
	@echo "🧹 Nettoyage du cache Symfony..."
	php bin/console cache:clear

# Génère les miniatures des images
generate_thumbnails:
	@echo "🖼️ Génération des miniatures des photos..."
	php bin/resolve_all.php
