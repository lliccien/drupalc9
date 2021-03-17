<?php

namespace Drupal\my_users\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'RegisterUsersBlock' block.
 *
 * @Block(
 *  id = "register_users_block",
 *  admin_label = @Translation("Register users block"),
 * )
 */
class RegisterUsersBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];

    $registerUsersForm = \Drupal::formBuilder()->getForm('Drupal\my_users\Form\RegisterUsersForm');
    $registerUsersModalForm = \Drupal::formBuilder()->getForm('Drupal\my_users\Form\RegisterUsersModalForm');

    $build = [
      '#theme' => 'register_users_block',
      '#form_register_users' => $registerUsersForm,
      '#form_register_users_modal' => $registerUsersModalForm,
      '#attached' => [
        'library' => [
          'my_users/my_users',
        ],
      ],
    ];

    return $build;
  }

}
