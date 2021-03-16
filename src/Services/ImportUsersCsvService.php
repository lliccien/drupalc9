<?php

namespace Drupal\my_users\Services;

/**
 * Class Import Users Csv Service.
 */
class ImportUsersCsvService {

  /**
   * Constructs a new ImportUsersCsvService object.
   */
  public function __construct() {

  }

  /**
   * Method Save csv.
   *
   * @param string $name
   *   Param name.
   *
   * @return \Drupal\Core\Database\StatementInterface|int|string|null
   *   return result database.
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
