# Userreminder

![Version: 1.7.0](https://img.shields.io/badge/Version-1.7.0-green)  
  
![phpBB 3.2.x Compatible](https://img.shields.io/badge/phpBB-3.2.x%20Compatible-009BDF)
![phpBB 3.3.x Compatible](https://img.shields.io/badge/phpBB-3.3.x%20Compatible-009BDF)
![phpBB 4.0.x-dev Compatible](https://img.shields.io/badge/phpBB-4.0.x%20dev%20Compatible-009BDF)  

[![Build Status](https://github.com/Mike-on-Tour/userreminder/workflows/Tests/badge.svg)](https://github.com/Mike-on-Tour/userreminder/actions)

Userreminder is an extension to the phpBB bulletin board (version 3.2.0 and later) to manage inactive users

## Description
Userreminder enables administrators to check their board for three different types of users:

-	Users who have not been online for a selectable number of days (called inactive users); these users can be reminded of logging in again with one or
	two emails and after another period of time can be deleted. The number of days between the emails and the deletion can be selected. You can have done
	reminding and deleting the users automatically if desired.
-	Users who have registered but never visited again after activation (called sleepers), these users can be deleted manually.
-	Users who are online on a more or less regular basis but have never posted something (called zeroposters), these can be deleted manually, too.

All three above mentioned tables are displayed in the ACP Extension tab.

The username displayed in these tables contains a link to this user's profile which will open in a new browser tab or window (depending on your browser
settings).

## Settings

With the settings tab you can configure Userreminder to your needs.  
For this purpose it is divided into seven sections:

#### *General settings*

In this section you can select the number of rows to be displayed per table page on the other tabs and whether to use the expert mode on those tabs.  
The expert mode adds two additional buttons to Userreminder's other three tabs where the `Remind all` button reminds all members in the respective table
who have exceeded the time frame of being inactive (for details please refer to the next section) or in case of the sleepers of not logging into your forum.
This is kind of an abbreviation of reminding manually a large number of inactive users by marking and reminding them page by page.  
The second, the `Delete all` button literally does this; it deletes **all** members listed in the respective table! So be very careful using this button
since you can delete a large number of your members with just one mouse click. Before usage please check whether really all members in the respective
table are to be deleted!

#### *Configure the reminder intervals*

Here you can enter the different time frames as a
number of days (e.g. 70 days until a user shows up as inactive). For your convenience you can select to remind and/or delete users automatically.
If selected, automatic reminding and/or deleting users is triggered as part of the login routine which also resets possible reminder dates for this user
to zero in order to show no longer in the table displaying inactive users.  

#### *Sleeper configuration*

By default sleepers are only listed in the respective table with the possibility to mark them manually for deletion. Starting with ver 1.4.0 Userreminder
enables you to remind sleepers as well. For this purpose you can enable this feature here and after you have done so you will see to additional options,
namely the number of days since registration without logging into your forum which defines the time a sleeper gets reminded and the possibility to do the
reminding automatically.  
With the next setting you can enable the automatic deletion of sleepers. After enabling this option you will see another input field where you can define
the number of days without logging in after the registration a sleeper will be deleted.  
If you combine those two settings the deletion will take place after the reminding time frame and the deletion time frame have elapsed.  
If you do not want to do reminding and deleting automatically the squares to mark a sleeper for reminding or deletion will show up in the tab after the
respective time frame has elapsed.

#### *Zeroposter configuration*

Zeroposters can be enabled to be handled as inactive users, that is to be reminded and deleted like them. If you enable this setting you will be able to set all of the
settings mentioned in the *Configure the reminder intervals* section for zeroposters independently from those. The table with the zeroposters will then look like the one
for inactive users. Otherwise you will only be able to manually select zeroposters for deletion.

#### *Protected users configuration*

If you want to protect users from getting reminded and deleted you can define those users either individually by their username or you can protect all
members of one or more default groups by selecting those groups. Please note, that only those groups used as default groups for founders and normal users
are displayed and only their members can be protected.  

#### *Email configuration*

Sometimes - especially right after installing Userreminder - there may be a large number of members due to get a reminder by email, this number could very
well be larger than the number of emails you are allowed to sent within a short time. If the number of emails to be sent exceeds the limits defined by
your provider it is probable that not all emails are being sent although you may think that they have been sent.  
To prevent "loosing" emails you can set the number of emails being sent in a given time frame in this section. Please get the limits from your provider
and enter them here but keep in mind that your board's software might send other emails as well, e.g. for notification. Therefore it is a sound decision
to not enter your provider's limit of emails but use only a percentage, e.g. 75% to be safe. If your provider allows you to send 250 emails within one
hour it might be a good idea to enter a limit of 200 emails. Another example would be a limit of 3.000 emails within a one day (86.400 seconds) time frame.
In this case it would be prudent to enter only 2.000 emails as your daily limit.  
Why do you have set these limits? Imagine you have 500 members due to get a reminding mail but your provider only allows chunks of 100 emails per hour (3.600
seconds). When reminding your inactive members Userreminder checks those limits and sends only an initial chunk of 100 mails, the other 400 members' data is
stored in a database table and you will see in the reminding tab that all your 500 members are reminded. After one hour (the time frame you have defined)
Userreminder checks whether there are still members to be reminded in the database table. If this is the case it will send another 100 mails and after another
hour another 100 mails and so on. In this way all members will be reminded without you having to worry about how many mails you can send at any given time.  
Please note that you will find only the sent email reminders in the admin log which means that with an email limit of 150 emails per time frame and 600
members to be reminded you will find four entries of sent reminder mails in the admin log with four different time stamps which are approximately the defined 
time span apart.
  
As a means to monitor the status of the cron task for sending emails waiting in the email queue you find an information panel displaying the time this cron
task run the last time and how many emails can currently be sent without being moved into the queue. If this last number equals zero the cron task used all
available emails during its last run.
  
There is also a possibility to add one email address each for a bcc and/or cc copy of the reminding mails.
  
In addition you can define an email address which will be used as the FROM address for all emails sent by Userreminder. If you leave this field empty the
FROM address defined in the `Email settings` page wil be used.  
Please note that in the case of using the email address defined in this section the `Contact email address` will be used as the `Reply to` address!
  
If you want to suppress the `Reply to` address in the email header you can do this by activating the respective option in this section.

#### *Edit the email texts*

In the last section of the settings tab you can edit the text of the emails, including a preview of how your text will look like. For the latter the user
data of the administrator (you) will be used.
  
Starting with **ver 1.6.0** you can send a testmail from this section. If you have defined a BCC or CC mail address these will be preselected in this order as the
addressee of this testmail but you can edit this field and enter any email address you wish. After hitting the `Send mail` button an email will be sent to
this address in the selected language with the selected mail text.

---------
  
Sleepers and zeroposters are displayed with the number of inactive days. Administrators can select those users for manual deletion, they will not be
reminded by default.  


**Starting with ver 1.4.0** the "productive" ACP pages (Remind users, Sleepers and Zeroposters) are added to the ACP's "Quick access" tab.
These additional links can be activated through the `System` tab.

## Important !!!
-	Users are deleted by retaining their posts in order to prevent gaps in your forum threads!  
-	Automatic sending of reminder mails or deletion of users is part of the login routine whenever a user logs into the board; at this moment the variables for
	the last reminding mails - if there were any - are reset to zero to flag this user as active. Another part of this routine is checking whether automatic
	mail sending and/or automatic deletion is activated, in this case the extension checks for users due to be reminded or deleted.
-	Starting with ver 1.3.3 Userreminder checks for banned users and adds them during execution to the protected users to prevent banned users from being
	reminded or deleted.
-	In ver 1.4.0 three ACP tabs have been added to the `Quick access` menu to enable admins to use the `Remind users`, `Sleepers` and `Zeroposters` tabs
	without going to the extensions tab first.  
	Please note that these tabs are inactive and have to be activated through the `System` tab prior to their usage.

## Installation / Activation
To install Userreminder on your board copy the unzipped files into the `/ext` folder on your server using a FTP software which supports the binary transfer
mode and strictly use this mode! After finishing the file transfer you should find a directory structure like `/ext/mot/userreminder` on your server with
the `composer.json` file in the latter folder.
Then go to your board's ACP and select the `Customise` tab and there the `Manage extensions` link. In the now opening window you will find Userreminder in the
`Not installed extensions:` section. Please click on the `Enable` link in the line containing Userreminder and follow the instructions.
After successfully enabling Userreminder you will find its pages on the `Extensions` tab.
