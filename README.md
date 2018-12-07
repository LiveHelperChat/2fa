# Installation
* Upload the files to your /extension folder
* Install database either by executing doc/install.sql file or executing this command php _"cron.php -s site_admin -e 2fa -c cron/update_structure"_
* Activate extension in settings/settings.ini.php extension section "2fa" by Adding lines: 
<code>'extensions' =>  array (  '2fa',  ),	</code> 
* Install composer dependencies <code>cd extension/2fa && composer.phar update</code> 
* Navigate to Modules > 2FA and activate for you account.