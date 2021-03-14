<?php

namespace Drupal\my_users\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'RegisterUsersBlock' block.
 *
 * @Block(
 *  id = "register_users_block",
 *  admin_label = @Translation("Register users block"),
 * )
 */
class RegisterUsersBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\webprofiler\Form\FormBuilderWrapper definition.
   *
   * @var \Drupal\webprofiler\Form\FormBuilderWrapper
   */
  protected $formBuilder;

  /**
   * Drupal\my_users\Services\RegisterUsersService definition.
   *
   * @var \Drupal\my_users\Services\RegisterUsersService
   */
  protected $myUsersRegister;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $instance = new static($configuration, $plugin_id, $plugin_definition);
    $instance->formBuilder = $container->get('form_builder');
    $instance->myUsersRegister = $container->get('my_users.register');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];

    $registerUsersForm = $this->formBuilder->getForm('Drupal\my_users\Form\RegisterUsersForm');
    $registerUsersModalForm = $this->formBuilder->getForm('Drupal\my_users\Form\RegisterUsersModalForm');

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
