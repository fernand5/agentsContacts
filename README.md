# agentsContacts
Project implemented with PHP+Laravel. Application that displays the match  between 2 actors: the Agents and a list of Contacts. The application split the contact list into 2 groups (1 per agent) based on their  zip codes.
This code use the Great-circle distance algorithm (https://en.wikipedia.org/wiki/Great-circle_distance#Formulas) to calculate the distance between 2 points through latitude and longitude given by google API 

## Requirements
- Install composer
- Run:
        ```
        composer uodate
        ```
##Install
- Execute the .sql file (path: database/database.sql) in your server
- The application take a .CSV file in the path public/dataContacts.csv if you want to refresh the data you should update this file and run  the route /truncate to delete the database and upload new data
- Put the code on your web server and run the route /public/index
