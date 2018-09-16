# Php Restfull Api
This is restfull api package. You can easily extend it and add more apis

# Installation

#### Manual
1. Open Class/Db.php file and replace database credentials with yours
2. Start install.php file (Example: http://yoursite.com/install.php)
#### Docker
Run start.sh on terminal and it will automatically install and initialize mysql, create database and user 

# How to use
At the moment there is one api for orders Which has:

####
1. Creating an order: http://yoursite.com/order (POST request)
2. Update an order (setting status to "taken"): http://yoursite.com/order/:id (PUT request)
2. Get list of orders: http://yoursite.com/orders (GET request)

# How to add additional api endpoints
1. Open api/order/index.php and add new case
2. Open Classes/Orders.php class and add new method and codes you need

# How to add another apis and endpoints
1. Create new class which extends Api.php class in Classes folder
2. Add new folder in api folder and create index.php file (or another) and begin to write your api


##### Htacess is configured to automatically rewrite files in api folder