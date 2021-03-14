<?php

namespace Drupal\my_users\Services;

/**
 * Class RegisterUsersService.
 */
class RegisterUsersService {

  /**
   *
   */
  public function renderRegisterUsesForm(): array {
    // $response = new AjaxResponse();
    //    $registerUsersFrom = \Drupal::formBuilder()->getForm(RegisterUserForm::class);
    // $renderer = \Drupal::service('renderer');
    //    $renderForm = $renderer->render($registerUsersFrom);
    //    return $registerUsersFrom;
    // Return [
    //      '#markup' => Markup::create("{$renderForm}"),
    //    ];.
  }

  /**
   * @param string $user
   *   Name user.
   *
   * @throws \Exception
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
