<?php

namespace Drupal\my_users\Batch;

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\File\FileSystemInterface;

/**
 * Methods for running the CSV import in a batch.
 */
class DataLoaderImportBatch {

  /**
   * Handle batch completion.
   *
   *   Creates a new CSV file containing all failed rows if any.
   */
  public static function csvImportImportFinished($success, $results, $operations): TranslatableMarkup {

    $messenger = \Drupal::messenger();

    if (!empty($results['failed_rows'])) {

      $dir = 'public://';
      if (\Drupal::service('file_system')
        ->prepareDirectory($dir, FileSystemInterface::CREATE_DIRECTORY)) {

        $csv_filename = 'failed_rows-' . basename($results['uploaded_filename']);
        $csv_filepath = $dir . '/' . $csv_filename;

        $targs = [
          ':csv_url'      => file_create_url($csv_filepath),
          '@csv_filename' => $csv_filename,
          '@csv_filepath' => $csv_filepath,
        ];

        if ($handle = fopen($csv_filepath, 'w+')) {

          foreach ($results['failed_rows'] as $failed_row) {
            fputcsv($handle, $failed_row);
          }

          fclose($handle);
          $messenger->addMessage(t('Some rows failed to import. You may download a CSV of these rows: <a href=":csv_url">@csv_filename</a>', $targs), 'error');
        }
        else {
          $messenger->addMessage(t('Some rows failed to import, but unable to write error CSV to @csv_filepath', $targs), 'error');
        }
      }
      else {
        $messenger->addMessage(t('Some rows failed to import, but unable to create directory for error CSV at @csv_directory', $targs), 'error');
      }
    }

    return t('The CSV import has completed.');
  }

  /**
   * Remember the uploaded CSV filename.
   *
   * @todo Is there a better way to pass a value from inception of the batch to
   * the finished function?
   */
  public static function csvImportRememberFilename($filename, &$context) {

    $context['results']['uploaded_filename'] = $filename->getFilename;
  }

  /**
   * Process a single line.
   */
  public static function csvImportImportLine($line, &$context) {

    $context['results']['rows_imported']++;
    $line = array_map('base64_decode', $line);

    $context['message'] = t('Importing row !c', ['!c' => $context['results']['rows_imported']]);

    $context['message'] = t('Importing %title', ['%title' => $line[2]]);

    if ($context['results']['rows_imported'] > 1) {

      \Drupal::database()->insert('myusers')
        ->fields(['name'])
        ->values(['name' => $line[0]])
        ->execute();

    }

    if ($line[1] == 'ROW' && $line[2] == 'FAILS') {
      $context['results']['failed_rows'][] = $line;
    }
  }

}
