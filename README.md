Welcome to the fledgling MassForms platform based on Drupal 8.

Getting Started
==============
1. Clone this repo.
1. Optional: Point Acquia Dev Desktop or other web server at the `web` directory.
1. `cd web`
1. Pull down dependencies (including Drupal core): `composer install`
1. Install Drupal and import our config: `drush si  --uri=http://hpc.massforms8.mass.gov --db-url=mysql://root:@127.0.0.1:33067/hpc_massforms8_mass_gov minimal --config-dir=../config/hpc.massforms8.mass.gov/sync -v`
1. Open a browser and login as admin: `drush uli`