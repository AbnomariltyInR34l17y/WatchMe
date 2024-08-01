WatchMe - Web Project

In my project I created "WatchMe", a streaming service that enables user:
1) To create an account
2) Create a wallet
3) Buy videos
4) Watch videos
5) See transactions (in case have)

HOW TO
1) Paste the directory in your nginx directory
2) Run "watchme.sql"
3) Change user name and passwords in ".credentials"
4) Have fun

FILE SYSTEM HIERARCHY
Main path always starts with "/WatchMe/". 
Therefore, or the rest of the project, when talking about paths, you HAVE to remmber to add "/WatchMe/" + "/..." 
Example:
"index.html" is "/WatchMe/index.html"

Files and Directories inside the "public" directory are refering to the frontend
Everything inside "api" is related to the backend.

The system works with the $_SESSION. That is why the route a user should have is limited.
The prefered path is:

Example:
GUI/file/path 
{"Request": "Body"}

public/register.php
{"action": "signMeUp", "username": "maxiP",  "password": "bot"}

public/login.php
{"action": "logMeIn",  "username": "maxiP",  "password": "bot"}

public/my-profile.php
{"action": "getMyTransactions"}
{"action": "updateUserInformation", "username": "maxiP", "password": "bot1"}

public/explore-videos.php
{"action": "getAllMovies"}

public/watch-video.php
{"action": "getOneMovie", "movieId": 1}
{"action": "iWantThis", "movieId":1}

public/create-wallet.php
{"action": "createNewWallet", "password": "maxiP"}

public/log-in-wallet.php
{"action": "getMyWallet", "password":"maxiP"}
__________________________________________________

SESSIONS
- Sessions located in "/etc/lib/php/sessions" (Ubuntu)

SECURITY
+ For extra security the user have two passwords. One for the user and one to it's wallet.

FUTURE DEVELOPMENT

*) Comunicate with the company
*) Hashing passwords
*) Input sanitation
*) Inform user on cookies
*) Make DB case-sensitive

DB TABLES:
-- The end_users table
-- The wallet table
-- The user_transactions table
-- The movies table



Extra Notes:
=-=) This project built on PHPMyAdmin, you may need to change the apache2.conf to prevent LFI
Change: "AllowOverride" to "All"
Location: /etc/apache2/apache2.conf (Ubuntu)
