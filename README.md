# NaviChat

Live Website: navichat.info

Chatbot test site: navichat.infinityfreeapp.com

Introduction:

1. Login to an registered user account in the website navichat.info.
2. Proceed to the chatbot test site and interact with it.
3. Watch data get updated live into the website from your interaction with the chatbot.



-----------------------------------------------------
For local testing

XAMPP services:
- Apache
- MySQL
1. Import the navichat.sql into your database
2. Put the navichat folder into htdoc folder
3. Open web browser and go to localhost/navichat

ngrok service:
1. Start the program
2. Type "ngrok http 80" into the console
3. Copy the forwarding address into the Webhook of DialogFlow and then include the file path of data_tracker.php.
(eg. https://ngrokforwadingaddress/navichatv6/data_tracker.php)


