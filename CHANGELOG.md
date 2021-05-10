CHANGELOG
=========

2.3.0
-----
* Added compatibility with Symfony 5.2.
* Added compatibility with Symfony 3.4.

2.2.0
-----

* Implemented additional cases for YAML keys transformation.
* Extract BrachInjector from key transformer.
* Update merging of omitted translation keys to YAML files.

2.1.0
-----

* Added console command for the export of omitted translation keys (`aeliot_trans_maintain:yaml:export_missed_translations`).
* Update translator decorator for hot switching of inserting position by environment variable.

2.0.2
-----

* Downgrade dependency of symfony/translation-contracts.

2.0.1
-----

* Fixed creation of empty directories.
* Changed duplicated keys repost header.

2.0.0
-----

* Added testing of YAML files.
* Added translator decorator.

1.0.0
-----

* Initial version based on Symfony 4.4.
* Implemented YAML files transformation.
* Added console commands:
    * aeliot_trans_maintain:yaml:transform - files transformer,
    * aeliot_trans_maintain:yaml:sort - separate keys sorter.
