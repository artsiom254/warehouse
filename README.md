
## Warehouse

### Setting local environment for development

- Clone the repo
- Run "composer install"
- Run "php artisan migrate"
- Run "php artisan serve"
- Run "npm i"
- Run "npm run watch"

## Description

Products table has two columns with quantity:
- "Quantity" shows products quantity based on inventory for each product in case every product is built.
- "Max Quantity" shows maximum product quantity for each product in case that product uses all needed articles.

Import from json file.
- When importing products and articles from file previous data is deleted.

Next iterations:
- Adding functionalities for adding, updating products and articles.
- Adding functionalities for updating products and articles from file.
- Adding user roles with permissions like super_admin, stock_manager. (Currently anybody can register and get full access)
