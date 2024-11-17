![Logo](/assets/images/poking.png)

Introduction :

Welcome to the Tank Information App! This web application is designed to provide detailed information on tanks, including their skills, strategies, and comparative characteristics. Users can register, log in, and explore various features related to tanks and their attributes.

My Deployed Site:

Final Project Blog Article:

My LinkedIn Profiles:


## Installation
Clone the Repository:
* git clone https://github.com/git-alexis/Holberton-portfolio.git

Navigate to the Project Directory:
* cd tank-information-app

Install Backend Dependencies:
Ensure you have Symfony and PHP installed !
* composer install

Install Frontend Dependencies:
* npm install

Configure your database in .env:
* DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name

Create the database and:
* php bin/console doctrine:database:create
* php bin/console doctrine:migrations:migrate

Start the Development Server:
* symfony server:start

Access the Application:
* Open your browser and go to http://localhost:8000


## Usage
* Home Page: The main landing page of the application.
* Register Page: Allows new users to create an account
* Login Page: Enables existing users to log in.

* Tank Pages: Create or update tanks and see their historical record.
* Skill Pages: Create or update skills and see their historical record.
* Strategy Pages: Create or update strategies and see their historical record.

* Tank-Skill Page: Do connection between tanks and their skills.
* Skill-Strategy Page: Do connection between skills and strategies.

* Comparison Page: Allows users to compare tank characteristics using data from the World of Tanks API (currently non-functional due to expired API certificate).


## Contributing
Fork the Repository:
* Click the "Fork" button on the top-right of the repository page.

Clone Your Fork:
* git clone https://github.com/your-username/tank-information-app.git

Create a New Branch:
git checkout -b feature/your-feature

Make Changes and Commit:
* git add file_name
* git commit -m "Add a meaningful commit message"

Push Changes:
* git push origin feature/your-feature

Open a Pull Request:
* Go to the original repository and open a pull request with a description of your changes.


## Related Projects
* World of Tanks API Integration - A project demonstrating how to integrate with the World of Tanks API.


## Bugs
The reset password functionnality doesn't work for the moment !


## License
The Tank Tales app is free and open-source software licensed under the GNU General Public License.
