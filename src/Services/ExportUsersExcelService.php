<?php

namespace Drupal\my_users\Services;

/**
 * Class Export Users Excel Service.
 */
class ExportUsersExcelService {

  /**
   * Constructs a new ExportUsersExcelService object.
   */
  public function __construct() {

  }

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
