FROM php:8.4-cli

# Dépendances système
RUN apt-get update && apt-get install -y \
    git unzip curl nodejs npm libpq-dev libzip-dev \
    && docker-php-ext-install pdo_pgsql pdo_mysql zip

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copier les fichiers de dépendances d'abord (optimisation du cache Docker)
COPY package*.json ./
RUN npm install

# Copier le reste du projet
COPY . .

# Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Générer les assets de production (C'est ici que le manifest est créé)
RUN npm run build

# FIX : S'assurer que les permissions sont correctes APRES le build
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/public

EXPOSE 8000

# Au démarrage : tente les migrations et le lien de stockage sans jamais
# bloquer le lancement du serveur (utile si la base met quelques secondes
# de plus à démarrer que l'application au tout premier déploiement).
CMD sh -c "php artisan migrate --force || echo 'Migration différée, réessayez via le shell Railway si besoin'; php artisan storage:link || true; php artisan serve --host=0.0.0.0 --port=$PORT"