FROM php:8.2-fpm-alpine

# Install nginx
RUN apk add --no-cache nginx

# Copy nginx config
COPY nginx.conf /etc/nginx/http.d/default.conf

# Copy PHP files
COPY index.php /var/www/html/
COPY api/ /var/www/html/api/

# Create log directory
RUN mkdir -p /tmp

# Expose port 80
EXPOSE 80

# Start nginx and php-fpm
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]



