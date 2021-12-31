## About The Project

This project is about Kudo cards. Kudo cards is a technique to help deliver feedback and motivate people in the right way. The word “kudo” comes from Greek and means “praise”, which is exactly what Kudos are meant for.
Anyone can write a Kudo and dedicate it to anyone.


### Built With

These are some frameworks/libraries used in this project.

* Nuxt
* Laravel
* Bootstrap

## Getting Started

These are some instructions to run the project locally.


### Prerequisites

It's important to have npm installed and composer for this project.
Also we need to create .ENV files for the backend and frontend, we can copy the examples and populate with our configuration.


### Installation

_These are some steps you need to follow to sett up the app._

1. Change directory to api-backend and install dependencies
   ```sh
   composer install
   ```
2. Run the migrations
   ```sh
   php artisan migrate
   ```
3. Run the seeds
   ```sh
   php artisan db:seed
   ```
4. Execute the passport:install Artisan command
   ```sh
   php artisan passport:install
   ```
5. Serve the backend at localhost:8000
   ```sh
   php artisan serve
   ```
6. Next, change directory to frontend and install dependencies
   ```sh
   npm i
   ```
7. And serve with hot reload at localhost:3000
   ```sh
   npm run dev
   ```