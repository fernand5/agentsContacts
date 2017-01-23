# Agents and Contacts
Project implemented with PHP+Laravel. Application that displays the match  between 2 actors: the Agents and a list of Contacts. The application split the contact list into 2 groups (1 per agent) based on their  zip codes.
This code use the Great-circle distance algorithm (https://en.wikipedia.org/wiki/Great-circle_distance#Formulas) to calculate the distance between 2 points through latitude and longitude given by google API 

## Requirements
- Install composer
- Run on the root folder:
        ```
        composer update
        ```
        
##Install
- Execute the .sql file (path: database/database.sql) in your server
- The application take a .CSV file in the path public/dataContacts.csv if you want to refresh the data you should update this file and run  the route /truncate to delete the database and upload new data
- Put the code on your web server
- Make a .env file with your configuration to connect the database (an example is .env.example file in the root path)
- Run the route /public/index

#Possible issue
If this error appears 
 ```No supported encrypter found. The cipher and / or key length are invalid.```
 You should execute ```php artisan key:generate``` on the root folder
