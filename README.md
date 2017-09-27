# Drupal 8 migration Json File

Module to migrate content from Json file to nodes in Drupal 8.

The 'migrate_source_url' custom source plugin allows to read a json file from local environment,
in 'urls' you can define the path to that file:

```
source:
  plugin: migrate_source_url
  data_fetcher_plugin: file
  data_parser_plugin: json
  urls: data/json/posts.json
```

Note: There is a [json file](data/json/posts.json) with example data.

# Instructions:

## Install Drupal Console
If you don't have it yet, follow the installation instructions [here](https://docs.drupalconsole.com/en/getting/project.html)

## Enable custom module.

This command also will install the module dependencies:

  - migrate_plus
  - migrate_tools
  - migrate_drupal
  
`$ drupal module:install drupal8_migration_json_file`

## Execute migration.

Provide the database connection to the current Drupal 8, there is already an reported [issue](https://github.com/hechoendrupal/drupal-console/issues/3535).

`$ drupal migrate:execute migrate_json_file`

![alt text][execute]

[execute]: ./images/drupal-migrate-execute.png "Drupal Console migrate execute prompt"

You will see confirmation messages like:

![alt text][result]

[result]: ./images/drupal-migrate-execute-result.png "Drupal Console migrate execute result"
