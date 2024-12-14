# PMMS
SEP Project 2023

[![Testing Laravel with MySQL](https://github.com/chanyuenfu/pmms/actions/workflows/laravel.yml/badge.svg?branch=main)](https://github.com/chanyuenfu/pmms/actions/workflows/laravel.yml)

## Step to run
1. Clone this repository
2. Open VSCode and open the folder
3. Copy `.env.example` and rename it to `.env`
4. Open a terminal and Run `composer install`
5. Run `npm install`
6. Run `php artisan key:generate`
7. Run `php artisan migrate:fresh --seed`
8. Open a terminal and Run `npm run dev` 
9. Open a terminal and Run `php artisan serve` to start the server
10. Open a browser and go to `http://localhost:8000` or as stated in the terminal
11. Use the following credentials to login
    - Admin
        - Username: admin@test
        - Password: test
    - Cashier
        - Username: cashier@test
        - Password: test
    - Coordinator
        - Username: coordinator@test
        - Password: test

## Integration Plan
- [x] User
- [x] Inventory
- [x] Payment
- [x] Report
- [x] Duty Roster
- [x] Announcement
