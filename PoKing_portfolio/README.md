# PoKing - Event managment app

Let me introduce my project to you.

The aim of this project is to make it easier to run a poker club. My site helps them manage their events and rankings.

My Deployed Site: https://vimeo.com/manage/videos/1030494936

Final Project Blog Article: https://www.linkedin.com/pulse/my-poking-project-alexis-billemont--lgyce/

My LinkedIn Profiles: https://www.linkedin.com/in/alexis-billemont-a985612a8/


## Installation
Clone the Repository:
'''bash
git clone git@github.com:git-alexis/holbertonschool-porfolio-PoKing.git
'''

Navigate to the Project Directory:
* cd PoKing_portfolio

Install Backend Dependencies:
Ensure you have Symfony and PHP installed !
* composer install

Create your database

Generate and push your migrations:
* php bin/console doctrine:migrations:diff
* php bin/console doctrine:migrations:migrate

Configure environment variables by creating a .env file based on the .env.example file

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
