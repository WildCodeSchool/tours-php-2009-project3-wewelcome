# WeWelcome

### This project is a showcase site for the company WeWelcome.

The manager of the company wants :

* be able to directly modify the content of the pages (texts, photos, links, etc.) => admin login and modification forms.
* be able to be contacted directly via the site => mail sending.
* be able to contact the manager to work with him and send him documents directly via the site.

This project was made with symfony 5.

## Requirements

- Php ^7.2 http://php.net/manual/fr/install.php;
- Composer https://getcomposer.org/download/;

## Installation

1. Clone the current repository.

2. With mysql, create a wewelcome database and create a user. Don't forget to give the rights to the user.
> If you want to use another service, see the official symfony documentation

3. Move into the directory and create an `.env.local` file (copy env file). **This one is not committed to the shared repository.**

4. Line 32, set `db_name` to **wewelcome** and set the user `db_user` and the password `db_password`.
> Make sure the connection with the base is functional

5. Uncomment line 37, replace `smtp` with gmail and replace `localhost` by your email address. Then enter the password for your email address.
> Line 37 should look like this: MAILER_DSN=gmail://your adress mail:your password@default

6. Execute the following commands in your working folder to install the project:

```bash
# Install dependencies
composer install

# Create 'wewelcome' DB
php bin/console d:d:c

# Execute migrations and create tables
php bin/console d:m:m
```

7. Go on the /init page and register you as an admin user : you have to put an email address and a password

> Reminder: Don't use composer update to avoid problem

> Assets are directly into _public/_ directory, **we will not use** Webpack with this project

## Usage

Launch the server with the command below

```bash
$ symfony server:start
```
