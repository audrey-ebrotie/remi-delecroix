all: cache_clear cache_warmup generate_thumbnails

cache_clear:
	@echo "🧹 Nettoyage du cache Symfony..."
	php bin/console cache:clear --env=prod

cache_warmup:
	@echo "🔥 Pré-chauffage du cache Symfony..."
	php bin/console cache:warmup --env=prod

generate_thumbnails:
	@echo "🖼️ Génération des miniatures des photos..."
	php bin/resolve_all.php
