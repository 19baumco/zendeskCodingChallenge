# Zendesk Coding Challenge #
A PHP application to view Zendesk Tickets in a browser UI

Windows Instructions:
### Downloads: ###
1. XAMPP v3.3.0
2. PHPUnit v9.5.10
3. Contents of this repository

#### XAMPP Instructions ####
1. Install to C: drive and Run
2. Select START on the Apache and MySQL modules
3. Navigate to C:\xampp\htdocs and create a new folder titled "zendesk"
4. Place the downloaded contents of this repository in C:\xampp\htdocs\zendesk

#### PHPUnit Instructions ####
1. Create a directory for PHP binaries; e.g., C:\bin
2. Append; C:\bin to your PATH environment variable 
   - View Advanced System Settings -> Environment Variables -> Select "Path" -> Edit -> New -> C:\bin
3. Append; C:\xampp\php to your PATH environment variable
   - View Advanced System Settings -> Environment Variables -> Select "Path" -> Edit -> New -> C:\xampp\php
4. Place the downloaded PHPUnit .phar file in your C:\bin folder and rename to "phpunit.phar"
5. Run the following in command prompt: 
   
   `cd C:\bin`
   
   `echo @php "%~dp0phpunit.phar" %* > phpunit.cmd`
   
   `exit`
6. Run the following in command prompt:
   
   `phpunit --version`
   - This should display "PHPUnit x.y.z by Sebastian Bergmann and contributors"

#### Run PHP application ####
1. In your browser of choice, enter the URL of http://localhost/zendesk/index.php
2. Within a few moments, the application will have pulled and displayed all the tickets available in the Zendesk subdomain of "zccbaumgarth"
3. The application may be navigated using the page selection or the navigation arrows
