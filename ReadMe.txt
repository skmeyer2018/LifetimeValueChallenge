This program is the front-end client version of the Technical Challenge of the URL reducer.

The finished program must be set up using XAMPP for Windows, and setting up a MySQL database named URLShrink, table name shorterurls, fields DateCreated, OrigURL, ShortURL, HitCount and URLid with Auto Increment.

The content of the program consists of a form containing an input field for the original URL, and a submit button.

The user presses the submit button, then the program respond by running the back-end to determine the condition of the input.  Using some cURL commands in the back-end, if the input is either blank or invalid URL, it displays a message "CANNOT CONVERT!".  But if the URL is acceptable, then it checks the databae to see if already exists.  If it already exists, it says it already extists, and displays the short URL in a hyper link, plus counts number of hits.  But if not in database, the program adds both the original URL, the new shortened URL and the date and time created, plus displays a scrolling list of two columns of URLS, the orgininal and the hyperlinked short URL.


