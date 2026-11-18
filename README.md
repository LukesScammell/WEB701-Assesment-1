# Pixel Pals – WEB701 Assessment 2

## Project Overview

Pixel Pals is a fictional non-profit esports charity website developed for WEB701 – Web Technology.

The website aims to support young people through gaming, esports events and community fundraising. It provides a platform where users can learn about the charity, browse events, register esports teams and donate virtual Pixel Tokens.

The final website was developed using Laravel 13, PHP, Blade templates and SQLite.

## Technologies Used

| Technology | Purpose |
|---|---|
| Laravel 13 | Backend framework, routing, authentication and validation |
| PHP 8.3 | Server-side programming |
| Blade | Dynamic webpage templates |
| SQLite | Database storage |
| Eloquent ORM | Database models and relationships |
| HTML and CSS | Website structure and styling |
| Vite | Frontend asset building |
| Composer | PHP dependency management |
| npm | JavaScript dependency management |
| Git and GitHub | Version control |

The project also includes Livewire, Axios and Tailwind CSS dependencies. These should not be confused with custom implementations unless their functionality is demonstrated in the source code.

## Website Features

### User Accounts
- User registration, login and logout
- Secure password hashing
- Initial allocation of 500 virtual Pixel Tokens
- Authentication for protected website features
- Administrator-specific permissions

### Esports Events
- View available esports events
- Display event information and team requirements
- Administrator event creation, editing and deletion

### Team Registration
- Register a team for an esports event
- Enter team name, contact details and player usernames
- Validate the number of players against the event's required team size
- View registrations through the My Teams page
- Edit registrations before the event begins
- Restrict users to managing their own registrations

### Donations
- Donate virtual Pixel Tokens
- Select predefined donation amounts
- Check available token balances
- Update balances after successful donations
- Display fundraising progress

### Information Pages
- Home
- Events
- Donations
- About Us
- Achievements
- Sponsors & Partners
- Contact

## Installation and Setup

### Prerequisites

Ensure the following are installed:

- PHP 8.3 or a compatible version
- Composer
- Node.js and npm
- PHP SQLite extensions
- Git

### 1. Open the Project

Open the `Milestone_3` directory in VSCodium or another code editor.

### 2. Install Dependencies

Install the Laravel dependencies:

```bash
composer install
```

Install the JavaScript dependencies:

```bash
npm install
```

### 3. Configure the Environment

If an `.env` file does not already exist, copy the example environment file:

```powershell
Copy-Item .env.example .env
```

Generate the Laravel application key:

```bash
php artisan key:generate
```

Ensure the `.env` file contains the following database configuration:

```env
DB_CONNECTION=sqlite
```

### 4. Set Up the Database

Create the SQLite database file if it does not already exist:

```powershell
New-Item database/database.sqlite -ItemType File
```

Run the database migrations:

```bash
php artisan migrate
```

If the project includes seeders for example events or other required data, run:

```bash
php artisan db:seed
```

### 5. Run the Website

Start the Laravel development server:

```bash
php artisan serve
```

In a second terminal, start Vite:

```bash
npm run dev
```

Open the website at:

http://127.0.0.1:8000

Alternatively, frontend assets can be compiled using:

```bash
npm run build
```

## User Roles

**Guest:** Can view public information and browse available events.

**Registered User:** Can log in, register teams, manage their own registrations and donate Pixel Tokens.

**Administrator:** Can access event management functionality to create, update and delete events.

## Database

The application uses SQLite for persistent data storage.

Laravel Eloquent models are used to interact with the database and manage relationships between users, events, team registrations and donations.

Database migrations define the required table structures.

## Testing

The website was manually tested during development, including:

- Account registration and login
- Administrator event management
- Team registration and validation
- Viewing and editing team registrations
- Donation processing and token balance updates
- Database storage and retrieval
- Navigation between website pages

Additional automated feature testing would be a useful future improvement.

## Project Limitations

Pixel Tokens are virtual and do not represent real currency. The website does not process real financial payments.

The project is intended as an educational implementation rather than a production-ready charity platform.

## Future Improvements

Potential improvements include automated testing, enhanced account management, more dynamic frontend interactions and integration with a real payment provider.

## Assessment Information

**Course:** WEB701 – Web Technology
**Assessment:** Assessment 2
**Project:** Pixel Pals
**Framework:** Laravel 13

## References

- Laravel Documentation: https://laravel.com/docs/13.x
- PHP Documentation: https://www.php.net/docs.php
- SQLite Documentation: https://www.sqlite.org/docs.html
- Vite Documentation: https://vite.dev/guide/
