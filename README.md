Welcome to the fledgling MassForms platform based on Drupal 8.

Getting Started
==============
1. Clone this repo and checkout the dev branch.
1. Database setup. Pick a solution: 
    1. Make sure that a local database and database user exists that matches the settings.php file.
    1. Create a settings.local.php file in web/sites/hpc.massforms8.mass.gov that provides appropriate local database settings.
1. Pull down dependencies (including Drupal core): `composer install`
1. `cd web`
1. Install Drupal and import our config: `../vendor/bin/drush si  --uri=http://hpc.massforms8.mass.gov --db-url=mysql://root:@127.0.0.1:33067/hpc_massforms8_mass_gov minimal --config-dir=../config/hpc.massforms8.mass.gov/sync -v`
1. Web Server setup. Pick a solution: 
    1. Point Acquia Dev Desktop or other web server at the `web` directory.
    1. `../vendor/bin/drush @hpc runserver`. This uses PHP's built-in web server. 
1. Open a browser and login as admin: `drush @hpc uli`

Development Notes
==============
1. After every pull, run `composer install` to add/subtract any dependencies. See Tips for Windows below.
1. After every composer install, run `drush cr`.
1. Install new modules and themes from contrib by adding them to composer.json, either manually or `composer require drupal/module_name "~8.0"`

Tips
==============
1. `drush use @hpc` is a good way to avoid having to type an alias over and over. In order to see what 'site' you have _used_, run `drush init`.
1. To use the drupal console with a multisite install, you must pass the --uri= parameter.  E.g.: `drupal --uri=hpc.massforms8.mass.gov state:debug`
1. If using Windows, not using a bash shell and already have drush and drupal console working, you will want to rename /vendor/bin to /vendor/bin-DISABLED so that you can use your local setup.  You will need to re-do this after every composer install.