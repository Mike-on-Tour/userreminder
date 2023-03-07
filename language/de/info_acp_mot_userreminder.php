<?php
/**
*
* @package UserReminder v1.7.0
* @copyright (c) 2019 - 2023 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » „ “ — …
//

$lang = array_merge($lang, [
	// language pack author
	'ACP_USERREMINDER_LANG_DESC'				=> 'Deutsch (Du)',
	'ACP_USERREMINDER_LANG_EXT_VER' 			=> '1.7.0',
	'ACP_USERREMINDER_LANG_AUTHOR' 				=> 'Mike-on-Tour',

	// Module
	'CONFIRM_USER_DELETE'						=> [
		1	=> 'Bist du dir sicher, dass du 1 Mitglied löschen möchtest?<br><br>Damit werden Mitglieder endgültig aus der Datenbank entfernt, <strong>dieser Vorgang kann nicht rückgängig gemacht werden!</strong>',
		2	=> 'Bist du dir sicher, dass du %d Mitglieder löschen möchtest?<br><br>Damit werden Mitglieder endgültig aus der Datenbank entfernt, <strong>dieser Vorgang kann nicht rückgängig gemacht werden!</strong>',
	],
	'NO_USER_SELECTED'							=> 'Es wurde kein Mitglied für diese Aktion markiert. Bitte mindestens ein Mitglied markieren.',
	'USER_DELETED'								=> [
		1	=> '1 Mitglied erfolgreich gelöscht',
		2	=> '%d Mitglieder erfolgreich gelöscht',
	],
	'USER_REMINDED'								=> [
		1	=> '1 Mitglied per eMail erinnert',
		2	=> '%d Mitglieder per eMail erinnert',
	],
	'USER_POSTS'								=> 'Beiträge',
	'DAYS_AGO'									=> 'vor Anzahl Tagen',
	'AT_DATE'									=> 'Am',
	'MARK_REMIND'								=> 'Erinnern',
	'MARK_DELETE'								=> 'Löschen',
	'REMIND_MARKED'								=> 'Markierte erinnern',
	'REMIND_ALL'								=> 'Alle erinnern',
	'ACP_USERREMINDER_REMIND_ALL_TEXT'			=> 'Erinnert alle zur Erinnerung heranstehenden Mitglieder in dieser Tabelle.',
	'ACP_USERREMINDER_DELETE_ALL_TEXT'			=> '<span style="color:red">Löscht <b>ALLE</b> in dieser Tabelle gelisteten Mitglieder!</span>',
	'LOG_INACTIVE_REMIND_ONE'					=> '<strong>Erste Erinnerungs-E-Mail an inaktive Benutzer verschickt</strong><br>» %s',
	'LOG_INACTIVE_REMIND_TWO'					=> '<strong>Zweite Erinnerungs-E-Mail an inaktive Benutzer verschickt</strong><br>» %s',
	'LOG_SLEEPER_REMIND'						=> '<strong>Erinnerungs-E-Mail an Schläfer verschickt</strong><br>» %s',
	//ACP Settings
	'ACP_USERREMINDER'							=> 'User Reminder',
	'ACP_USERREMINDER_SETTINGS'					=> 'Einstellungen',
	'ACP_USERREMINDER_SETTINGS_EXPLAIN'			=> 'Hier kannst du die Einstellungen für den User Reminder ändern.',
	'ACP_USERREMINDER_SETTING_SAVED'			=> 'Die Einstellungen für den User Reminder wurden erfolgreich gesichert.',
	'ACP_USERREMINDER_GENERAL_SETTINGS'			=> 'Allgemeine Einstellungen',
	'ACP_USERREMINDER_ROWS_PER_PAGE'			=> 'Zeilen pro Tabellenseite',
	'ACP_USERREMINDER_ROWS_PER_PAGE_TEXT'		=> 'Wähle hier die Anzahl der Zeilen, die pro Tabellenseite in den anderen Reitern angezeigt
													werden soll.',
	'ACP_USERREMINDER_EXPERT_MODE'				=> 'Experten-Modus für die Seiten mit zu erinnernden Mitgliedern, Null-Postern und Schläfern',
	'ACP_USERREMINDER_EXPERT_MODE_TEXT'			=> 'Wenn du hier ´Ja´ wählst, werden unterhalb der Tabellen mit den zu erinnernden Mitgliedern,
													Null-Postern und Schläfern zwei zusätzliche Buttons angezeigt, mit denen ALLE in der
													jeweiligen Tabelle aufgelisteten Mitglieder erinnert bzw. gelöscht werden können.<br>
													<span style="color:red">Weil insbesondere mit dem ´Alle löschen´-Button großer Schaden
													angerichtet werden kann, wird die Nutzung dieser Option nur für Administratoren empfohlen,
													die sich des damit einhergehenden Risikos bewusst sind!<br>
													Lies bitte den entsprechenden Abschnitt in der Datei ´README.md´ bevor du diese
													Einstellung verwendest.</span>',
	'ACP_USERREMINDER_TIME_SETTINGS_TITLE'		=> 'Konfiguration der Erinnerungsintervalle',
	'ACP_USERREMINDER_TIME_SETTING_TEXT'		=> 'Einstellungen für die Zeitdauer, bis ein Mitglied als inaktiv gilt, Dauer zwischen der
													ersten und zweiten Erinnerung sowie die darauf folgende Dauer bis zur Löschung. Außerdem
													kann hier ausgewählt werden, ob Erinnerungs-Mails automatisch verschickt und Löschungen
													automatisch erfolgen sollen.',
	'ACP_USERREMINDER_INACTIVE'					=> 'Anzahl der Tage, die ein Mitglied offline sein muss, um als inaktiv zu gelten',
	'ACP_USERREMINDER_DAYS_REMINDED'			=> 'Anzahl der Tage, bis ein als inaktiv eingestuftes Mitglied die zweite Erinnerungs-Mail bekommen soll;<br>
													die Eingabe von ´0´ schaltet die zweite Erinnerungs-Mail ab',
	'ACP_USERREMINDER_AUTOREMIND'				=> 'Erinnerungs-Mails automatisch versenden?',
	'ACP_USERREMINDER_DAYS_UNTIL_DELETED'		=> 'Anzahl der Tage zwischen letzter Erinnerung und Löschen des Mitgliedes',
	'ACP_USERREMINDER_AUTODELETE'				=> 'Mitglieder nach Ablauf aller Wartezeiten automatisch löschen?',
	// ACP Sleeper settings
	'ACP_USERREMINDER_SLEEPER_CONFIG'			=> 'Konfiguration für Schläfer',
	'ACP_USERREMINDER_SLEEPER_CONFIG_TEXT'		=> 'Hier kannst du einstellen, ob Schläfer erinnert werden sollen und nach Ablauf von wieviel
													Tagen dies geschehen soll und ob sie automatisch nach einer bestimmten Anzahl von Tagen
													gelöscht werden sollen.',
	'ACP_USERREMINDER_REMIND_SLEEPER'			=> 'Sollen Schläfer erinnert werden?',
	'ACP_USERREMINDER_REMIND_SLEEPER_TEXT'		=> 'Wenn Schläfer daran erinnert werden sollen, das Forum nach Registrierung zu besuchen, wähle
													hier ´Ja´, dann werden dir weitere Optionen angezeigt.',
	'ACP_USERREMINDER_SLEEPER_INACTIVE'			=> 'Anzahl der Tage seit Registrierung bis zur Erinnerung',
	'ACP_USERREMINDER_AUTODELETE_SLEEPER'		=> 'Sollen Schläfer automatisch gelöscht werden?',
	'ACP_USERREMINDER_AUTODELETE_SLEEPER_TEXT'	=> 'Wenn du hier ´Ja´ auswählst, werden Schläfer automatisch gelöscht.<br>
													Bei Auswahl von ´Ja´ erscheint eine weitere Einstellung, in der du die Anzahl der Tage
													angeben kannst, nach deren Ablauf gelöscht wird. Abhängig davon ob du Schläfer erinnern
													möchtest, zählen diese Tage entweder ab der Erinnerung bzw. ab der Registrierung.',
	'ACP_USERREMINDER_SLEEPER_DELETETIME'		=> 'Anzahl Tage bis zum Löschen',
	// ACP Zeroposter settings
	'ACP_USERREMINDER_ZEROPOSTER_CONFIG'		=> 'Konfiguration für Null-Poster',
	'ACP_USERREMINDER_ZEROPOSTER_CONFIG_TEXT'	=> 'Hier kannst du wählen, ob Null-Poster wie originäre inaktive Benutzer behandelt werden sollen. Wenn du diese Einstellung aktivierst, kannst du auch für Null-Poster die Erinnerungs- und Löschintervalle auswählen (unabhängig von den Zeiten für inaktive Mitglieder) und sie werden statt in einer vereinfachten Tabelle in einer mit den Daten für die erste und zweite Erinnerung sowie für die Löschung dargestellt.',
	'ACP_USERREMINDER_REMIND_ZEROPOSTER'		=> 'Sollen Null-Poster wie inaktive Benutzer erinnert und gelöscht werden?',
	'ACP_USERREMINDER_ZP_INACTIVE'				=> 'Anzahl der Tage, die ein Null-Poster offline sein muss, um als inaktiv zu gelten',
	'ACP_USERREMINDER_ZP_DAYS_REMINDED'			=> 'Anzahl der Tage, bis ein als inaktiv eingestufter Null-Poster die zweite Erinnerungs-Mail bekommen soll;<br>
													die Eingabe von ´0´ schaltet die zweite Erinnerungs-Mail ab',
	'ACP_USERREMINDER_ZP_AUTOREMIND'			=> 'Erinnerungs-Mails automatisch versenden?',
	'ACP_USERREMINDER_ZP_DAYS_UNTIL_DELETED'	=> 'Anzahl der Tage zwischen letzter Erinnerung und Löschen des Null-Posters',
	'ACP_USERREMINDER_ZP_AUTODELETE'			=> 'Null-Poster nach Ablauf aller Wartezeiten automatisch löschen?',
	// ACP Protection settings
	'ACP_USERREMINDER_PROTECTION_CONFIG'		=> 'Konfiguration für geschützte Mitglieder',
	'ACP_USERREMINDER_PROTECTION_CONFIG_TEXT'	=> 'Hier kannst du Mitglieder auswählen, die vor Erinnerungen und Löschung geschützt werden sollen. Die Auswahl erfolgt für einzelne Mitglieder über den Benutzernamen und/oder für alle Mitglieder von auszuwählenden Hauptgruppen. Beide Möglichkeiten sind unabhängig voneinander.',
	'ACP_USERREMINDER_PROTECTED_MEMBERS'		=> 'Eingabe der Benutzernamen von Mitgliedern, die von Erinnerungen und Löschung ausgenommen werden sollen.<br>Nur ein Name pro Zeile!',
	'ACP_USERREMINDER_PROTECTED_GROUPS'			=> 'Auswahl von Hauptgruppe(n), deren Mitglieder von Erinnerungen und Löschung ausgenommen werden sollen. Bereits ausgewählte Gruppen sind hervorgehoben.<br>Unter Drücken und Halten der ´Strg´-Taste und Mausklick können mehrere Gruppen ausgewählt werden',
	// ACP Mail settings
	'ACP_USERREMINDER_MAIL_SETTINGS_TITLE'		=> 'Konfiguration der E-Mails',
	'ACP_USERREMINDER_MAIL_LIMITS_TEXT'			=> 'Hier kannst du die von deinem Provider festgelegten Grenzen für den Versand von E-Mails eingeben; diese Werte
													sind wichtig, damit beim Versand von mehreren Erinnerungs-Mails keine verloren gehen.<br>
													Die voreingestellten Werte bedeuten, dass innerhalb einer Stunde (3600 Sekunden) maximal 150 E-Mails
													versendet werden dürfen. <strong>Trage hier bitte die für deinen Provider gültigen Daten ein!</strong>',
	'ACP_USERREMINDER_MAIL_LIMIT_NUMBER'		=> 'Maximale Anzahl von E-Mails',
	'ACP_USERREMINDER_MAIL_LIMIT_TIME'			=> 'Zeitrahmen, in dem diese Anzahl versandt werden kann',
	'ACP_USERREMINDER_MAIL_LIMIT_SECONDS'		=> 'Sekunden',
	'ACP_USERREMINDER_CRON_EXP'					=> 'Hier findest du zu deiner Information Angaben darüber, wann die Cron-Aufgabe zum Versenden von E-Mails
													zuletzt gestartet wurde, wieviele E-Mails aktuell noch versendet werden können, ohne in die Warteschlange
													aufgenommen zu werden und wieviele E-Mails sich in der Warteschlange befinden.',
	'ACP_USERREMINDER_LAST_CRON_RUN'			=> 'Letzter Cron-Lauf',
	'ACP_USERREMINDER_AVAILABLE_MAIL_CHUNK'		=> 'Aktuell verfügbare Anzahl an E-Mails',
	'ACP_USERREMINDER_MAILS_WAITING'			=> 'Anzahl der aktuell in der Warteschlange befindlichen E-Mails',
	'ACP_USERREMINDER_EMAIL_BCC_TEXT'			=> 'Hier kannst du jeweils eine E-Mail-Adresse angeben, die in Blindkopie und/oder in Kopie an den Erinnerungs-Mails beteiligt wird.',
	'ACP_USERREMINDER_EMAIL_BCC'				=> 'Blindkopie der Erinnerungs-Mail an',
	'ACP_USERREMINDER_EMAIL_CC'					=> 'Kopie der Erinnerungs-Mail an',
	'ACP_USERREMINDER_EMAIL_FROM'				=> 'Absender-Adresse für Erinnerungs-Mails',
	'ACP_USERREMINDER_EMAIL_FROM_TEXT'			=> 'Hier kannst du eine E-Mail-Adresse angeben, die als Absender-Adresse in den E-Mails des User Reminder verwendet wird. Wenn du hier keine Eintragung vornimmst, wird die „Absender-E-Mail-Adresse“ aus den Einstellungen „Board-E-Mails“ verwendet.',
	'ACP_USERREMINDER_SUPPRESS_REPLYTO'			=> 'Unterdrücke die Angabe einer Reply-To Adresse in den Erinnerungs-Mails',
	'ACP_USERREMINDER_SUPPRESS_REPLYTO_TEXT'	=> 'Wenn du die Angabe einer Reply-To Adresse in den Erinnerungs-Mails unterdrücken möchtest, z.B. weil du als Absender eine
													Noreply-Adresse angegeben hast, kannst du dies hier tun. Nach Aktivierung werden die Angaben zur Reply-To Adresse aus dem
													Kopf der E-Mail gelöscht.',
	// ACP Mail text edit
	'ACP_USERREMINDER_MAIL_EDIT_TITLE'			=> 'Bearbeiten der E-Mail Texte',
	'ACP_USERREMINDER_MAIL_EDIT_TEXT'			=> 'Bearbeitung des voreingestellten Textes für die erste und zweite Erinnerungs-Mail.',
	'ACP_USERREMINDER_MAIL_LANG'				=> 'Sprache auswählen',
	'ACP_USERREMINDER_MAIL_FILE'				=> 'Zu bearbeitende Datei wählen',
	'ACP_USERREMINDER_MAIL_ONE'					=> '1. Erinnerung',
	'ACP_USERREMINDER_MAIL_TWO'					=> '2. Erinnerung',
	'ACP_USERREMINDER_MAIL_SLEEPER'				=> 'Erinnerung Schläfer',
	'ACP_USERREMINDER_MAIL_PREVIEW'				=> 'Im Fenster rechts kann der Text der ausgewählten E-Mail bearbeitet werden. Durch Anklicken des ´Vorschau´-Buttons wird der Text dargestellt,
													wie er später in der E-Mail versandt wird, die Tokens werden dabei durch deine Daten ersetzt. Zusätzlich wird mit der Vorschau auch ein Button
													zum Speichern des Textes auf dem Server dargestellt.<br>
													Im Text können folgende Tokens verwendet werden, die als Platzhalter für die entsprechenden Daten des angeschriebenen Mitgliedes stehen:<br>
													- {USERNAME}: Nickname des Mitgliedes<br>
													- {LAST_VISIT}: Datum des letzten Einloggens<br>
													- {LAST_REMIND}: Datum der ersten Erinnerungs-Mail<br>
													- {REG_DATE}: Datum der Registrierung<br>
													Die folgenden Tokens können als Platzhalter für systembezogene Daten verwendet werden:<br>
													- {SITENAME}: Name des Forums<br>
													- {FORGOT_PASS}: Link zu ´Ich habe mein Passwort vergessen´<br>
													- {ADMIN_MAIL}: Email-Adresse des Foren-Admins<br>
													- {EMAIL_SIG}: Absender-Grußformel<br>
													- {DAYS_INACTIVE}: Oben angegebene Anzahl Tage der Inaktivität<br>
													- {DAYS_TIL_DELETE}: Oben angegebene Anzahl an Tagen bis zur Löschung<br>
													- {DAYS_DEL_SLEEPERS}: Oben angegebene Anzahl an Tagen bis zur Löschung von Schläfern<br>',
	'ACP_USERREMINDER_MAIL_LOAD_FILE'			=> 'Datei laden',
	'ACP_USERREMINDER_PREVIEW_TEXT'				=> 'Bitte beachten:<br>Im Vorschautext werden die Tokens für die Daten des angeschriebenen Mitgliedes mit deinen Daten ersetzt, dies muss nicht unbedingt einen logisch sinnvollen Text ergeben.',
	'ACP_USERREMINDER_MAIL_SAVE_FILE'			=> 'Datei speichern',
	'ACP_USERREMINDER_FILE_NOT_FOUND'			=> 'Datei ´%s´ konnte nicht geladen werden.',
	'ACP_USERREMINDER_FILE_ERROR'				=> 'Beim Speichern der Datei ´%s´ trat ein Fehler auf!<br>Die Datei wurde <strong>nicht gespeichert</strong>.',
	'ACP_USERREMINDER_FILE_SAVED'				=> 'Die Datei ´%s´ wurde erfolgreich gespeichert.',
	'ACP_USERREMINDER_SEND_TESTMAIL'			=> 'E-Mail-Text als Testmail an diese E-Mail-Adresse senden',
	'ACP_USERREMINDER_SEND_TESTMAIL_EXPL'		=> 'Nutze die vorausgewählte E-Mail-Adresse bzw. gib eine andere Adresse ein, zu der der oben ausgewählte E-Mail-Text als Test-Mail versandt werden soll.<br>
													ACHTUNG: Falls du den Text geändert hast, speichere ihn vor dem Senden erst ab, ansonsten wird der unveränderte Text verwendet!',
	'ACP_USERREMINDER_ENTER_EMAIL_ADDRESS'		=> 'Eingabe einer gültigen E-Mail-Adresse',
	'ACP_USERREMINDER_SENDMAIL'					=> 'Mail senden',
	'ACP_USERREMINDER_TESTMAIL_SENT'			=> 'Test-Mail wurde gesendet; bitte prüfe den angegebenen E-Mail-Briefkasten auf den Eingang dieser E-Mail.',
	// ACP Reminder
	'ACP_USERREMINDER_REMINDER'					=> 'Mitglieder erinnern',
	'ACP_USERREMINDER_REMINDER_EXPLAIN'			=> 'Hier werden die Mitglieder aufgelistet, die nach Registrierung und Aktivierung bereits online waren und Beiträge gepostet haben, aber seit der in den Einstellungen vorgegebenen Anzahl von Tagen nicht mehr online waren.
													Diese Mitglieder können hier manuell zur Erinnerung ausgewählt bzw. nach Verstreichen der beiden eingestellten Zeiträume nach den Erinnerungen gelöscht werden.
													Erst wenn ein Mitglied beide Erinnerungen hat verstreichen lassen, ohne sich einzuloggen, wird es zur Löschung freigegeben.',
	'ACP_USERREMINDER_REMINDER_ONE'				=> 'Erste Erinnerung',
	'ACP_USERREMINDER_REMINDER_TWO'				=> 'Zweite Erinnerung',
	'ACP_USERREMINDER_NO_ENTRIES'				=> 'Keine Daten gefunden',
	'ACP_USERREMINDER_SORT_DESC'				=> 'Absteigend',
	'ACP_USERREMINDER_SORT_ASC'					=> 'Aufsteigend',
	'ACP_USERREMINDER_KEY_RD'					=> 'Registrierungsdatum',
	'ACP_USERREMINDER_KEY_LV'					=> 'Letzter Besuch',
	'ACP_USERREMINDER_KEY_RO'					=> '1. Erinnerung',
	'ACP_USERREMINDER_KEY_RT'					=> '2. Erinnerung',
	// ACP Sleeper
	'ACP_USERREMINDER_SLEEPER'					=> 'Schläfer',
	'ACP_USERREMINDER_SLEEPER_EXPLAIN'			=> 'Hier werden die Mitglieder aufgelistet, die nach Registrierung und Aktivierung noch nie online waren.',
	'ACP_USERREMINDER_REMINDER'					=> 'Erinnerung',
	'ACP_USERREMINDER_KEY_RE'					=> 'Erinnerungsdatum',
	// ACP Zeroposters
	'ACP_USERREMINDER_ZEROPOSTER'				=> 'Null-Poster',
	'ACP_USERREMINDER_ZEROPOSTER_EXPLAIN'		=> 'Hier werden die Mitglieder aufgelistet, die zwar regelmäßig online sind, aber bisher noch keine Beiträge gepostet haben.',
	// Support and Copyright
	'ACP_USERREMINDER_SUPPORT'					=> 'Wenn du die Entwicklung der Erweiterung ´User Reminder´ unterstützen möchtest, kannst du das hier tun',
	'ACP_USERREMINDER_VERSION'					=> '<img src="https://img.shields.io/badge/Version-%1$s-green.svg?style=plastic" /><br>&copy; 2019 - %2$d by Mike-on-Tour',
]);
