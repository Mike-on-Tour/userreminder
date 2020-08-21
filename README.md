# Userreminder

![phpBB 3.2.x Compatible](./phpBB-3.2.x_kl.jpg) ![phpBB 3.2.x Compatible](./phpBB-3.3.x_kl.jpg)

Userreminder is an extension to the phpBB bulletin board (**version 3.2.6 and later**) to manage inactive users

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
number of days (e.g. 70 days until a user shows up as inactive). For your convenience you can select to remind and/or delete users automatically. If
there are users you want to protect from getting reminded or deleted you can define those users by their user_id.  
If selected, automatic reminding and/or deleting users is triggered as part of the login routine which also resets possible reminder dates for this user
to zero in order to show no longer in the table displaying inactive users.

Sleepers and zeroposters are displayed with the number of inactive days. Administrators can select those users for manual deletion, they will not be
reminded.

There is also a possibility to add one email address each for a bcc and/or cc copy of the reminding mails.

In a second part of the settings tab you can edit the text of the emails including a preview.

## Important !!!
-	Users are deleted by retaining their posts in order to prevent gaps in your forum threads!  
-	Automatic sending of reminder mails or deletion of users is part of the login routine whenever a user logs into the board; at this moment the variables for
	the last reminding mails - if there were any - are reset to zero to flag this user as active. Another part of this routine is checking whether automatic
	mail sending and/or automatic deletion is activated, in this case the extension checks for users due to be reminded or deleted.