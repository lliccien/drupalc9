<?php

namespace Drupal\my_users\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class RegisterUsersModalForm.
 */
class RegisterUsersModalForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'register_users_modal_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['button'] = [
      '#type' => 'button',
      '#value' => $this->t('Close'),
      '#attributes' => [
        'class' => [
          'btn btn-secondary',
        ],
        ' data-dismiss' => 'modal',
      ],
      '#prefix' => '<div class="modal-footer">',
      '#suffix' => '</div>',
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
  }

}
