# QubeStat: Full Stack LAMP

<img src="./qubestat_lamp_stack.png" alt="full_stack_archi">

## Setup Project:
- Open Xampp / any other php development toolkit.

- `cd backend` or `cd frontend` based on your developer role.

- For ***Backend Devs***: 
    - Make an `.env` file and copy and paste the `env-example` file and then install the dotenv dependency through composer by executing `composer install`

    - Go to `localhost/phpmyadmin` make an db of your choice and then import the `sample_data.sql` for testing purposes.

    - We are following a procedural approach in the `models handel sql query`. In the `api` we are developing the RestAPI

    - In the `heplers` folder we will have some utility functions