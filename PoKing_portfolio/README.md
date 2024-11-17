# PoKing - Event managment app

Let me introduce my project to you.

The aim of this project is to make it easier to run a poker club. My site helps them manage their events and rankings.

My Deployed Site: https://vimeo.com/manage/videos/1030494936

Final Project Blog Article: https://www.linkedin.com/pulse/my-poking-project-alexis-billemont--lgyce/

My LinkedIn Profiles: https://www.linkedin.com/in/alexis-billemont-a985612a8/


## Installation
Clone the Repository:
* git clone https://github.com/git-alexis/holbertonschool-porfolio-PoKing.git

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
* open your browser and go to http://localhost:8000


## Usage
When you arrive on the home page of the site, you can:
* log in
* create an account
* reset your password

When you are logged in, menu links allow you to:
* access your account to change your personal details
* view events to register or unsubscribe
* check the rankings for a particular event and the general rankings
* generate statistics

The footer links allow you to:
* contact the club by e-mail to request information
* consult the legal notices


## Contributing
Fork the repository:
* click the "Fork" button on the top-right of the repository page.

Clone your fork:
* git clone https://github.com/your-username/holbertonschool-porfolio-PoKing.git

Create a new branch:
* git checkout -b feature/your-feature

Make changes and commit:
* git add file_name
* git commit -m "Add a meaningful commit message"

Push changes:
* git push origin feature/your-feature

Open a pull request:
* go to the original repository
* open a pull request with a description of your changes


## Related Projects
* landing page: https://statuesque-druid-f3ad85.netlify.app/
* blog linkedin: https://www.linkedin.com/pulse/my-poking-project-alexis-billemont--lgyce/


## Bugs
The reset password functionnality doesn't work for the moment !


## License
The PoKing app is free and open-source software licensed under the GNU General Public License.
