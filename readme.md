# Infirmary Scheduling System

Welcome to the Infirmary Scheduling System! This system is designed to streamline the scheduling process for medical staff and patients in an infirmary or medical facility.

## Features

- Login as Admin - Temporarily for viewing only (url: http://localhost/Infirmary-Scheduling-System/admin)

- Login as Student (URL: http://localhost/Infirmary-Scheduling-System)
	- Register Student
    	- Student Number:
        	- Must be unique
    	- Email:
			- Must be unique
			- Account must be verified via email
    	- Mobile Number:
    		- Must start with '09'
    		- Must be 11 digits long (+63 are invalidated)
    	- Password Validation:
    		- Must be equal to the 'Confirm Password' field
    		- Must be at least 8 digits long
    		- Password is encrypted by password hashing algorithm 'bcrypt' (see https://en.wikipedia.org/wiki/Bcrypt for more details)

- Dashboard (URL: http://localhost/Infirmary-Scheduling-System/dashboard)
	- Generate Schedule:
    	- Walk In
        	- Date must be at least today
        	- Time must be between 8:00 AM and 5:00 PM
        	- If date is set 'today', the time must be 1 hour ahead
      	- Annual Physical Exam
        	- Date must be at least 2 days ahead from today
        	- Time must be between 8:00 AM and 5:00 PM
		- 'Generate Schedule' button will be disabled after 3 cancel attempts (to reset this, 'Cancelled' status must be replaced with 'Expired' status by admin)

- My Appointments (URL: http://localhost/Infirmary-Scheduling-System/appointments)
	- Displays all generated schedules/appointments with the latest at the top

- My Profile (URL: http://localhost/Infirmary-Scheduling-System/profile)
	- Account Settings
    	- Before updating the password, system will validate the current password (to check if the owner of the account is using the system)
    	- New Password:
        	- Must be equal to the 'Confirm Password' field
    		- Must be at least 8 digits long
    		- Password is encrypted by password hashing algorithm 'bcrypt' (see https://en.wikipedia.org/wiki/Bcrypt for more details)