<?php

namespace Drupal\my_users\Services;

/**
 * Class Export Users Excel Service.
 */
class ExportUsersExcelService {

  /**
   * Method csv Export.
   */
  public function csvExport() {
    $connection = \Drupal::database();
    $query = $connection->select('myusers')
      ->fields('myusers');
    return $query->execute()->fetchAll();
  }

}
