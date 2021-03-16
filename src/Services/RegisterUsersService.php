<?php

namespace Drupal\my_users\Services;

/**
 * Class Register Users Service.
 */
class RegisterUsersService {

  /**
   * Method save user.
   *
   * @param string $user
   *   Param name user.
   *
   * @throws \Exception
   *   Return on fail Exception.
   */
  public function saveUser(string $user) {

    try {
      $connection = \Drupal::database();
      $query = $connection->insert('myusers')
        ->fields(['id', 'name'])
        ->values(['name' => $user]);
      $result = $query->execute();
    }
    catch (\Exception $e) {
      throw new \Exception("Data no save", $e);
    }
    return $result;
  }

  /**
   * Method unique name.
   *
   * @param string $name
   *   String name.
   *
   * @return bool
   *   Return.
   */
  public function uniqueName(string $name): bool {
    $connection = \Drupal::database();
    $query = $connection->select('myusers', 'm')
      ->fields('m', ['name'])
      ->condition('m.name', $name, '=');

    $result = $query->execute()->fetchAll();
    $valor = empty($result);
    return !empty($result);
  }

}
