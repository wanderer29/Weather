# Project "Tennis Scoreboard"

A web application for viewing the current weather. The user can register and add one or more locations (cities,
villages, other points) to the collection, after which the main page of the application begins to display a list of
locations with their current weather.

## Application functionality

Working with users:
    - Registration
    - Authorization
    - Logout 

Working with locations:
    - Search
    - Adding to list
    - Viewing the list of locations, for each location the name and temperature are displayed
    - Removing from the list

## Features

- PHP 8.2
- Laravel framework 11.20
- HTML/CSS, Bootstrap
- MySql 9.0
- Unit Tests, integration testing, mocks

## Application interface

- Welcome page
    - For unauthorized users - registration and authorization buttons
- Home page
    - Content for authorized users:
      - Input field for searching for a location by name
      - List of added locations.
      - Each list item displays the name, current temperature, the "delete" and "details" buttons
      - List of found locations with the "add" button. When you click on the button, you go to the main page
- Details page
   - Content for authorized users:
     - Location name
     - Current Temperature for location
     - Current weather description
     - Current wind speed for location
     - Blocks with weather forecast for a location for 7 days which contains:
       - Min Temperature for day
       - Max Temperature for day
       - Weather description for day
       - Max Wind Speed for day
       - Precipitation for day
- Other pages
    - Login page
    - Register page

## Tests

- Open-meteo service tests:
  - get weather forecast successfully
  - get weather forecast with error, result must be null

- User registration tests:
  - register new user successfully
  - failed register if login already taken
  - session expires after registration and logout
  - registration fails when login or password is empty
  - registration fails when password confirmation does not match

## Deploy
The application is now available at: 193.227.241.68:8000/

## For local launch:

Before running the project, make sure that the following components are installed on your computer:
- Docker
- docker-compose

1. Clone the project using Git
2. Create .env by copying the .env.example file 
3. In the root directory of the project, run the command to build containers:
    - docker-compose up --build -d
4. Inside the PHP container, install dependencies using Composer:
    - docker exec -it weather-php-1 bash
    - composer install
    - php artisan migrate

