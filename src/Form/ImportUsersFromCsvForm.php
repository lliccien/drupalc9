<?php

namespace Drupal\my_users\Form;

use Drupal\my_users\Services\ImportUsersCsvService;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class Import Users From Csv Form.
 */
class ImportUsersFromCsvForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'import_users_from_csv';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['import_csv'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Import'),
      '#description' => $this->t('Select the .csv file with the information to import'),
      '#upload_location' => 'public://',
      '#upload_validators' => [
        'file_validate_extensions' => ['csv'],
      ],
    ];
    $form['submit_csv'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $batch = [
      'title'            => $this->t('Importing CSV ...'),
      'operations'       => [],
      'init_message'     => $this->t('Commencing'),
      'progress_message' => $this->t('Processed @current out of @total.'),
      'error_message'    => $this->t('An error occurred during processing'),
      'finished'         => '\Drupal\my_users\Batch\DataLoaderImportBatch::csvImportImportFinished',
    ];

    if ($fid = $form_state->getValue('import_csv')) {
      $file = File::load(reset($fid));
      if ($handle = fopen($file->getFileUri(), 'r')) {
        $batch['operations'][] = [
          '\Drupal\my_users\Batch\DataLoaderImportBatch::csvImportRememberFilename',
        [$file],
        ];

        while ($row = fgetcsv($handle, 6500000)) {
          $batch['operations'][] = [
            '\Drupal\my_users\Batch\DataLoaderImportBatch::csvImportImportLine',
            [array_map('base64_encode', $row)],
          ];
        }
        fclose($handle);
      }
    }
    batch_set($batch);
  }

}
