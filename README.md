Installation instructions:

To build this I am using a plain ubuntu installation on a DO droplet

1. Clone repo `git clone https://github.com/yuluthu/IWLTechTask.git`
2. Move into repo folder `cd IWLTechTask/`
2. install PHP, Composer, and Laravel `/bin/bash -c "$(curl -fsSL https://php.new/install/linux/8.4)"`
5. install nodejs and npm `sudo apt install -y nodejs npm`
6. install NVM `curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.5/install.sh | bash`
4. Update PATH `source /root/.bashrc`
7. update to and use nodejs v24 `nvm install 24`
8. swap to node v24 `nvm use 24`
9. install npm and composer packages `npm install & composer install`
10. If not running locally, allow traffic through remote port `ufw allow <port number>`
11. Enable UFW `ufw enable`
12. create .env file and generate key `cp .env.example .env & php artisan key:generate`
13. run database migrations and run the seeder `php artisan migrate:fresh --seed`
14. note down the API key for the sample user (to be used in postman) and the record ID that the user will not be able to access - included for proof of the user not being able to access records outside of their tenancy. To check about the records existing, you can remove the restriction in the Device Model class (the added global scope) when accessing the index API endpoint
15. start the vite server `npm run dev`
16. in a separate terminal, serve the laravel app, host and port only needed if not remote `php artisan serve --host<your ip here> --port<your port here>`

    I have included a Postman collection with the listed endpoints to aid in testing:

- GET /api/v1/devices - lists all devices the user can access
- GET /api/v1/devices/{device} - lists all info about a specific device
- GET /api/v1/devices/{device}/status - retrieves the current status of a specific device (only the information for the provided widget)
- POST /api/v1/devices/{device}/telemetry - adds a new device log record using the provided metrics. the request body format must be supplied as JSON in the below format:


```
{
    "requestType": "telemetryUpdate",
    "data": {
        "battery_charge": <numeric value>,
        "sensor_life": <numeric value>
    }
}
```