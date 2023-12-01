
## About Laravel Vuejs WeatherApp

Weather app using Laravel and Vuejs with these API below.

- [openweathermap](http://api.openweathermap.org/).
- [geoapify](https://api.geoapify.com/).

## CSS Framework

Bootstrap for reponsive web design

## Functionality 

- On landing page i used the HTML% geolocation to get user current location not 100% accurate
- When typing input i used the - [geoapify](https://api.geoapify.com/). Api to make the dropdown and user can select the related city according to the input
- When clicking the address from input dropdown i used the API - [openweathermap](http://api.openweathermap.org/). to get the address weather details and forecast then i used again the - [geoapify](https://api.geoapify.com/). to get the related place with circle raduis to the current address.

 ## Installation

 1. Clone the repo https://github.com/killerboduk1/Laravel-Vue-Weather-App
 2. npm install then composer install 
 3. npm run dev / npm run build
 4. php artisan serve to view the project

 ## Notes

 I added the .env file to the repo to include the API keys and API hosts for testing only

  ## Features

  * Autocomplete input when entering city or address in the input
  * Clickable address when autocomplete is open
  * 4 days forecast listed below 
  * Auto get current location using HTML5 Geolocation and weather on landing page
  * Related places when selecting a city listed below the 4 day forecast