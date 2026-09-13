# Activity Tracker

Application built on PHP 8.1 that tracks user activity — login, registration,
page views, and button clicks. Built on pure PHP without frameworks and run with Docker.

## Pages

- **Login / Register / Logout** — session-based authentication.
- **Page A** — a "Buy cow" button; after clicking, it disappears and shows a thank you message instead.
- **Page B** — a "Download" button that downloads a file.
- **Stats** (admin only) — a table of all tracked events, filterable by date, user, and action.
- **Reports** (admin only) — a line chart of daily activity plus a totals table.

## Roles

- **user** — can authenticate and view pages A and B.
- **admin** — everything a user can do, plus the Stats and Reports pages.

## Requirements

- Docker Desktop



## Setup

### 1. Configure environment

Run this command in the terminal:

> cp .env.example .env

Then put credentials that you want for username and password.
Restart the docker with docker compose restart to apply changes if on the first place doesn't work.

### 2. Start the containers

From the project root, run:
> docker compose up -d --build

This starts the services for:

- phpMyAdmin
- PHP and Nginx
- MySQL

### 3. Create the database tables

The `activity` database is created automatically, but the tables are not, so you
need to import them once. You can do this either through the terminal or through
phpMyAdmin.

**Option A — terminal**

> Import `users` before `events` — the `events` table has a foreign key that
 references `users`, so the `users` table must exist first.


> Get-Content database/01_users.sql | docker compose exec -T mysql mysql -u <user> -p<password> activity
> Get-Content database/02_events.sql | docker compose exec -T mysql mysql -u <user> -p<password> activity


Verify the tables were created:

> docker compose exec mysql mysql -u <user> -p <password> activity -e "SHOW TABLES;"


**Option B — via phpMyAdmin**

1. Open phpMyAdmin at **http://localhost:8081**
2. Log in with the user and password from your `.env` file.
3. Select the **activity** database on the left.
4. Open the **SQL** tab.
5. Paste the contents of `database/01_users.sql` and click **Go**.
6. Paste the contents of `database/02_events.sql` and click **Go**.

> Import `users` before `events` — the `events` table has a foreign key that
 references `users`, so the `users` table must exist first.

## Usage

Open the app at **http://localhost:8080**. 
Open PHPMyAdmin at **http://localhost:8081**.