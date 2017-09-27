<?php

namespace Drupal\drupal8_migration_json_file\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\MigrateSkipProcessException;
use Drupal\migrate\Row;
use Drupal\taxonomy\Entity\Term;

/**
 * A plugin to output raw migration row and field data for debugging.
 *
 * @MigrateProcessPlugin(
 *   id = "migrate_json_file_get_term",
 *   handle_multiples = true
 * )
 */
class GetTerm extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($term_names, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    if (empty($term_names)) {
      throw new MigrateSkipProcessException();
    }
    $vocabulary = $this->configuration['vocabulary'];
    foreach($term_names as $key => $term_name) {
      if (is_null($term_name)) {
        continue;
      }
      if ($tid = $this->getTidByName($term_name, $vocabulary)) {
        $term = Term::load($tid);
      }
      else {
        $term = Term::create([
          'name' => $term_name,
          'vid' => $vocabulary,
        ])->save();
        if ($tid = $this->getTidByName($term_name, $vocabulary)) {
          $term = Term::load($tid);
        }
      }
      $tids[] = [
        'target_id' => is_object($term) ? $term->id() : 0,
      ];
    }
    return $tids;
  }

  /**
   * Load term by name.
   */
  protected function getTidByName($name = NULL, $vocabulary = NULL) {
    $properties = [];
    if (!empty($name)) {
      $properties['name'] = $name;
    }
    if (!empty($vocabulary)) {
      $properties['vid'] = $vocabulary;
    }
    $terms = \Drupal::entityManager()->getStorage('taxonomy_term')->loadByProperties($properties);
    $term = reset($terms);
    return !empty($term) ? $term->id() : 0;
  }
}
