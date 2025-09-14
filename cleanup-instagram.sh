#!/bin/bash

echo "🧹 Cleaning up Instagram integration files..."
echo "============================================="
echo ""

# Remove Instagram Service
echo "📁 Removing Instagram Service file..."
if [ -f "app/Services/InstagramService.php" ]; then
    rm app/Services/InstagramService.php
    echo "✅ Removed app/Services/InstagramService.php"
else
    echo "ℹ️  Instagram Service file not found"
fi

# Remove Instagram Command
echo "📁 Removing Instagram Setup Command..."
if [ -f "app/Console/Commands/SetupInstagramCommand.php" ]; then
    rm app/Console/Commands/SetupInstagramCommand.php
    echo "✅ Removed app/Console/Commands/SetupInstagramCommand.php"
else
    echo "ℹ️  Instagram Command file not found"
fi

# Remove Instagram Components
echo "📁 Removing Instagram Components..."
if [ -f "resources/views/components/instagram-feed.blade.php" ]; then
    rm resources/views/components/instagram-feed.blade.php
    echo "✅ Removed resources/views/components/instagram-feed.blade.php"
else
    echo "ℹ️  Instagram feed component not found"
fi

if [ -f "resources/views/components/instagram-fallback.blade.php" ]; then
    rm resources/views/components/instagram-fallback.blade.php
    echo "✅ Removed resources/views/components/instagram-fallback.blade.php"
else
    echo "ℹ️  Instagram fallback component not found"
fi

# Remove Instagram setup script
echo "📁 Removing Instagram setup script..."
if [ -f "setup-instagram.sh" ]; then
    rm setup-instagram.sh
    echo "✅ Removed setup-instagram.sh"
else
    echo "ℹ️  Instagram setup script not found"
fi

# Update .env.example to remove Instagram variables
echo "📝 Updating .env.example..."
if [ -f ".env.example" ]; then
    # Create backup
    cp .env.example .env.example.backup
    
    # Remove Instagram section
    grep -v "INSTAGRAM_" .env.example > .env.example.tmp
    mv .env.example.tmp .env.example
    
    echo "✅ Updated .env.example (backup created as .env.example.backup)"
else
    echo "ℹ️  .env.example not found"
fi

# Clear cache
echo "🧹 Clearing caches..."
php artisan cache:clear > /dev/null 2>&1
php artisan config:clear > /dev/null 2>&1
php artisan view:clear > /dev/null 2>&1

echo ""
echo "✅ Instagram integration cleanup completed!"
echo ""
echo "📋 What was done:"
echo "   - Removed Instagram Service and Command files"
echo "   - Removed Instagram Blade components"
echo "   - Removed Instagram setup script"
echo "   - Updated .env.example file"
echo "   - Cleared Laravel caches"
echo ""
echo "📖 Your website now uses a simple photo gallery instead of Instagram integration."
