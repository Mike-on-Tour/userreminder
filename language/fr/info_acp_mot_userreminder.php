<?php
/**
*
* @package UserReminder v1.4.0
* @copyright (c) 2019 - 2021 Mike-on-Tour
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
* This translation courtesy of stone23
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
// ’ » “ ” …
//

$lang = array_merge($lang, [
	// Module
	'CONFIRM_USER_DELETE'						=> [
		1	=> 'Etes-vous vraiment certain de vouloir supprimer 1 utilisateur ?<br><br><strong>Cela supprime définitivement les utilisateurs de la base de données et ne peut pas être récupéré !</strong>',
		2	=> 'Etes-vous vraiment certain de vouloir supprimer %d utilisateurs ?<br><br><strong>TCela supprime définitivement les utilisateurs de la base de données et ne peut pas être récupéré !</strong>',
	],
	'NO_USER_SELECTED'							=> 'Vous n’avez sélectionné aucun utilisateur pour cette action, veuillez cocher au moins un utilisateur.',
	'USER_DELETED'								=> [
		1	=> '1 utilisateur supprimé avec succès',
		2	=> '%d utilisateurs supprimés avec succès',
	],
	'USER_REMINDED'								=> [
		1	=> 'Courriel de rappel envoyé à 1’utilisateur',
		2	=> 'Courriel de rappel envoyé à %d utilisateurs',
	],
	'USER_POSTS'								=> 'Messages',
	'DAYS_AGO'									=> 'Il y a nombre de jours',
	'AT_DATE'									=> 'Le',
	'MARK_REMIND'								=> 'Rappeler',
	'MARK_DELETE'								=> 'Supprimer',
	'REMIND_MARKED'								=> 'Envoyer rappel',
	'REMIND_ALL'								=> 'Rappeler tous les membres',
	'ACP_USERREMINDER_REMIND_ALL_TEXT'			=> 'Envoyer un rappel à tous les membres listés ici.',
	'ACP_USERREMINDER_DELETE_ALL_TEXT'			=> '<span style="color:red">Supprimer <b>TOUS</b> les membres listés ici !</span>',
	'LOG_INACTIVE_REMIND_ONE'					=> '<strong>Envoi du premier courriel de rappel aux utilisateurs inactifs</strong><br>» %s',
	'LOG_INACTIVE_REMIND_TWO'					=> '<strong>Envoi d’un deuxième courriel de rappel aux utilisateurs inactifs</strong><br>» %s',
	'LOG_SLEEPER_REMIND'						=> '<strong>Envoi d’un courriel de rappel aux dormants</strong><br>» %s',
	//ACP
	'ACP_USERREMINDER'							=> 'Rappel utilisateur',
	'ACP_USERREMINDER_SETTINGS'					=> 'Paramètres du rappel utilisateur',
	'ACP_USERREMINDER_SETTINGS_EXPLAIN'			=> 'C’est ici que vous personnalisez le rappel de l’utilisateur.',
	'ACP_USERREMINDER_SETTING_SAVED'			=> 'Les paramètres du rappel utilisateur ont bien été enregistrés.',
	'ACP_USERREMINDER_GENERAL_SETTINGS'			=> 'Paramètres généraux',
	'ACP_USERREMINDER_ROWS_PER_PAGE'			=> 'Lignes par page',
	'ACP_USERREMINDER_ROWS_PER_PAGE_TEXT'		=> 'Choisissez le nombre de lignes à afficher par page sur les autres onglets.',
	'ACP_USERREMINDER_EXPERT_MODE'				=> 'Mode expert pour les onglets rappels, dormants et Zero messages',
	'ACP_USERREMINDER_EXPERT_MODE_TEXT'			=> 'Si vous choisissez « Oui », deux boutons supplémentaires seront affichés sous les tableaux sur le rappel, les dormants et les onglets Zeroposter vous permettant de rappeler ou de supprimer TOUS les membres affichés dans ces tableaux.<br>
													<span style="color:red">Étant donné que le bouton « Supprimer tout » peut causer de graves dommages à l’utilisation de ce
													Cette option n’est recommandée que pour les administrateurs conscients des risques encourus !<br>
													Veuillez lire la section correspondante dans le fichier "README.md" avant d’utiliser ce paramètre.</span>',
	'ACP_USERREMINDER_TIME_SETTINGS_TITLE'		=> 'Configurer les intervalles de rappel',
	'ACP_USERREMINDER_TIME_SETTING_TEXT'		=> 'Configurez le délai en jours jusqu’à ce qu’un utilisateur soit considéré comme inactif<br>Le délai en jours entre le premier et le deuxième courriel pour rappeler à ce membre qu’une connexion est nécessaire et la période suivante jusqu’à la suppression de cet utilisateur. <br> Vous pouvez également nommer les utilisateurs protégés contre les courriels de rappel et la suppression.',
	'ACP_USERREMINDER_INACTIVE'					=> 'Nombre de jours au bout desquels un utilisateur hors ligne est considéré comme inactif',
	'ACP_USERREMINDER_DAYS_REMINDED'			=> 'Nombre de jours avant qu’un utilisateur étant considéré comme inactif ne reçoive le deuxième courriel de rappel :<br>Note : l’envoi d’un deuxième courriel est désactivé si vous saisissez ´0´',
	'ACP_USERREMINDER_AUTOREMIND'				=> 'Envoyer automatiquement des courriels de rappel ?',
	'ACP_USERREMINDER_DAYS_UNTIL_DELETED'		=> 'Nombre de jours entre le dernier rappel et la suppression d’un utilisateur',
	'ACP_USERREMINDER_AUTODELETE'				=> 'Supprimer automatiquement les utilisateurs ?',
	// ACP Sleeper settings
	'ACP_USERREMINDER_SLEEPER_CONFIG'			=> 'Configuration des "dormants"',
	'ACP_USERREMINDER_SLEEPER_CONFIG_TEXT'		=> 'Vous pouvez choisir ici si les membres dormants doivent être rappelés et après quel nombre de jours cela doit se produire.
													ainsi que s’ils doivent être supprimés automatiquement après un certain nombre de jours.',
	'ACP_USERREMINDER_REMIND_SLEEPER'			=> 'Voulez-vous rappeler les dormants ?',
	'ACP_USERREMINDER_REMIND_SLEEPER_TEXT'		=> 'Si les dormants doivent être rappelés de visiter votre forum après l’enregistrement, veuillez sélectionner "Oui", dans ce cas vous verrez quelques options supplémentaires.',
	'ACP_USERREMINDER_SLEEPER_INACTIVE'			=> 'Nombre de jours entre l’enregistrement et le rappel',
	'ACP_USERREMINDER_AUTODELETE_SLEEPER'		=> 'Voulez-vous supprimer les dormants automatiquement ?',
	'ACP_USERREMINDER_AUTODELETE_SLEEPER_TEXT'	=> 'Si vous sélectionnez "Oui", les dormants seront supprimés automatiquement.<br>Après avoir sélectionné "Oui", un autre paramètre sera affiché pour sélectionner le nombre de jours après lequel un dormant sera supprimé. Selon que vous avez choisi de rappeler les dormants, ce nombre de jours compte soit à partir de ce rappel ou à partir de l’enregistrement.',
	'ACP_USERREMINDER_SLEEPER_DELETETIME'		=> 'Nombre de jours avant la suppression',
	// ACP Zeroposter settings
	'ACP_USERREMINDER_ZEROPOSTER_CONFIG'		=> 'Configuration des utilisateurs sans messages',
	'ACP_USERREMINDER_ZEROPOSTER_CONFIG_TEXT'	=> 'Ici, vous pouvez choisir si les utilisateurs sans messages doivent être traités comme des utilisateurs inactifs d’origine. Si vous sélectionnez «Oui», tous les paramètres de la section précédente s’appliquent également aux utilisateurs sans messages. Dans ce cas, les utilisateurs sans messages seront alors affichés dans un tableau étendu indiquant les dates du premier et du deuxième rappel et la case de sélection pour suppression comme le tableau pour les utilisateurs à rappeler.',
	'ACP_USERREMINDER_REMIND_ZEROPOSTER'		=> 'Voulez-vous rappeler et supprimer les utilisateurs sans messages comme les utilisateurs inactifs ?',
	// ACP Protection settings
	'ACP_USERREMINDER_PROTECTION_CONFIG'		=> 'Configuration des utilisateurs protégés',
	'ACP_USERREMINDER_PROTECTION_CONFIG_TEXT'	=> 'Vous pouvez également nommer des utilisateurs protégés contre les courriels de rappel et la suppression. Vous pouvez sélectionner des utilisateurs individuels avec leur nom d’utilisateur et / ou tous les membres d’un groupe par défaut en sélectionnant ce groupe. les deux sélections fonctionnent indépendamment.',
	'ACP_USERREMINDER_PROTECTED_MEMBERS'		=> 'Saisissez les noms d’utilisateur que vous souhaitez protéger contre les rappels et la suppression.<br>Chaque nom d’utilisateur DOIT ÊTRE sur sa propre ligne.',
	'ACP_USERREMINDER_PROTECTED_GROUPS'			=> 'Veuillez sélectionner le(s) groupe(s) par défaut dont les membres doivent être protégés contre le rappel et la suppression. Les groupes déjà sélectionnés sont mis en surbrillance.<br>Tout en maintenant la touche «Ctrl» enfoncée, vous pouvez sélectionner plusieurs groupes en cliquant sur les noms respectifs',
	// ACP Mail settings
	'ACP_USERREMINDER_MAIL_SETTINGS_TITLE'		=> 'Configuration des courriels',
	'ACP_USERREMINDER_MAIL_LIMITS_TEXT'			=> 'Vous pouvez entrer ici les limites définies par votre fournisseur pour l’envoi des courriels ; ces paramètres sont importants pour éviter de perdre des courriels lors de l’envoi d’un grand nombre de courriels qui dépasse ces limites.<br>Les valeurs prédéfinies correspondent à un nombre maximum de 150 courriels qui peuvent être envoyés en une heure (3600 secondes). <strong>Veuillez saisir les valeurs qui s’appliquent à votre fournisseur !</strong>.',
	'ACP_USERREMINDER_MAIL_LIMIT_NUMBER'		=> 'Nombre maximal de courriels',
	'ACP_USERREMINDER_MAIL_LIMIT_TIME'			=> 'Délai dans lequel ce nombre de courriels peut être envoyé',
	'ACP_USERREMINDER_MAIL_LIMIT_SECONDS'		=> 'secondes',
	'ACP_USERREMINDER_CRON_EXP'					=> 'Pour votre information, vous pouvez voir ici à quelle heure la tâche cron pour l’envoi de courriels s’est exécutée la dernière fois et
													combien de courriels peuvent être envoyés actuellement sans passer par la file d’attente.',
	'ACP_USERREMINDER_LAST_CRON_RUN'			=> 'Dernière exécution du Cron',
	'ACP_USERREMINDER_AVAILABLE_MAIL_CHUNK'		=> 'Nombre de courriels actuellement disponibles',
	'ACP_USERREMINDER_EMAIL_BCC_TEXT'			=> 'Ici, vous pouvez définir une adresse courriel pour envoyer une copie et/ou une copie cachée des courriels de rappel à.',
	'ACP_USERREMINDER_EMAIL_BCC'				=> 'Envoyez une copie cachée à',
	'ACP_USERREMINDER_EMAIL_CC'					=> 'Envoyez une copie à',
	// ACP Mail text edit
	'ACP_USERREMINDER_MAIL_EDIT_TITLE'			=> 'Modifier les textes des courriels',
	'ACP_USERREMINDER_MAIL_EDIT_TEXT'			=> 'Ici, vous pouvez modifier le texte prédéfini du premier et du deuxième courriel de rappel.',
	'ACP_USERREMINDER_MAIL_LANG'				=> 'Selectionner la langue',
	'ACP_USERREMINDER_MAIL_FILE'				=> 'Sélectionnez le fichier que vous souhaitez modifier',
	'ACP_USERREMINDER_MAIL_ONE'					=> '1er rappel',
	'ACP_USERREMINDER_MAIL_TWO'					=> '2ème rappel',
	'ACP_USERREMINDER_MAIL_SLEEPER'				=> 'Rappel des dormants',
	'ACP_USERREMINDER_MAIL_PREVIEW'				=> 'Dans la fenêtre de droite, vous pouvez modifier le texte de le courriel choisi. En cliquant sur le bouton ´Aperçu´ le texte est affiché ci-dessous comme il sera affiché dans le courriel envoyé. Les caractères seront remplacés par vos données respectives. Avec l’aperçu s’affichera un bouton pour enregistrer le texte sous forme de fichier sur votre serveur.<br>Vous pouvez utiliser les caractères suivants comme espaces réservés pour les données respectives de l’utilisateur concerné :<br>
													- {USERNAME} : Le nom d’utilisateur des membres<br>
													- {LAST_VISIT} : Date de la dernière connexion<br>
													- {LAST_REMIND} : Date du premier courriel de rappel<br>
													- {REG_DATE}: Date d’enregistrement<br>
													Les caractères suivants peuvent être utilisés comme espaces réservés pour les données système :<br>
													- {SITENAME} : Nom de votre forum<br>
													- {FORGOT_PASS} : Lien vers ´Mot de passe oublié´<br>
													- {ADMIN_MAIL} : L’adresse courriel de l’administrateur<br>
													- {EMAIL_SIG} : Signature<br>
													- {DAYS_INACTIVE} : Le nombre de jours d’inactivité défini ci-dessus<br>
													- {DAYS_TIL_DELETE} : Le nombre de jours défini ci-dessus jusqu’à la suppression<br>
													- {DAYS_DEL_SLEEPERS}: Le nombre de jours défini ci-dessus jusqu’à la suppression d’un dormant<br>',
	'ACP_USERREMINDER_MAIL_LOAD_FILE'			=> 'Charger un fichier',
	'ACP_USERREMINDER_PREVIEW_TEXT'				=> 'Veuillez noter :<br>Dans l’aperçu du texte, les caractères pour les données de l’utilisateur cocerné sont remplacés par vos données respectives, cela signifie que le texte résultant pourrait logiquement ne pas avoir de sens.',
	'ACP_USERREMINDER_MAIL_SAVE_FILE'			=> 'Sauvegarder le  fichier',
	'ACP_USERREMINDER_FILE_NOT_FOUND'			=> 'Impossible de charger le fichier ´%s´.',
	'ACP_USERREMINDER_FILE_ERROR'				=> 'Une erreur s’est produite lors de l’enregistrement du fichier ´%s´ ! <br>Le fichier <strong>n’a pas été enregistré</strong> !',
	'ACP_USERREMINDER_FILE_SAVED'				=> 'Le fichier ´%s´ a été sauvegardé avec succès.',

	// ACP Reminder
	'ACP_USERREMINDER_REMINDER'					=> 'Rappeler aux utilisateurs',
	'ACP_USERREMINDER_REMINDER_EXPLAIN'			=> 'Une liste des utilisateurs qui étaient en ligne et ont publié quelque chose, mais qui ont été hors ligne pendant le nombre de jours défini dans l’onglet Paramètres pour être considérés comme inactifs.
													Vous pouvez sélectionner manuellement ces utilisateurs pour leur envoyer les courriels de rappel ou les supprimer après la période définie après le deuxième rappel.
													La suppression n’est pas sélectionnable jusqu’à ce que les périodes définies dans l’onglet de configuration se soient écoulées sans que cet utilisateur ne se soit connecté au moins une fois.',
	'ACP_USERREMINDER_REMINDER_ONE'				=> 'Premier rappel',
	'ACP_USERREMINDER_REMINDER_TWO'				=> 'Second rappel',
	'ACP_USERREMINDER_NO_ENTRIES'				=> 'Aucune donnée disponible',
	'ACP_USERREMINDER_SORT_DESC'				=> 'Croissant',
	'ACP_USERREMINDER_SORT_ASC'					=> 'Decroissant',
	'ACP_USERREMINDER_KEY_RD'					=> 'Date d’inscription',
	'ACP_USERREMINDER_KEY_LV'					=> 'Dernière visite',
	'ACP_USERREMINDER_KEY_RO'					=> '1er rappel',
	'ACP_USERREMINDER_KEY_RT'					=> '2ème rappel',
	// ACP Sleeper
	'ACP_USERREMINDER_SLEEPER'					=> 'Dormants',
	'ACP_USERREMINDER_SLEEPER_EXPLAIN'			=> 'Une liste des utilisateurs qui n’ont jamais été en ligne après l’enregistrement et l’activation.',
	'ACP_USERREMINDER_REMINDER'					=> 'Rappel',
	'ACP_USERREMINDER_KEY_RE'					=> 'Date',
	// ACP Zeroposters
	'ACP_USERREMINDER_ZEROPOSTER'				=> 'N’ont posté aucun message',
	'ACP_USERREMINDER_ZEROPOSTER_EXPLAIN'		=> 'Une liste des utilisateurs qui sont en ligne régulièrement mais qui n’ont jamais rien publié.',
	// Support and Copyright
	'ACP_USERREMINDER_SUPPORT'					=> 'Si vous souhaitez faire un don pour le développement de User Reminder, veuillez utiliser ce lien',
	'ACP_USERREMINDER_VERSION'					=> '<img src="https://img.shields.io/badge/Version-%1$s-green.svg?style=plastic" /><br>&copy; 2019 - %2$d by Mike-on-Tour',
]);
