<?php

namespace Drupal\my_users\Services;

/**
 * Class Show Users Service.
 */
class ShowUsersService {

  /**
   * Render Table from users.
   *
   * @param int $itemPerPage
   *   Item per page.
   *
   * @return array
   *   Return table.
   */
  public function renderTable(int $itemPerPage): array {

    $connection = \Drupal::database();
    $query = $connection->select('myusers')
      ->fields('myusers');
    $pager = $query->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit($itemPerPage);
    $result = $pager->execute()->fetchAll();

    $headers = [
      'Id',
      'Name',
    ];

    $rows = [];
    foreach ($result as $record) {
      $rows[] = [
        'data' => [
          $record->id,
          $record->name,
        ],
      ];
    }

    $form['table'] = [
      '#type' => 'table',
      '#header' => $headers,
      '#rows' => $rows,
      '#empty' => 'No entries available.',
    ];
    // Don't cache this page.
    $form['#cache']['max-age'] = 0;

    $form['pager'] = [
      '#type' => 'pager',
    ];

    return $form;

  }

}
