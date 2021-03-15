<?php

namespace Drupal\my_users\Services;

/**
 * Class ImportUsersCsvService.
 */
class ImportUsersCsvService {

  /**
   * Constructs a new ImportUsersCsvService object.
   */
  public function __construct() {

  }

  /**
   *
   */
  public function saveCsv(string $name) {

    try {
      $connection = \Drupal::database();
      $query = $connection->insert('myusers')
        ->fields(['id', 'name'])
        ->values(['name' => $name]);
      $result = $query->execute();
    }
    catch (\Exception $e) {
      return $e->getMessage();
    }

    return $result;

  }

}
