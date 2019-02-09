# PlanningTestOK

Rik Van Hauwe
6/2/2019

Test Opdracht:

Make a php-console script that creates a csv file. The csv file is a template containing a list of meeting dates that can be used for planning. The script requests for input:
•	A start date from which the planning should be created
•	An interval in days that should be respected
•	An end date

The csv should contain the number of the meeting and the date.

The script should generate the file with all meeting dates from the start date till the end date. Keep in mind:
•	The meeting dates should be on each n-th day, based on the given interval
•	A meeting can’t be in the weekend
•	Saturday and Sunday should not be counted as days
•	A meeting can’t be on the 25/12 or 1/1
•	A meeting can’t be on the 5th of 15th of each month

You decide if you use a framework, other technologies or plain php. The code should work for at least php 7.0. Please send the code using GIT (Github or Bitbucket)


My Remarks:

- simple file structure (no classes used - could be made with Laravel / Symphony / Wordpress ...) : just PHP with "index.php" and "functions.php"

- using CDN avoiding local files

- visual selection of dates using bootstrap-datepicker (can be done without using eg dropdowns)

- no error checking on the csv part

- simple csv output to fixed file with header record

- created and tested with phpstorm and xampp
