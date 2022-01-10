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
		1	=> '¿Estás completamente seguro de querer eliminar 1 usuario?<br><br><strong>¡Esto eliminará al usuario de forma permanente de la base de datos y no se podrá deshacer el cambio!</strong>',
		2	=> '¿Estás completamente seguro de querer eliminar %d usuarios?<br><br><strong>¡Esto eliminará a los usuarios de forma permanente de la base de datos y no se podrán deshacer los cambios!</strong>',
	],
	'NO_USER_SELECTED'							=> 'No has seleccionado a ningún usuario para esta acción, por favor selecciona por lo menos un usuario.',
	'USER_DELETED'								=> [
		1	=> '1 usuario eliminado satisfactoriamente',
		2	=> '%d usuarios eliminados satisfactoriamente',
	],
	'USER_REMINDED'								=> [
		1	=> 'Correo de recordatorio enviado a 1 usuario',
		2	=> 'Correo de recordatorio enviado a %d usuarios',
	],
	'USER_POSTS'								=> 'Mensajes',
	'DAYS_AGO'									=> 'Número de días',
	'AT_DATE'									=> 'En',
	'MARK_REMIND'								=> 'Recordar',
	'MARK_DELETE'								=> 'Eliminar',
	'REMIND_MARKED'								=> 'Recordar a usuarios seleccionados',
	'REMIND_ALL'								=> 'Recordar a todos',
	'ACP_USERREMINDER_REMIND_ALL_TEXT'			=> 'Recuerda a todos los miembros listados en esta tabla.',
	'ACP_USERREMINDER_DELETE_ALL_TEXT'			=> '<span style="color:red">¡Eliminar <b>TODA</b> la lista de miembros en esta tabla!</span>',
	'LOG_INACTIVE_REMIND_ONE'					=> '<strong>Enviar primer correo de recordatorio a usuarios inactivos</strong><br>» %s',
	'LOG_INACTIVE_REMIND_TWO'					=> '<strong>Enviar segundo correo de recordatorio a usuarios inactivos</strong><br>» %s',
	'LOG_SLEEPER_REMIND'						=> '<strong>Envío de correo electrónico recordatorio a los inactivos</strong><br>» %s',
	//ACP
	'ACP_USERREMINDER'							=> 'Recordatorio de Usuario',
	'ACP_USERREMINDER_SETTINGS'					=> 'Opciones para recordatorio de usuario',
	'ACP_USERREMINDER_SETTINGS_EXPLAIN'			=> 'Aquí es donde se configura el recordatorio de usuario.',
	'ACP_USERREMINDER_SETTING_SAVED'			=> 'Opciones de recordatorio de usuario han sido guardadas satisfactoriamente.',
	'ACP_USERREMINDER_GENERAL_SETTINGS'			=> 'Ajustes generales',
	'ACP_USERREMINDER_ROWS_PER_PAGE'			=> 'Filas por página de tabla',
	'ACP_USERREMINDER_ROWS_PER_PAGE_TEXT'		=> 'Elige el número de filas que se mostrarán por página de tabla en las otras pestañas.',
	'ACP_USERREMINDER_EXPERT_MODE'				=> 'Modo experto para las pestañas Recordatorio, Inactivos y Sin Publicaciones',
	'ACP_USERREMINDER_EXPERT_MODE_TEXT'			=> 'Si eliges "Sí", se mostrarán dos botones adicionales debajo de las tablas del Recordatorio, Inactivos
													y Sin Publicaciones que te permiten recordar o eliminar a TODOS los miembros que aparecen en esas tablas.<br>
													<span style="color:red">Ya que especialmente el botón "Borrar todo" puede causar graves daños el uso de este
													¡solo se recomienda a los administradores que sean conscientes de los peligros que conlleva!<br>
													Por favor, lee la sección correspondiente en el archivo ´README.md´ antes de utilizar esta configuración.</span>',
	'ACP_USERREMINDER_TIME_SETTINGS_TITLE'		=> 'Configurar los intervalos de recordatorios',
	'ACP_USERREMINDER_TIME_SETTING_TEXT'		=> 'Configura el tiempo en días para que un usuario sea visto como inactivo, el tiempo en días entre el primer y el segundo correo electrónico para recordarle a este miembro que es necesario iniciar sesión y el siguiente período hasta que se elimine a este usuario.',
	'ACP_USERREMINDER_INACTIVE'					=> 'Número de días desconectado para que un usuario se considere inactivo',
	'ACP_USERREMINDER_DAYS_REMINDED'			=> 'Número de días desconectado para que un usuario que es considerado inactivo reciba el segundo correo de recordatorio;<br>
													esta opción está deshabilitada si usted ingresa ´0´',
	'ACP_USERREMINDER_AUTOREMIND'				=> '¿Enviar correos de recordatorio automáticamente?',
	'ACP_USERREMINDER_DAYS_UNTIL_DELETED'		=> 'Número de días después del último recordatorio para que se pueda eliminar a un usuario:',
	'ACP_USERREMINDER_AUTODELETE'				=> '¿Eliminar usuarios automáticamente?',
	// ACP Sleeper settings
	'ACP_USERREMINDER_SLEEPER_CONFIG'			=> 'Configuración inactivos',
	'ACP_USERREMINDER_SLEEPER_CONFIG_TEXT'		=> 'Aquí puedes elegir si los inactivos deben ser recordados y después de qué número de días esto debe ocurrir
													así como el número de días que deben transcurrir para ser eliminados.',
	'ACP_USERREMINDER_REMIND_SLEEPER'			=> '¿Quieres recordar a los inactivos?',
	'ACP_USERREMINDER_REMIND_SLEEPER_TEXT'		=> 'Si hay que recordar a los inactivos que visiten tu foro después del registro, selecciona "Sí", en este caso
													verás algunas opciones más.',
	'ACP_USERREMINDER_SLEEPER_INACTIVE'			=> 'Número de días entre el registro y el recordatorio',
	'ACP_USERREMINDER_AUTODELETE_SLEEPER'		=> '¿Deseas eliminar automáticamente los inactivos?',
	'ACP_USERREMINDER_AUTODELETE_SLEEPER_TEXT'	=> 'Si seleccionas "Sí" los inactivos se borrarán automáticamente.<br>
													Después de seleccionar "Sí" se desplegará otro ajuste para seleccionar el número de días después de los cuales un inactivo
													será eliminado. Dependiendo de si has seleccionado recordar a los inactivos este número de días la cuenta
													comenzará a partir de este recordatorio o de la inscripción.',
	'ACP_USERREMINDER_SLEEPER_DELETETIME'		=> 'Número de días hasta la eliminación',
	// ACP Zeroposter settings
	'ACP_USERREMINDER_ZEROPOSTER_CONFIG'		=> 'Configuración de Usuarios Sin Publicaciones',
	'ACP_USERREMINDER_ZEROPOSTER_CONFIG_TEXT'	=> 'Aquí puedes elegir si los usuarios sin publicaciones deben ser tratados como los usuarios inactivos originales. Si seleccionas ´Sí´, todos los ajustes de la sección anterior se aplicarán también a los usuarios sin publicaciones. En este caso, los los usuarios sin publicaciones se mostrarán en una tabla ampliada que muestra las fechas del primer y segundo recordatorio y el cuadro de selección para la eliminación como la tabla para los usuarios a los que se les debe recordar.',
	'ACP_USERREMINDER_REMIND_ZEROPOSTER'		=> '¿Quieres recordar y eliminar a los usuarios sin publicaciones como a los usuarios inactivos?',
	// ACP Protection settings
	'ACP_USERREMINDER_PROTECTION_CONFIG'		=> 'Configuración de usuarios protegidos',
	'ACP_USERREMINDER_PROTECTION_CONFIG_TEXT'	=> 'También puedes nombrar a los usuarios que están protegidos contra cualquier correo electrónico de recordatorio y eliminación. Puedes seleccionar usuarios individuales con su nombre de usuario y/o todos los miembros de un grupo predeterminado seleccionando este grupo. Ambas selecciones funcionan de forma independiente.',
	'ACP_USERREMINDER_PROTECTED_MEMBERS'		=> 'Introduce los nombres de usuario de los usuarios que deseas proteger contra ser recordado y eliminado.<br>¡Cada nombre de usuario DEBE ESTAR en una nueva línea!',
	'ACP_USERREMINDER_PROTECTED_GROUPS'			=> 'Por favor, selecciona el/los grupo(s) predeterminado(s) cuyos miembros deben ser protegidos contra ser recordatorios y eliminaciones. Los grupos ya seleccionados están resaltados.<br>Mientras se mantiene pulsada la tecla ´Ctrl´ se puede seleccionar más de un grupo haciendo clic en los nombres respectivos',
	// ACP Mail settings
	'ACP_USERREMINDER_MAIL_SETTINGS_TITLE'		=> 'Configuración del Correo',
	'ACP_USERREMINDER_MAIL_LIMITS_TEXT'			=> 'Aquí puedes introducir los límites definidos por tu proveedor para el envío de correos electrónicos; estos ajustes son importantes para
													evitar la pérdida de correos electrónicos durante el envío de un gran número de correos electrónicos que superen esos límites.<br>
													Los valores predefinidos representan un número máximo de 150 correos electrónicos que pueden enviarse en una hora
													(3600 segundos). <strong>¡Por favor, introduce los valores que se aplican a tu proveedor!</strong>',
	'ACP_USERREMINDER_MAIL_LIMIT_NUMBER'		=> 'Número máximo de correos electrónicos',
	'ACP_USERREMINDER_MAIL_LIMIT_TIME'			=> 'Plazo en el que se puede enviar este número de correos electrónicos',
	'ACP_USERREMINDER_MAIL_LIMIT_SECONDS'		=> 'segundos',
	'ACP_USERREMINDER_CRON_EXP'					=> 'Para tu información puedes ver aquí a qué hora se ejecutó la última vez la tarea cron para el envío de correos electrónicos y
													cuántos correos electrónicos pueden enviarse actualmente sin ir a la cola.',
	'ACP_USERREMINDER_LAST_CRON_RUN'			=> 'Última ejecución de Cron',
	'ACP_USERREMINDER_AVAILABLE_MAIL_CHUNK'		=> 'Número de correos electrónicos disponibles actualmente',
	'ACP_USERREMINDER_EMAIL_BCC_TEXT'			=> 'Aquí puede configurar una dirección de correo electrónico para enviar una copia oculta y/o una copia de los correos electrónicos de recordatorios.',
	'ACP_USERREMINDER_EMAIL_BCC'				=> 'Enviar una copia oculta a',
	'ACP_USERREMINDER_EMAIL_CC'					=> 'Enviar una copia a',
	// ACP Mail text edit
	'ACP_USERREMINDER_MAIL_EDIT_TITLE'			=> 'Editar el texto del correo',
	'ACP_USERREMINDER_MAIL_EDIT_TEXT'			=> 'Aquí puede editar el texto predefinido del primer y segundo correo de recordatorio.',
	'ACP_USERREMINDER_MAIL_LANG'				=> 'Seleccionar lenguaje',
	'ACP_USERREMINDER_MAIL_FILE'				=> 'Seleccionar el archivo que desea editar',
	'ACP_USERREMINDER_MAIL_ONE'					=> '1er. recordatorio',
	'ACP_USERREMINDER_MAIL_TWO'					=> '2do. recordatorio',
	'ACP_USERREMINDER_MAIL_SLEEPER'				=> 'Recordatorio a Inactivos',
	'ACP_USERREMINDER_MAIL_PREVIEW'				=> 'En la ventana de la derecha, puedes editar el texto del correo electrónico elegido. Al hacer click en ´Vista Previa´ el texto se visualiza
													tal como se mostrará en el correo enviado. Los tokens serán reemplazdos con sus respectivos datos. Junto a la vista previa se mostrará un botón
													para guardar el mensaje como un archivo en su servidor.<br>
													Puedes usar los siguientes tokens como marcadores de posición para los datos respectivos del usuario dirigido:<br>
													- {USERNAME}: Los nombre de los usuarios<br>
													- {LAST_VISIT}: Fecha de la última conexión<br>
													- {LAST_REMIND}: Fecha del primer correo de recordatorio<br>
													- {REG_DATE}: Date of registration<br>
													Los siguientes tokens se pueden usar como marcadores de posición para los datos del sistema:<br>
													- {SITENAME}: Nombre de tu foro<br>
													- {FORGOT_PASS}: Enlace a ´He olvidado mi clave´<br>
													- {ADMIN_MAIL}: La dirección de correo electrónico del administrador<br>
													- {EMAIL_SIG}: Saludo<br>
													- {DAYS_INACTIVE}: El número de días de inactividad definido anteriormente<br>
													- {DAYS_TIL_DELETE}: El número de días definido anteriormente hasta la eliminación<br>
													- {DAYS_DEL_SLEEPERS}: The above defined number of days until a sleeper is deleted<br>',
	'ACP_USERREMINDER_MAIL_LOAD_FILE'			=> 'Cargar archivo',
	'ACP_USERREMINDER_PREVIEW_TEXT'				=> 'Por favor toma nota:<br>En el texto de la vista previa, los tokens para los datos del usuario a quien se dirige el mensaje se reemplazan con sus datos respectivos, esto significa que el texto resultante lógicamente podría no tener ningún sentido.',
	'ACP_USERREMINDER_MAIL_SAVE_FILE'			=> 'Guardar archivo',
	'ACP_USERREMINDER_FILE_NOT_FOUND'			=> 'No se puede cargar el archivo ´%s´.',
	'ACP_USERREMINDER_FILE_ERROR'				=> 'Un error ha ocurrido mientras se guardaba el archivo ´%s´!<br>El archivo <strong>no ha sido guardado.</strong>!',
	'ACP_USERREMINDER_FILE_SAVED'				=> 'Se ha guardado el archivo satisfactoriamente ´%s´.',
	// ACP Reminder
	'ACP_USERREMINDER_REMINDER'					=> 'Usuarios recordados',
	'ACP_USERREMINDER_REMINDER_EXPLAIN'			=> 'Una lista de aquellos usuarios que estuvieron en línea y publicaron algo pero han estado desconectados durante la cantidad de días definidos en la pestaña de configuración para ser tomados como inactivos.
													Puedes seleccionar manualmente estos usuarios para enviarles los correos electrónicos de recordatorio o eliminarlos después del período de tiempo establecido después de que haya pasado el segundo recordatorio.
													La eliminación no se puede seleccionar hasta que hayan transcurrido los períodos definidos en la pestaña de configuración sin que este usuario haya iniciado sesión al menos una vez.',
	'ACP_USERREMINDER_REMINDER_ONE'				=> 'Primer recordatorio',
	'ACP_USERREMINDER_REMINDER_TWO'				=> 'Segundo recordatorio',
	'ACP_USERREMINDER_NO_ENTRIES'				=> 'No hay datos disponibles',
	'ACP_USERREMINDER_SORT_DESC'				=> 'Ascendente',
	'ACP_USERREMINDER_SORT_ASC'					=> 'Descendente',
	'ACP_USERREMINDER_KEY_RD'					=> 'Fecha de registro',
	'ACP_USERREMINDER_KEY_LV'					=> 'Última visita',
	'ACP_USERREMINDER_KEY_RO'					=> '1er. recordatorio',
	'ACP_USERREMINDER_KEY_RT'					=> '2do. recordatorio',
	// ACP Sleeper
	'ACP_USERREMINDER_SLEEPER'					=> 'Inactivos',
	'ACP_USERREMINDER_SLEEPER_EXPLAIN'			=> 'Una lista de aquellos usuarios que nunca se conectaron después del registro y activación.',
	'ACP_USERREMINDER_REMINDER'					=> 'Recordatorio',
	'ACP_USERREMINDER_KEY_RE'					=> 'Fecha',
	// ACP Zeroposters
	'ACP_USERREMINDER_ZEROPOSTER'				=> 'Nunca activos',
	'ACP_USERREMINDER_ZEROPOSTER_EXPLAIN'		=> 'Una lista de aquellos usuarios que se han conectado regularmente pero que nunca han publicado nada.',
	// Support and Copyright
	'ACP_USERREMINDER_SUPPORT'					=> 'Si quieres hacer una donación para el desarrollo de User Reminder, utiliza este enlace',
	'ACP_USERREMINDER_VERSION'					=> '<img src="https://img.shields.io/badge/Version-%1$s-green.svg?style=plastic" /><br>&copy; 2019 - %2$d by Mike-on-Tour',
]);
