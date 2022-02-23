# Installation

* Clone repository to `lhc_web/extension` folder. It should be like `lhc_web/extension/2fa`
* Install database either by executing `2fa/doc/install.sql` file or executing this command php `php cron.php -s site_admin -e 2fa -c cron/update_structure`
* Activate extension in `lhc_web/settings/settings.ini.php` extension section `2fa` by Adding lines: 
```
'extensions' =>  array (  '2fa'  ),
``` 
* Install composer dependencies `cd extension/2fa && composer.phar update` 
* Navigate to Modules > 2FA and activate for you account.