#!/bin/bash

echo "🔧 Installing PHP dependencies..."
composer install

# 🧬 Copy .env.example to .env if it doesn't exist
if [ ! -f .env ]; then
    echo "📄 .env not found — creating from .env.example"
    cp .env.example .env
else
    echo "✅ .env already exists — skipping"
fi

echo "🔐 Generating app key..."
php artisan key:generate

echo "🔗 Creating storage symlink..."
php artisan storage:link

echo "🧱 Running migrations..."
php artisan migrate --force

echo "📦 Installing JS dependencies..."
npm install

echo "⚙️ Building frontend..."
npm run build

echo "✅ Laravel setup complete!"
