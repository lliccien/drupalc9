<?php

namespace Drupal\my_users\Controller;

// Use Drupal\my_users\Form\RegisterUserForm;.
use Drupal\block\Entity\Block;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBuilder;
use Drupal\my_users\Services\RegisterUsersService;
use Drupal\my_users\Services\ShowUsersService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class UsersController.
 */
class UsersController extends ControllerBase {

  /**
   * The form builder.
   *
   * @var \Drupal\Core\Form\FormBuilder
   */
  protected $formBuilder;

  /**
   * Show Users Service.
   *
   * @var \Drupal\my_users\Services\ShowUsersService
   */
  protected ShowUsersService $showUsersService;

  protected $registerUsersService;

  /**
   * Constructs a new UsersController.
   *
   * @param \Drupal\my_users\Controller\FormBuilder $formBuilder
   *   Inject FormBuilder.
   *
   * @param \Drupal\my_users\Services\ShowUsersService $showUsersService
   *   Inject service.
   */
  public function __construct(FormBuilder $formBuilder, ShowUsersService $showUsersService, RegisterUsersService $registerUsersService) {
    $this->formBuilder = $formBuilder;
    $this->showUsersService = $showUsersService;
    $this->registerUsersService = $registerUsersService;

  }

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   Param container interface.
   *
   * @return \Drupal\my_users\Controller\UsersController
   *   Return object.
   */
  public static function create(ContainerInterface $container): UsersController {
    // $showUsersService = $container->get('my_users.show');
    //    $formBuilder = $container->get('form_builder');
    return new static(
     $container->get('form_builder'),
     $container->get('my_users.show'),
      $container->get('my_users.register'),
    );
  }

  /**
   * Registerusers.
   *
   * @return array
   *   Return Hello string.
   */
  public function registerUsers(): array {

    $block_manager = \Drupal::service('plugin.manager.block');
    $plugin_block = $block_manager->createInstance('register_users_block');

    $block_render_array = [
      '#theme' => 'block',
      '#attributes' => [],
      '#configuration' => $plugin_block->getConfiguration(),
      '#plugin_id' => $plugin_block->getPluginId(),
      '#base_plugin_id' => $plugin_block->getBaseId(),
      '#derivative_plugin_id' => $plugin_block->getDerivativeId(),
      '#attached' => [
        'library' => [
          'my_users/my_users',
        ],
      ],
    ];

    $block_render_array['content'] = $plugin_block->build();
    return $block_render_array;

  }

  /**
   * Showusers.
   *
   * @return array
   *   Return Hello string.
   */
  public function showUsers(): array {

    return $this->showUsersService->renderTable(2);

  }

  /**
   * Exportusersexcel.
   *
   * @return array
   *   Return Hello string.
   */
  public function exportUsersExcel(): array {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: exportUsersExcel'),
    ];
  }

  /**
   * Importuserscsv.
   *
   * @return array
   *   Return Hello string.
   */
  public function importUsersCsv(): array {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: importUsersCsv'),
    ];
  }

}
