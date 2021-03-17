<?php

namespace Drupal\my_users\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBuilder;
use Drupal\Core\Render\Markup;
use Drupal\my_users\Services\ExportUsersExcelService;
use Drupal\my_users\Services\ShowUsersService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Users Controller.
 */
class UsersController extends ControllerBase {

  /**
   * The form builder.
   *
   * @var \Drupal\Core\Form\FormBuilder
   */
  protected FormBuilder $formBuilder;

  /**
   * Show Users Service.
   *
   * @var \Drupal\my_users\Services\ShowUsersService
   */
  protected ShowUsersService $showUsersService;

  /**
   * Export Users Excel.
   *
   * @var \Drupal\my_users\Services\ExportUsersExcelService
   */
  protected ExportUsersExcelService $exportUsersExcelService;

  /**
   * Constructs a new UsersController.
   *
   * @param \Drupal\Core\Form\FormBuilder $formBuilder
   *   Inject FormBuilder.
   *
   * @param \Drupal\my_users\Services\ShowUsersService $showUsersService
   *   Inject service.
   *
   * @param \Drupal\my_users\Services\ExportUsersExcelService $exportUsersExcelService
   *   Inject service.
   */
  public function __construct(FormBuilder $formBuilder, ShowUsersService $showUsersService, ExportUsersExcelService $exportUsersExcelService) {
    $this->formBuilder = $formBuilder;
    $this->showUsersService = $showUsersService;
    $this->exportUsersExcelService = $exportUsersExcelService;

  }

  /**
   * Method create to dependency injection.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   Param container interface.
   *
   * @return \Drupal\my_users\Controller\UsersController
   *   Return object.
   */
  public static function create(ContainerInterface $container): UsersController {
    return new static(
     $container->get('form_builder'),
     $container->get('my_users.show'),
     $container->get('my_users.export_excel'),
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
   * Method show users.
   *
   * @return array
   *   Return Hello string.
   */
  public function showUsers(): array {

    return $this->showUsersService->renderTable(10);

  }

  /**
   * Method export user sexcel.
   *
   * @return array|\Symfony\Component\HttpFoundation\Response
   *   Return Hello string.
   */
  public function exportUsersExcel() {

    ini_set("auto_detect_line_endings", TRUE);

    $handle = fopen('php://temp', 'w+');

    $header = [
      'Name',
    ];

    fputcsv($handle, $header);

    $names = $this->exportUsersExcelService->csvExport();

    foreach ($names as $name) {

      fputcsv($handle, [$name->name]);
    }

    rewind($handle);

    $csv_data = stream_get_contents($handle);

    fclose($handle);

    $response = new Response();

    $response->headers->set('Content-Type', 'text/csv');
    $response->headers->set('Content-Disposition', 'attachment; filename="my_users.csv"');

    $response->setContent($csv_data);

    return $response;

  }

  /**
   * Mehod Import users csv.
   *
   * @return array
   *   Return Hello string.
   */
  public function importUsersCsv(): array {

    $myForm = $this->formBuilder()->getForm('Drupal\my_users\Form\ImportUsersFromCsvForm');
    $renderer = \Drupal::service('renderer');
    $myFormHtml = $renderer->render($myForm);

    return [
      '#markup' => Markup::create(" {$myFormHtml} "),
    ];

  }

}
