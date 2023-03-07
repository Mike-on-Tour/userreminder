# Change Log
All changes to `Userreminder for phpBB` will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [1.7.0] - 2023-03-08

### Added
-	The possibility to set reminding times for zeroposters independently from those of inactive users
  
### Changed
-	Some code optimizations (e.g. exchanging if-clauses with ternary operators)
  
### Fixed
  
### Removed
  
  
## [1.6.0] - 2023-02-22
Please note that this version has not been released or published
### Added
-	An `Installation / Activation` section to the `README.md` file
-	To the `Email configuration` section the possibility to define a FROM email address for Userreminder mails and a switch to suppress the reply-to address
-	To the `Email configuration` section the display of the total number of emails waiting in the mail queue 
-	To the `Edit the email texts` section the ability to send a testmail to an address which can be defined there
  
### Changed
-	The slider colours into `gray` (deactivated) and `blue` (activated) to improve readability for colorblind persons
  
### Fixed
  
### Removed
-	The `spaceless` tag from the `adm/style/acp_ur_settings.html` file since this is deprecated with TWIG 2.7
  
  
## [1.5.0] - 2023-01-03

### Added
-	An additional language file in all languages present to support the extension requirements check
  
### Changed
-	The range of usable PHP versions to 7.2.0 up to all versions less than 8.3.0
-	The range of usable phpBB versions to 3.2.0 up to less than 3.4.0 dev
-	The check for PHP and phpBB versions in `ext.php`
-	All PHP files to short array syntax
-	The radio buttons in the ACP settings tab into sliders with the "activated" state on the left and the "deactivated" state on the right side (according
	to the "Yes" and "No" radio buttons) with a variable `SLIDERS` which can display the old radio buttons if set to 'false' in the
	`adm/style/acp_ur_settings.html` file
-	The explicit usage of `ENT_COMPAT` in the call of `htmlspecialchars_decode()` to comply with the changes in PHP 8.1 and above (`common.php`)
-	The cron job no longer tries to get all rows from the REMIND_MAIL_QUEUE_TABLE but only the number of rows equivalent to the number of available mails
  
### Fixed
-	The number of available mails was not updated if the mail limit was changed, therefore the new lines 117 - 122 and 144 - 149 in `controller/ur_acp.php`
-	The display of a date of the last cron job run if the timestamp is equal to zero (line 275 in `controller/ur_acp.php`) which resulted in something
	like 'Jan. 1, 1970 00:00'
-	A missing condition in the query for inactive users by which sleepers with a post count greater zero are selected (new line 389 in `controller/ur_acp.php`)
-	Delete user from the reminder queue during login to prevent sending a reminder mail after login if the mail to this user is in the queue
	(new lines 121 - 125 in `event/main_listener.php`)
-	Some minor errors in the English language pack
  
### Removed
-	All language directories and files other than "de", "de_x_sie" and "en"
  
  
## [1.4.2] - 2022-02-22

### Added
  
### Changed
  
### Fixed
-	The length of the column `remind_type` in the MOT_USERREMINDER_REMIND_QUEUE table which was too short (15 chars) to take the remind_type `reminder_sleeper'
  
### Removed
  
  
## [1.4.1] - 2022-01-26

### Added
  
### Changed
-	Migration file `migrations/ur_v_0_1_0.php` from 'automatically' to 'manually' determine the module info in order to prevent error messages during a
	fresh install of this version due to missing the (now obsolete and no longer present) `xyz_info.php` files
-	Revoked the changes to `migrations/ur_v_1_3_3_0.php` and `migrations/ur_v_1_3_3_1.php` made in ver 1.4.0
-	Some code optimisation in `controller/ur_acp.php`
-	Replacement of long array declaration with short version in the a.m. changed files
  
### Fixed
-	Some grammatical and spelling errors in en language files and mail texts
-	A mis-named name attribute in `adm/style/acp_ur_sleeper.html` line 105 which prevented the array holding the sleepers selected for deletion from being
	filled properly
-	A problem with deleting this extension's data in `migrations/ur_v_1_4_0_0.php`
  
### Removed
  
  
## [1.4.0] - 2021-12-28

### Added
-	A cron task to limit the number of e-mails sent in case of many users to be reminded, all mails above the mail limit will be stored in DB table and
	subsequently sent by cron task
-	A setting in the settings tab to manage the maximum number of e-mails to be sent in specific time frame which can be set, too
-	An information panel with the time of the last cron task run and the number of avaialable e-mails
-	A general settings division in the settings tab to set the number of lines per page in the other tab's tables
-	A general option in the settings tab to display ´Remind all´ and ´Delete all´ buttons on the remind, sleepers and zero-posters tabs
-	New settings for reminding and deleting sleepers including the option to auto-remind and auto-delete them
-	Inactive links for the Reminder, Sleepers and Zeroposter tabs on the `Quick access` tab
-	Informations about the cron job's last run and the currently available number of e-mails
-	Generating the version number in the ACP tabs from the `composer.json` file
  
### Changed
-	ACP has been changed to a controller using service injection instead of modules using global variables
-	ACP module (controller function) and HTML file for sleepers have been renamed `sleeper` instead of `registrated_only`
-	DOM operations are now done using jQuery
-	All numeric values on the settings tab are now entered using number type input fields instead of text type input fields
-	Usage of short form to define arrays in all changed or newly created php files
-	E-mail address checking (input of BCC and CC addresses) no longer refuses capital letters
  
### Fixed
    
### Removed
-	Plural rules in language files
-	Config variable holding the version number
  
  
## [1.3.5] - 2021-04-06

### Added
-	A migration file to update version variable in `CONFIG_TABLE`

### Changed
-	The link to the users profile in the tables of the three "productive" ACP tabs is now computed by using phpBB's `append_sid` function using a relative path
	instead of using the config variables of the server to build an absolute path
	
### Fixed
-	Inserted a missing call to `sql_freeresult` in `acp/registrated_only_module.php` (new line 97), `acp/reminder_module.php` (new line 118), 
	`acp/zeroposter_module.php` (new line 133) and `event/main_listener.php` (new line 126)
-	Two typos in en language pack

### Removed
  
  
## [1.3.4] - 2021-03-01

### Added
-	A migration file to update version variable in `CONFIG_TABLE`

### Changed

### Fixed
-	A bug in `acp/zeroposter_module.php` and in `adm/style/acp_ur_zeroposter.html` which prevented users from being deleted in the `remind like inactive users`
	mode due to a mis-named select box

### Removed


## [1.3.3] - 2021-01-24

### Added
-	To the "productive" ACP tabs (Remind users, Sleepers and Zeroposters) the capability of being inserted into one other ACP tab by deleting the original
	modules and inserting new ones which differ in the `module_mode` from the respective `_info.php` file. In addition the new modules are inserted manually
	instead using the "automatic" method. This was necessary due to phpBB checking the `module_mode` during a call to the module against those already in
	the modules array (by ascending `parent_id` which means it will start with the "General" tab) and when encountering a `module_mode` a second time will
	not start the second module with an identical mode. Since a simple change in the `_info.php` files wasn't successful it was necessary to change the modules.
	Two new migration files (`ur_v_1_3_3_0.php` and `ur_v_1_3_3_1.php`) added for this purpose.
-	`README.md` file supplemented accordingly.
-	Userreminder now checks whether there are banned users and handles them as protected members to avoid reminding or deleting them. Affected files are
	`acp/registrated_only_module.php`, `acp/reminder_module.php`, `acp/zeroposter_module.php` and `event/main_listener.php`

### Changed
-	Replaced own construction to seperate user names of protected members by "\n" with `implode()` function in `acp/settings_module.php`
-	Using class constants for the number of seconds per day in `common.php`, `acp/registrated_only_module.php`, `acp/reminder_module.php`,
	`acp/zeroposter_module.php` and `event/main_listener.php`

### Fixed

### Removed


## [1.3.2] - 2020-11-19

### Added
-	A config variable with Userreminder's version number with a new migration file `migrations/ur_v_1_3_2.php`
-	A footer line with version and copyright information on each of the ACP tabs (via including a new file `adm/style/userreminder_version.html`),  
	affected files are `acp/registrated_only_module.php`, `acp/reminder_module.php`, `acp/settings_module.php`, `acp/zeroposter_module.php`,
	`adm/style/acp_ur_registratedonly.html`, `adm/style/acp_ur_reminder.html`, `adm/style/acp_ur_settings.html` and `adm/style/acp_ur_zeroposter.html`

### Changed
-	The usage of global variables in `acp/zeroposter_module.php` in order to make module useable in the extensions and the global tab simultaneously
	(so far without success)

### Fixed
-	A bug which selected sleepers, too, when reminding zeroposters automatically by adding another clause in the SQL query in `event/main_listener.php`, line 129
-	An error message when using a language Userreminder does not have a language pack for. Solved by checking for this language within Userreminder's language
	directory and falling back to the `en` language pack in `common.php`, new lines 219 - 226 and 319 - 338

### Removed
-	Two unused public variables from `acp/registrated_only_module.php`, `acp/reminder_module.php`, `acp/settings_module.php` and `acp/zeroposter_module.php`
  
  
## [1.3.1] - 2020-11-13

### Added

### Changed

### Fixed
-	A bug (using a wrong array for setting the time for `mot_reminded_one`) in `common.php`, line 184 resulting in overwriting the correct value for former
	reminders

### Removed
  
  
## [1.3.0] - 2020-10-30

### Added
-	A function to remind zeroposters including a new option on the settings page to enable/disable reminding zeroposters;
	affected files are `acp/settings_module.php`, `adm/style/acp_ur_settings.html`, `acp/zeroposter_module.php`, `adm/style/acp_ur_zeroposter.html`,
	`event/main_listener.php` (the latter for automatic reminding and deleting users) and all language files
-	Added a function in `event/main_listener.php` to check whether the user_id of a user to be deleted is part of the protected members config value
	and if yes, delete this user_id from the config value array
-	Added a new settings option to define groups which members will be excluded from being reminded and deleted, this group must be the default group
-	Migration file to insert the new above mentioned options into the config table and to convert the `protected_members` string into a json_encoded array
-	Added a check for protected groups affecting the `acp/registrated_only_module.php`, `acp/reminder_module.php`, `acp/zeroposter_module.php`
	and `event/main_listener.php` files

### Changed
-	Corrected the list of parameters while calling `$request->variable()` in `acp/settings_module.php`, lines 48, 49 and 51 (new lines 64, 65 and 67)
-	Inserted a backslash in `common.php` line 95 (new line 107) to adhere to phpBB coding guidelines
-	Adjusted SQL Queries in `common.php` lines 116, 144, 156 and 184 (new lines 128, 156, 168 and 196) to adhere to phpBB coding guidelines
-	Adjusted displaying usernames in all tables to the style commands used by phpBB (usernames are no longer in bold letters as a default).
	Affected files are `adm/style/acp_ur_registratedonly.html`, `adm/style/acp_ur_reminder.html` and `adm/style/acp_ur_zeroposter.html`
-	Changed the config value of `mot_ur_protected_members` from a comma seperated string into a JSON encoded array to enable conversion into a list of usernames
	for better readability in `acp/settings_module.php`. This change made it necessary to change all scripts where this config value is used, affected files are
	`common.php`, `acp/registrated_only_module.php`, `acp/reminder_module.php`, `acp/zeroposter_module.php` and `event/main_listener.php`
-	In the files `acp/registrated_only_module.php`, `acp/reminder_module.php`, `acp/settings_module.php` and `acp/zeroposter_module.php` the global variable
	`$language` was used. Since this global variable was introduced in phpBB 3.2.6 with Userreminder 1.2.1 an `ext.php` file was added to prevent installation
	on phpBB version 3.2.5 and earlier. In Userreminder 1.3.0 the variable `$language` is no longer acquired from the global variable but instead from the
	`phpbb_container` where it was introduced with phpBB 3.2.0. So the four ACP files are changed accordingly and the `ext.php` file checks now for
	phpBB versions later or equal to 3.2.0.
-	`README.md` file changed accordingly to reflect new functions and settings.

### Fixed
-	Corrected a typo in `common.php`, line 69 (`function_exists()` instead of `functions_exists()`)
-	Changed the definition of constant `SECS_PER_DAY` in `event/main_listener.php` to prevent warnings in PHP 7.4

### Removed
  
  
## [1.2.1] - 2020-08-21
**This version contains three fixes to iron out problems single users reported as well as changes necessary following the denied approval of ver. 1.2.0 to the phpBB extensions database**  

### Added
-	`README.md` file
-	`CHANGELOG.md` file
-	`ext.php` file to check for phpBB version >= 3.2.6 to prevent enabling on boards with phpBB versions prior to this due to usage of global `$language`
-	Dutch (nl) language pack (courtesy of JJGV at www.phpbb.com)
-	Added JJGV as co-author in `composer.json`

### Changed
-	Changed the use of `sizeof()` to `count()` in all php files
-	Changed the content of all language files to read that "There is also a possibility to add one email address each for a bcc and/or cc copy of the reminding mails."
	instead of "There is also a possibility to add one email address each for a bcc or cc copy of the reminding mails."
-	Deleted a superfluous variable definition `$start = 0;` which was repeated later in the code in ACP module files `registrated_only_module.php`,
	`reminder_module.php` and `zeroposter_module.php`
-	Replaced `WHERE (user_type = ' . USER_NORMAL . ' OR user_type = ' . USER_FOUNDER . ')` with `WHERE ' . $db->sql_in_set('user_type', array(USER_NORMAL,USER_FOUNDER))`
	in SQL queries in ACP module files `registrated_only_module.php`, `reminder_module.php`, `zeroposter_module.php` and in event listener file`main_listener.php`
-	Replaced the use of php comparison operator `<>` with `!=` in all php files to adhere to phpBB coding guidelines
-	Replaced `'AND user_id NOT IN (' . $config['mot_ur_protected_members'] . ') ';` with `'AND ' . $db->sql_in_set('user_id', explode(',', $config['mot_ur_protected_members']), true);`
	in SQL queries in ACP module files `registrated_only_module.php`, `reminder_module.php`, `zeroposter_module.php` and in event listener file`main_listener.php`
-	Included extension namespace for use with `INCLUDEJS` and `INCLUDECSS` in `adm/style/acp_ur_settings.html`
-	Removed `enctype="application/x-www-form-urlencoded"` from textarea definition in `adm/style/acp_ur_zeroposter.html` and added it to form definition
-	Changed variable `$this->secs_per_day` to constant `const SECS_PER_DAY = 86400;` in `event/main_listener.php`
-	Changed the use of double quotes inside the language strings to `´` in all language files
-	Changed the query in migration file `ur_v_0_5_0.php` setting the initial value of `USERS_TABLE` column `mot_last_login` to prevent possible time out on boards with many users
-	Restructured `common.php` to get rid of duplicate code for sending e-mails

### Fixed
-	Inserted a check if the user's time zone is set and if not 'UTC' is used as default in `common.php`
-	Inserted a reset for the messenger for each user who is to get a reminder mail to fix an issue one user experienced (Every email was sent to all prior users
	who have received an email during that run). Subject file is `common.php`
-	Fixed the missing `script_path` variable when building the `$this->forgot_pass` variable in `common.php`'s constructor (an issue only if phpBB is
	installed in a subdirectory of the webspace, e.g. `www.my-webspace.net/phpBB`, experienced by one user)
-	Adjusted minimum phpBB requirement in `composer.json` to 3.2.6 due to use of global `$language`
-	Exchanged the use of super global `isset($_POST['delmarked'])` with `$request->is_set_post('delmarked')` in ACP files `registrated_only_module.php`,
	`reminder_module.php` and `zeroposter_module.php`
-	Changed all requested numeric variables in `acp/settings_module.php` to number as default in `$request->variable()` method
-	The link to the memberlist is constructed within the php file using the `$phpEx` variable and handed over to the html file as a variable instead of being
	hard coded within the html file (`acp/registrated_only_module.php`, `acp/reminder_module.php`, `acp/zeroposter_module.php` and
	`adm/style/acp_ur_registratedonly.html`, `adm/style/acp_ur_reminder.html`, `adm/style/acp_ur_zeroposter.html` respectively
-	Corrected type annotation in `event/main_listener.php`
-	Fixed wrong text encoding (ANSI instead of UTF-8) in file `migrations/ur_v_0_1_0.php`
-	Corrected type annotation in `common.php`
-	Fixed usage of `$messenger->bcc()` for cc email address to `$messenger->cc()` in `common.php`

### Removed
-	Text file `version_history.txt`


## [1.2.0] - 2020-06-29
**This version contains all changes necessary following the denied submission to phpBB extension database, re-submitted on 2020-06-29**
### Added
-	Since `$messenger->template()` does only work with text files `common.php` now checks whether the mail text to send is from a file or from the data base.
	In the latter case a new set of code is used to do all the things necessary to set addresses, replace variables (tokens) in the text and discern
	what method to use (new lines 133 - 173 and 251 - 291)

### Changed
-	Switched all ACP templates to TWIG syntax
-	js and css files are only included in `settings_module.html` now, no longer through `adm/style/event/*` everywhere
-	It is now possible to save the e-mail text without doing the preview before
-	Edited e-mail texts are no longer saved in the text file but in a config_text variable
-	Since edited files are now stored in the `config_text` table it is no longer necessary to purge the cache, language packs adjusted accordingly
-	Optimized the code counting the number of different users in order to set variables for pagination
-	Some minor code changes to iron out small irregularities (w/o impact on the functionality)
-	Enhanced security by checking requested variables from user input in `settings_module.php`

### Fixed
-	Corrected a broken character in the en language file

### Removed
-	The directory `adm/style/event` and all its files have been removed from the extension


## [1.1.0] - 2020-05-10
**This version has not been published!!**

### Added

### Changed
-	Rebuilt js and css by transferring js code into `admin_mot_userreminder.js`, css definitions into `admin_mot_userreminder.css` and include both
	in `acp_overall_footer_after.html` and `acp_overall_header_stylesheets_after.html` respectively

### Fixed
-	Corrected some warnings due to unused and undefined variables in `registrated_only_module.php`, `reminder_module.php`, `zeroposter_module.php` and
	`settings_module.php`

### Removed
  
  
## [1.0.1] - 2020-04-12

### Added
-	Added Spanish language file and email texts (courtesy of Jorge (Jorup16 at www.phpbb.com))

### Changed

### Fixed

### Removed


## [1.0.0] - 2020-02-26
-	Stable version for submission; version had to be updated due to restrictions at submission

### Added

### Changed

### Fixed

### Removed


## [0.5.1] - 2020-02-25

### Added

### Changed
-	Some improvements in the fr language files

### Fixed

### Removed


## [0.5.0] - 2020-02-23

### Added
-	New migration file `ur_v_0_5_0.php` with a custom function to set the initial values for column `mot_last_login` from
	column `user_lastvisit` in users table. This replaces the function `init_ur` in the file `main_listener.php` to make certain
	that the admin doesn't have to wait to the next login to see the tabs in the ACP filled properly
-	Added French language file and email texts (courtesy of Claude (stone23 at www.phpbb.com))
-	Added a function in `common.php` to format date/time according to the addressed user's preferences and language in emails

### Changed
-	Replaced `<br />` with `<br>` in all language files
-	Corrected one typo (line 48) and one forgotten translation (line 56) in the en language file
-	Optimized the sql queries in `common.php`
-	Optimized the sql queries (only normal users and founders are checked; no bots, guests, deactivated or inactive users) in the files:
	`registrated_only_module.php`, `reminder_module.php`, `zeroposter_info.php`, `main_listener.php`
-	Replaced the date formatting `date('d.m.Y', "date")` with `$user->format_date('date')` to present it in the current users notation in
	the files: `registrated_only_module.php`, `reminder_module.php`, `settings_module.php`, `zeroposter_info.php`
-	Put the "Delete users automatically" radio buttons under the selection for the number of days since last reminder until deletion in
	`acp_ur_settings.html`

### Fixed
-	Corrected two incorrect date/time formattings with the email preview in `settings_module.php`

### Removed


## [0.4.0] - 2020-02-02

### Added

### Changed
-	Renamed the extension into `userreminder` (instead of `user_reminder`; no underscores allowed in ext names)
-	Set the name space according to the changed name in all files

### Fixed
-	Corrected some errors in Line Feed format of (mainly) ACP php files and in `common.php`

### Removed


## [0.3.0] - 2020-01-03

### Added
-	Added a setting to edit the text of the reminding mails
-	Added a column in the remind users section with the number of posts

### Changed

### Fixed
-	Fixed a problem with the date format while automatic reminder mails are enabled in `common.php`, lines 127 and 184

### Removed


## [0.2.0] - 2019-12-19

### Added
-	Added a setting to save an email address for bcc and/or cc reminding mails

### Changed

### Fixed

### Removed


## [0.1.0] - 2019-11-20
-	First working version
