<?php
/**
*
* @package UserReminder v1.4.0
* @copyright (c) 2019 - 2021 Mike-on-Tour
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

$lang = array_merge($lang, [
	// Module
	'CONFIRM_USER_DELETE'						=> [
		1	=> 'Weet je zeker dat je 1 gebruiker wilt verwijderen??<br><br><strong>Deze actie verwijderd de gebruiker permanent uit de database en kan niet worden teruggedraaid!</strong>',
		2	=> 'Weet je zeker dat je %d gebruikers wilt verwijderen??<br><br><strong>Deze actie verwijderd de gebruikers permanent uit de database en kan niet worden teruggedraaid!</strong>',
	],
	'NO_USER_SELECTED'							=> 'Je hebt geen enkele gebruiker geselecteerd voor deze actie, markeer tenminste 1 gebruiker.',
	'USER_DELETED'								=> [
		1	=> '1 gebruiker succesvol verwijderd',
		2	=> '%d gebruikers succesvol verwijderd',
	],
	'USER_REMINDED'								=> [
		1	=> 'Herinnering email verstuurd naar 1 gebruiker',
		2	=> 'Herinnering email verstuurd naar %d gebruikers',
	],
	'USER_POSTS'								=> 'Berichten',
	'DAYS_AGO'									=> 'Aantal dagen geleden',
	'AT_DATE'									=> 'Op',
	'MARK_REMIND'								=> 'Herinner',
	'MARK_DELETE'								=> 'Verwijder',
	'REMIND_MARKED'								=> 'Herinner gemarkeerden',
	'REMIND_ALL'								=> 'Herinner alle',
	'ACP_USERREMINDER_REMIND_ALL_TEXT'			=> 'Herinnert alle leden weergegeven in deze tabel.',
	'ACP_USERREMINDER_DELETE_ALL_TEXT'			=> '<span style="color:red">Verwijderd <b>ALL</b> leden weergegeven in deze tabel!</span>',
	'LOG_INACTIVE_REMIND_ONE'					=> '<strong>Eerste herinnering naar inactieve gebruikers gestuurd</strong><br>» %s',
	'LOG_INACTIVE_REMIND_TWO'					=> '<strong>Tweede herinnering naar inactieve gebruikers gestuurd</strong><br>» %s',
	'LOG_SLEEPER_REMIND'						=> '<strong>Email verstuurd naar sleepers</strong><br>» %s',
	//ACP
	'ACP_USERREMINDER'							=> 'User reminder',
	'ACP_USERREMINDER_SETTINGS'					=> 'Instelling User Reminder',
	'ACP_USERREMINDER_SETTINGS_EXPLAIN'			=> 'Hier pas je de instellingen aan voor User Reminder.',
	'ACP_USERREMINDER_SETTING_SAVED'			=> 'Instellingen User Reminder succesvol opgeslagen.',
	'ACP_USERREMINDER_GENERAL_SETTINGS'			=> 'Algemene instellingen',
	'ACP_USERREMINDER_ROWS_PER_PAGE'			=> 'Rijen per tabel pagina',
	'ACP_USERREMINDER_ROWS_PER_PAGE_TEXT'		=> 'Kies het aantal weer te geven per tabelpagina op de andere tabbladen.',
	'ACP_USERREMINDER_EXPERT_MODE'				=> 'Expert mode voor Reminder, Sleepers en Zeroposter tabbladen',
	'ACP_USERREMINDER_EXPERT_MODE_TEXT'			=> 'Wanneer je voor ´Ja´ kiest zullen er 2 extra knoppen weergegeven worden onder de tabellen van Reminder, Sleepers
													en Zeroposter tabellen zodat je ALLE leden weegegeven in die tabellen kunt herinneren of verwijderen.<br>
													<span style="color:red">Vooral de ´Verwijder alle´ knop kan grote gevolgen hebben, het gebruik van deze optie is alleen
													aan te bevelen voor beheerders die zich bewust zijn van de gevolgen!<br>
													Lees de respectievelijke sectie in het ´README.md´ bestand voor je deze instelling gaat gebruiken.</span>',
	'ACP_USERREMINDER_TIME_SETTINGS_TITLE'		=> 'Stel de herinnerings intervallen in',
	'ACP_USERREMINDER_TIME_SETTING_TEXT'		=> 'Stel het aantal dagen in waarna een gebruiker als inactief gezien word, het aantal dagen tussen het eerste ne tweede herinneringsmailtje om de gebruiker te herinneren dat inloggen noodzakelijk is, en de periode totdat de gebruiker verwijderd word.',
	'ACP_USERREMINDER_INACTIVE'					=> 'Aantal dagen dat een gebruiker offline is voordat deze al inactief gezien word',
	'ACP_USERREMINDER_DAYS_REMINDED'			=> 'Aantal dagen voordat een gebruiker als inactief  gezien word en een tweede herinnering verstuurd word;<br>
													tweede mail versturen word uitgeschakeld als je ´0´ invult',
	'ACP_USERREMINDER_AUTOREMIND'				=> 'Verstuur herinneringen automatisch?',
	'ACP_USERREMINDER_DAYS_UNTIL_DELETED'		=> 'Aantal dagen na laatste herinnering voordat een gebruiker verwijderd kan worden',
	'ACP_USERREMINDER_AUTODELETE'				=> 'Verwijder gebruiker automatisch?',
	// ACP Sleeper settings
	'ACP_USERREMINDER_SLEEPER_CONFIG'			=> 'Sleeper instellingen',
	'ACP_USERREMINDER_SLEEPER_CONFIG_TEXT'		=> 'Je kunt kiezen of sleepers herinnert dienen te worden en na hoeveel dagen dit moet gebeuren, tevens
													of de sleepers automatisch verwijderd moeten worden na een aantal dagen.',
	'ACP_USERREMINDER_REMIND_SLEEPER'			=> 'Wil je de sleepers een herinnering sturen?',
	'ACP_USERREMINDER_REMIND_SLEEPER_TEXT'		=> 'Als je sleepers wil herinneren om het forum te bezoeken na registratie, selecteer dan ´Ja´, in dat geval
													zullen er meer opties zichtbaar worden.',
	'ACP_USERREMINDER_SLEEPER_INACTIVE'			=> 'Aantal dagen tussen registratie en versturen herinnering',
	'ACP_USERREMINDER_AUTODELETE_SLEEPER'		=> 'Wil je sleepers automatisch verwijderen?',
	'ACP_USERREMINDER_AUTODELETE_SLEEPER_TEXT'	=> 'Als je ´Ja´ kiest, zullen sleepers automatisch verwijderd worden.<br>
													Na het selecteren van ´Ja´ zal er een extra insteling weergegeven worden om het aantal dagen in te stellen waarna een sleeper
													verwijderd zal worden. Afhankelijk van de instelling om sleepers te herinneren zal dit aantal dagen gelden als het het aantal om de herinnering te sturen of de registratie.',
	'ACP_USERREMINDER_SLEEPER_DELETETIME'		=> 'Aantal dagen tot verwijderen',
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
	'ACP_USERREMINDER_MAIL_LIMITS_TEXT'			=> 'Hier stel je de limiet in voor het aantal mails wat verstuurd mag worden door je provider; deze instelling is belangrijk om te voorkomen
													dat je mails kwijtraakt gedurende het versturen van grote aantalen emails die deze limieten overschrijden.<br>
													De maximale standaard waarde is 150 emails in een uur (3600 seconden). <strong>Geef de waarde op geldt voor jouw provider!</strong>',
	'ACP_USERREMINDER_MAIL_LIMIT_NUMBER'		=> 'Maximaal aantal emails',
	'ACP_USERREMINDER_MAIL_LIMIT_TIME'			=> 'Tijdsspanne waarbinnen dit aantal verstuurd mag worden',
	'ACP_USERREMINDER_MAIL_LIMIT_SECONDS'		=> 'seconden',
	'ACP_USERREMINDER_CRON_EXP'					=> 'Ter informatie kun je hier zien om welke tijd de cron taak voor het versturen van de emails gestart werd en
													hoeveel emails er verstuurd konden worden voordat deze in de wachtrij kwamen.',
	'ACP_USERREMINDER_LAST_CRON_RUN'			=> 'Laatste Cron run',
	'ACP_USERREMINDER_AVAILABLE_MAIL_CHUNK'		=> 'Aantal beschikbare emails',
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
	'ACP_USERREMINDER_MAIL_SLEEPER'				=> 'Sleeper herinner',
	'ACP_USERREMINDER_MAIL_PREVIEW'				=> 'In het rechtervenster kun je de tekst aanpassen van de gekozen email. Door op de ´Voorbeeld´ knop te klikken zie je de tekst zoals
													deze te zien is in de email. De tokens worden vervangen door de respectievelijke data. In het voorbeeld is ook een knop om de tekst
													als bestand op de server.<br>
													Je kunt de volgende tokens als placeholders gebruiken voor de respectievelijke data van de gebruiker:<br>
													- {USERNAME}: Nikckname van de gebruiker<br>
													- {LAST_VISIT}: Datum laatste bezoek<br>
													- {LAST_REMIND}: Datum van verstuurde eerste herinnering email<br>
													- {REG_DATE}: Date of registration<br>
													De volgende tokens kunnen gebruikt worden als placeholders van system data:<br>
													- {SITENAME}: Naam van het forum<br>
													- {FORGOT_PASS}: Link naar ´Ik ben mijn wachtwoord vergeten´<br>
													- {ADMIN_MAIL}: Emailadres van de beheerder<br>
													- {EMAIL_SIG}: Handtekening<br>
													- {DAYS_INACTIVE}: Het bovenin gedefinieerde aantal dagen van inactiviteit<br>
													- {DAYS_TIL_DELETE}: Het bovenin gedefinieerde aantal tot verwijderen<br>
													- {DAYS_DEL_SLEEPERS}: Bovenste gedefinieerde getal is het aantal dagen voordat een sleeper verwijderd zal worden<br>',
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
	// ACP Sleeper
	'ACP_USERREMINDER_SLEEPER'					=> 'Sleepers',
	'ACP_USERREMINDER_SLEEPER_EXPLAIN'			=> 'Een lijst van gebruikers die nooit online zijn geweest na registratie en activatie.',
	'ACP_USERREMINDER_REMINDER'					=> 'Reminder',
	'ACP_USERREMINDER_KEY_RE'					=> 'Datum',
	// ACP Zeroposters
	'ACP_USERREMINDER_ZEROPOSTER'				=> 'Zeroposters',
	'ACP_USERREMINDER_ZEROPOSTER_EXPLAIN'		=> 'Een lijst van gebruikers die regelmatig online zijn maar nooit iets gepost hebben.',
	// Support and Copyright
	'ACP_USERREMINDER_SUPPORT'					=> 'Als je wilt doneren om User Reminder´s ontwikkeling te ondersteunen gebruik dan deze link',
	'ACP_USERREMINDER_VERSION'					=> '<img src="https://img.shields.io/badge/Version-%1$s-green.svg?style=plastic" /><br>&copy; 2019 - %2$d by Mike-on-Tour',
]);
