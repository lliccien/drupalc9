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
//        'onClick' => ' $("#register-users-form").reset();',
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
//    foreach ($form_state->getValues() as $key => $value) {
//      // @todo Validate fields.
//    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
    //    foreach ($form_state->getValues() as $key => $value) {
    //      \Drupal::messenger()->addMessage($key . ': ' . ($key === 'text_format'?$value['value']:$value));
    //    }.
  }

}
