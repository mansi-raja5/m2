# Magebit Magento Practical Test

### Table of content
- Create Custom Widget in the Magento Backend
- Add widget options: Title, Display Mode, Selected Pages
- Display Mode has 2 options - All Pages/Specific Pages
- Selected Pages should be depends on Specific Pages value in Display Mode option.


### How To Install
- Copy Magebit folder under app/code
- Run required Magento commmand
    - bin/magento setup:upgrade;
    - bin/magento c:f;
    - bin/magento setup:di:compile;
    - bin/magento setup:static-content:deploy -f en_US;



### System requirements used during development
PHP 8.1
Magento 2.4.6
MacOS Ventura 13.4

### Magento Docker Configurations
 redis:6.2-alpine
 mariadb:10.4
 markoshust/magento-php:8.1-fpm-1
 markoshust/magento-nginx:1.18-8