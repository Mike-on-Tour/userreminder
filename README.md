# Userreminder

![Version: 1.3.5](https://img.shields.io/badge/Version-1.3.5-green)  
  
![phpBB 3.2.x Compatible](https://img.shields.io/badge/phpBB-3.2.x%20Compatible-009BDF)
![phpBB 3.3.x Compatible](https://img.shields.io/badge/phpBB-3.3.x%20Compatible-009BDF)  

Userreminder is an extension to the phpBB bulletin board (**version 3.2.0 and later**) to manage inactive users

## Description
Userreminder enables administrators to check their board for three different types of users:

-	Users who have not been online for a selectable number of days (called inactive users); these users can be reminded of logging in again with one or
	two emails and after another period of time can be deleted. The number of days between the emails and the deletion can be selected. You can have done
	reminding and deleting the users automatically if desired.
-	Users who have registered but never visited again after activation (called sleepers), these users can be deleted manually.
-	Users who are online on a more or less regular basis but have never posted something (called zeroposters), these can be deleted manually, too.

All three above mentioned tables are displayed in the ACP Extension tab.

The username displayed in these tables contains a link to this user's profile which will open in a new browser tab or window (depending on your browser settings).

## Settings
With an additional settings tab you can enter the different time frames as a
number of days (e.g. 70 days until a user shows up as inactive). For your convenience you can select to remind and/or delete users automatically.
If selected, automatic reminding and/or deleting users is triggered as part of the login routine which also resets possible reminder dates for this user
to zero in order to show no longer in the table displaying inactive users.  
**It is strongly recommended to check the number of users to be reminded in the respective tables before enabling automatic reminding in order to prevent mail errors due to a high number of emails to be sent which might exceed the limit set by your provider. In case of a high number of users to be reminded please consider doing it manually until you have only one or two pages of inactive users!**

Sleepers and zeroposters are displayed with the number of inactive days. Administrators can select those users for manual deletion, they will not be
reminded by default.  
Zeroposters can be enabled to be handled as inactive users, that is to be reminded and deleted like them. If you enable this configuration value all of the above mentioned settings will apply to zeroposters. The table with the zeroposters will then look like the one for inactive users.

If you want to protect users from getting reminded and deleted you can define those users either individually by their username or you can protect all members of one or more default groups by selecting those groups. Please note, that only those groups used as default groups for founders and normal users are displayed and only their members can be protected.  

There is also a possibility to add one email address each for a bcc and/or cc copy of the reminding mails.

In the last part of the settings tab you can edit the text of the emails, a preview of how your text will look like is available.

**Starting with ver 1.3.3** the "productive" ACP pages (Remind users, Sleepers and Zeroposters) can be added to one other tab of the ACP, e.g. to the "Quick access" tab. These additional links MUST be manually deleted prior to deactivating and deleting data of Userreminder.

## Important !!!
-	Users are deleted by retaining their posts in order to prevent gaps in your forum threads!  
-	Automatic sending of reminder mails or deletion of users is part of the login routine whenever a user logs into the board; at this moment the variables for
	the last reminding mails - if there were any - are reset to zero to flag this user as active. Another part of this routine is checking whether automatic
	mail sending and/or automatic deletion is activated, in this case the extension checks for users due to be reminded or deleted.
-	Starting with ver 1.3.3 Userreminder checks for banned users and adds them during execution to the protected users to prevent banned users from being reminded or deleted.
