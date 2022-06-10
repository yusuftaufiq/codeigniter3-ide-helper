FROM php:8.1-cli-alpine

ARG ENVIRONMENT=production
ENV CI_3_IDE_HELPER=$ENVIRONMENT

# Install composer from the official image
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Install composer dependencies
COPY ./composer.json /ide-helper/
COPY ./composer.lock /ide-helper/
RUN composer install -d /ide-helper/ --no-dev --no-ansi --optimize-autoloader --no-interaction --no-progress --no-scripts --prefer-dist

# Add application
COPY ./ /ide-helper/

# Create symlink
RUN ln -sfv /ide-helper/bin/ide-helper /usr/bin/ide-helper

# Switch to application directory
WORKDIR /app

ENTRYPOINT ["ide-helper"]
