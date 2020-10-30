<?php
/**
*
* @package UserReminder v1.3.0
* @copyright (c) 2019, 2020 Mike-on-Tour
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
	$lang = array();
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

$lang = array_merge($lang, array(
	'PLURAL_RULE'		=> 1,
	// Module
	'CONFIRM_USER_DELETE'						=> array(
		1	=> 'Weet je zeker dat je 1 gebruiker wilt verwijderen??<br><br><strong>Deze actie verwijderd de gebruiker permanent uit de database en kan niet worden teruggedraaid!</strong>',
		2	=> 'Weet je zeker dat je %d gebruikers wilt verwijderen??<br><br><strong>Deze actie verwijderd de gebruikers permanent uit de database en kan niet worden teruggedraaid!</strong>',
	),
	'NO_USER_SELECTED'							=> 'Je hebt geen enkele gebruiker geselecteerd voor deze actie, markeer tenminste 1 gebruiker.',
	'USER_DELETED'								=> array(
		1	=> '1 gebruiker succesvol verwijderd',
		2	=> '%d gebruikers succesvol verwijderd',
	),
	'USER_REMINDED'								=> array(
		1	=> 'Herinnering email verstuurd naar 1 gebruiker',
		2	=> 'Herinnering email verstuurd naar %d gebruikers',
	),
	'USER_POSTS'								=> 'Berichten',
	'DAYS_AGO'									=> 'Aantal dagen geleden',
	'AT_DATE'									=> 'Op',
	'MARK_REMIND'								=> 'Herinner',
	'MARK_DELETE'								=> 'Verwijder',
	'REMIND_MARKED'								=> 'Herinner gemarkeerden',
	'LOG_INACTIVE_REMIND_ONE'					=> '<strong>Eerste herinnering naar inactieve gebruikers gestuurd</strong><br>» %s',
	'LOG_INACTIVE_REMIND_TWO'					=> '<strong>Tweede herinnering naar inactieve gebruikers gestuurd</strong><br>» %s',
	//ACP
	'ACP_USERREMINDER'							=> 'User reminder',
	'ACP_USERREMINDER_SETTINGS'					=> 'Instelling User Reminder',
	'ACP_USERREMINDER_SETTINGS_EXPLAIN'			=> 'Hier pas je de instellingen aan voor User Reminder.',
	'ACP_USERREMINDER_SETTING_SAVED'			=> 'Instellingen User Reminder succesvol opgeslagen.',
	'ACP_USERREMINDER_TIME_SETTINGS_TITLE'		=> 'Stel de herinnerings intervallen in',
	'ACP_USERREMINDER_TIME_SETTING_TEXT'		=> 'Stel het aantal dagen in waarna een gebruiker als inactief gezien word, het aantal dagen tussen het eerste ne tweede herinneringsmailtje om de gebruiker te herinneren dat inloggen noodzakelijk is, en de periode totdat de gebruiker verwijderd word.',
	'ACP_USERREMINDER_INACTIVE'					=> 'Aantal dagen dat een gebruiker offline is voordat deze al inactief gezien word',
	'ACP_USERREMINDER_DAYS_REMINDED'			=> 'Aantal dagen voordat een gebruiker als inactief  gezien word en een tweede herinnering verstuurd word;<br>
													tweede mail versturen word uitgeschakeld als je ´0´ invult',
	'ACP_USERREMINDER_AUTOREMIND'				=> 'Verstuur herinneringen automatisch?',
	'ACP_USERREMINDER_DAYS_UNTIL_DELETED'		=> 'Aantal dagen na laatste herinnering voordat een gebruiker verwijderd kan worden',
	'ACP_USERREMINDER_AUTODELETE'				=> 'Verwijder gebruiker automatisch?',
	// ACP Zeroposter settings
	'ACP_USERREMINDER_ZEROPOSTER_CONFIG'		=> 'Zeroposter configuratie',
	'ACP_USERREMINDER_ZEROPOSTER_CONFIG_TEXT'	=> 'Stel hier in of een zeroposter behandeld moet worden als een inactieve gebruiker. Als je voor ´Ja´ kiest, dan zullen de instellingen van de vorige sectie ook gelden voor zeroposters. In dat geval zullen de zeroposters weergegeven worden in een uitgebreide tabel waar de datums te zien zijn waarop de eerste en tweede herinnering te zien zijn en een selectievakje om de gebruiker te verwijderen.',
	'ACP_USERREMINDER_REMIND_ZEROPOSTER'		=> 'Wil je zeroposters herinneren en kunnen verwijderen zoals inactieve gebruikers?',
	// ACP Protection settings
	'ACP_USERREMINDER_PROTECTION_CONFIG'		=> 'Beveiligde gebruikers configuratie',
	'ACP_USERREMINDER_PROTECTION_CONFIG_TEXT'	=> 'Je kunt ook gebruikers opgeven die uitgesloten worden van herinnerings mailtjes en verwijdering. Je kunt individuele gebruikers opgeven en/of alle leden van een standaard groep door deze groep te selecteren. Beide selecties werken onafhankelijk van elkaar.',
	'ACP_USERREMINDER_PROTECTED_MEMBERS'		=> 'Geef de gebruikersnamen op van de gebruikers die je wilt uitsluiten van herinneringsmailtjes en verwijdering.<br>Elke gebruikersnaam MOET op een aparte regel!',
	'ACP_USERREMINDER_PROTECTED_GROUPS'			=> 'Selecteer de standaard groep(en) waarvan de leden uitgesloten worden tegen herinneringsmailtjes en verwijdering. Reeds geselecteerde groepen zijn highlighted.<br>Door het indrukken van de ´Ctrl´ toets en de betreffende groepen aanklikken kun je meer dan een groep selecteren',
	// ACP Mail settings
	'ACP_USERREMINDER_MAIL_SETTINGS_TITLE'		=> 'Email instellingen',
	'ACP_USERREMINDER_EMAIL_BCC_TEXT'			=> 'Stel hier 1 emailadres waar een blind carbon copy en/of een carbon copy van de herinnerings email naartoe gestuurd word.',
	'ACP_USERREMINDER_EMAIL_BCC'				=> 'Stuur een blind carbon copy naar',
	'ACP_USERREMINDER_EMAIL_CC'					=> 'Stuur een carbon copy naar',
	// ACP Mail text edit
	'ACP_USERREMINDER_MAIL_EDIT_TITLE'			=> 'Pas de email teksten aan',
	'ACP_USERREMINDER_MAIL_EDIT_TEXT'			=> 'Pas hier de standaardtekst aan van de eerste en tweede herinnering email.',
	'ACP_USERREMINDER_MAIL_LANG'				=> 'Kies taal',
	'ACP_USERREMINDER_MAIL_FILE'				=> 'Kies het aan te passen bestand',
	'ACP_USERREMINDER_MAIL_ONE'					=> 'Eerste herinnering',
	'ACP_USERREMINDER_MAIL_TWO'					=> 'Tweede herinnering',
	'ACP_USERREMINDER_MAIL_PREVIEW'				=> 'In het rechtervenster kun je de tekst aanpassen van de gekozen email. Door op de ´Voorbeeld´ knop te klikken zie je de tekst zoals
													deze te zien is in de email. De tokens worden vervangen door de respectievelijke data. In het voorbeeld is ook een knop om de tekst
													als bestand op de server.<br>
													Je kunt de volgende tokens als placeholders gebruiken voor de respectievelijke data van de gebruiker:<br>
													- {USERNAME}: Nikckname van de gebruiker<br>
													- {LAST_VISIT}: Datum laatste bezoek<br>
													- {LAST_REMIND}: Datum van verstuurde eerste herinnering email<br>
													De volgende tokens kunnen gebruikt worden als placeholders van system data:<br>
													- {SITENAME}: Naam van het forum<br>
													- {FORGOT_PASS}: Link naar ´Ik ben mijn wachtwoord vergeten´<br>
													- {ADMIN_MAIL}: Emailadres van de beheerder<br>
													- {EMAIL_SIG}: Handtekening<br>
													- {DAYS_INACTIVE}: Het bovenin gedefinieerde aantal dagen van inactiviteit<br>
													- {DAYS_TIL_DELETE}: Het bovenin gedefinieerde aantal tot verwijderen<br>',
	'ACP_USERREMINDER_MAIL_LOAD_FILE'			=> 'Laad bestand',
	'ACP_USERREMINDER_PREVIEW_TEXT'				=> 'Let op:<br>In het voorbeeld venster worden de tokens vervangen door hun respectievelijke data, dit kan betekenen dat de voorbeeldtekst eventueel onduidelijk onduidelijk kan zijn.',
	'ACP_USERREMINDER_MAIL_SAVE_FILE'			=> 'Opslaan',
	'ACP_USERREMINDER_FILE_NOT_FOUND'			=> 'Kan bestanbd ´%s´ niet laden!.',
	'ACP_USERREMINDER_FILE_ERROR'				=> 'Er trad een fout op tijdens het opslaan van bestand ´%s´!<br>Het bestand is <strong>niet opgeslagen</strong>!',
	'ACP_USERREMINDER_FILE_SAVED'				=> 'Bestand ´%s´ succesvol opgeslagen.',
	// ACP Reminder
	'ACP_USERREMINDER_REMINDER'					=> 'Herinner gebruikers',
	'ACP_USERREMINDER_REMINDER_EXPLAIN'			=> 'Een lijst van gebruikers die online zijn geweest, gepost hebben maar offline zijn sinds het aantal ingestelde dagen waarin zij als inactief gezien worden.
													Je kunt deze gebruikers handmatig markeren en herinnering emails versturen of verwijderen na de ingestelde periode nadat de 2e herinnering verstuurd is.
													Verwijderen is pas te selecteren als de ingestelde periodes in de instellingen zonder dat de gebruiker minimaal 1 keer ingelogd is geweest.',
	'ACP_USERREMINDER_REMINDER_ONE'				=> 'Eerste herinnering',
	'ACP_USERREMINDER_REMINDER_TWO'				=> 'Tweede herinnering',
	'ACP_USERREMINDER_NO_ENTRIES'				=> 'Geen data beschikbaar',
	'ACP_USERREMINDER_SORT_DESC'				=> 'Oplopend',
	'ACP_USERREMINDER_SORT_ASC'					=> 'Aflopend',
	'ACP_USERREMINDER_KEY_RD'					=> 'Registratie datum',
	'ACP_USERREMINDER_KEY_LV'					=> 'Laatste bezoek',
	'ACP_USERREMINDER_KEY_RO'					=> '1e herinnering',
	'ACP_USERREMINDER_KEY_RT'					=> '2e herinnering',
	'ACP_USERREMINDER_REGISTERED_ONLY'			=> 'Sleepers',
	'ACP_USERREMINDER_REGISTERED_ONLY_EXPLAIN'	=> 'Een lijst van gebruikers die nooit online zijn geweest na registratie en activatie.',
	// ACP Zeroposters
	'ACP_USERREMINDER_ZEROPOSTER'				=> 'Zeroposters',
	'ACP_USERREMINDER_ZEROPOSTER_EXPLAIN'		=> 'Een lijst van gebruikers die regelmatig online zijn maar nooit iets gepost hebben.',
));
