# Change Log
All changes to `Userreminder for phpBB` will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).
  
## [1.2.1] - 2020-08-21
**This version contains three fixes to iron out problems single users reported as well as changes necessary following the denied submission of ver. 1.2.0 to the phpBB extensions database**  

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
