Welcome to the fledgling MassForms platform based on Drupal 8.

Getting Started
==============
1. Clone this repo and checkout the dev branch.
1. Database setup. Pick a solution:
    1. If using the GovNext Drupal-VM (DVM), this should be already done for you.
    1. Make sure that a local database and database user exists that matches the settings.php file.
    1. Create a settings.local.php file in docroot/sites/demo.massforms8.mass.gov that provides appropriate local database settings.
1. If using the DVM, `vagrant ssh`
1. cd into the project folder; if using the DVM this is `cd /var/www/massforms8`
1. Use composer to pull down dependencies (including Drupal core): `composer install`
1. Set up development configuration: copy `docroot/sites/example.settings.local.php` to `docroot/sites/demo.massforms8.mass.gov/settings.local.php`
1. `cd docroot`
1. Install Drupal and import our config:
    1. If using Drupal VM or other Linux-based shell environment with Drush 8.1+ installed: `drush si --uri=http://demo.massforms8.mass.gov minimal --config-dir=../config/demo.massforms8.mass.gov/sync -v`
    1. If using Acquia Dev Desktop: `../vendor/bin/drush si --uri=http://demo.massforms8.mass.gov --db-url=mysql://root:@127.0.0.1:33067/demo_massforms8_mass_gov minimal --config-dir=../config/demo.massforms8.mass.gov/sync -v`
    1. In either event, you can set up the root user with an easy password by adding the following options to the command line: ` --account-name=massforms8 --account-pass=massforms8 --site-name='MassForms8 Demo'`
    1. And add `-y` to answer yes to all questions.  Note that this will skip the warning that you are about to nuke your database.
1. Web Server setup. Pick a solution:
    1. If using the GovNext Drupal-VM, this should be set up for you.
    1. Point Acquia Dev Desktop or other web server at the `docroot` directory.
    1. `../vendor/bin/drush @demo runserver`. This uses PHP's built-in web server.
1. If you have not created an easy password for the root user, get a login link for the root user, `drush @demo uli --no-browser` and open the link in a browser to log in.

Acquia Cloud
==============
1. To launch a new multisite, create a new database whose name matches the first section of the domain name.
1. Install the new multisite - `drush @mf8.dev si minimal --config-dir=../config/demo.massforms8.mass.gov/sync -v`
1. Add a remote for the Acquia Git repo and push there as needed.
1. Then run [Acquia Pipelines](https://docs.acquia.com/pipelines) to build the codebase. Then deploy it as usual.

Development Notes
==============
1. After every pull, run `composer install` to add/subtract any dependencies. You must perform this, and other composer operations, from the root directory of the project.
1. After every composer install, cd into the web directory and run `drush cr`.  Alternatively, if using the DrupalVM, use the @drupalvm.demo.massforms8.gov drush alias instead of @demo.
1. Install new modules and themes from contrib by adding them to composer.json, either manually or `composer require drupal/module_name "~8.0"`
1. To remove a module after experimenting, a) `drush @demo pm-uninstall module_name`, THEN b) in the root, `composer remove drupal/module_name` .

Tips
==============
1. `drush use @demo` is a good way to avoid having to type an alias over and over. In order to see what 'site' you have _used_, run `drush init`.
1. To use the drupal console with a multisite install, you must pass the --uri= parameter.  E.g.: `drupal --uri=demo.massforms8.mass.gov state:debug`
