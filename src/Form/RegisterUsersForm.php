<?php

namespace Drupal\my_users\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\my_users\Ajax\OpenModalAjaxCommand;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ResgisterUsersForm.
 */
class RegisterUsersForm extends FormBase {

  /**
   * Drupal\Core\Database\Driver\mysql\Connection definition.
   *
   * @var \Drupal\Core\Database\Driver\mysql\Connection
   */
  protected $database;

  /**
   * Drupal\my_users\Services\RegisterUsersService definition.
   *
   * @var \Drupal\my_users\Services\RegisterUsersService
   */
  protected $myUsersRegister;

  /**
   * The form builder.
   *
   * @var \Drupal\Core\Form\FormBuilder
   */
  protected $formBuilder;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->database = $container->get('database');
    $instance->myUsersRegister = $container->get('my_users.register');
    $instance->formBuilder = $container->get('form_builder');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'register_users_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['my_name'] = [
      '#field_suffix' => '<div class="msg-validation"></div>',
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#description' => $this->t('The name must have a minimum of 5 characters and only uppercase letters are allowed'),
      '#maxlength' => 64,
      '#size' => 64,
      '#required' => TRUE,
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#attributes' => [
        'class' => ['is-disabled'],
        'disabled' => TRUE,
      ],
      '#ajax' => [
        'callback' => '::submitModalFormAjax',
        'progress' => [
          'type' => 'throbber',
          'message' => 'in progress ...',
        ],
      ],
    ];

    return $form;
  }

  /**
   * AJAX callback handler that displays any errors or a success message.
   */
  public function submitModalFormAjax(array $form, FormStateInterface $form_state) {
    $response = new AjaxResponse();

    $name = $form_state->getValues()['my_name'];

    if (strlen($name) <= 5) {
      $msg_strlen = '<label class="error">The name must have a minimum of 5 characters</label>';
      $response->addCommand(new HtmlCommand('.msg-validation', $msg_strlen));
      // $sleep = 5000;
      //      $response->addCommand(new InvokeCommand(NULL, resetForm, [$sleep]));
      return $response;
    }
    if ($this->myUsersRegister->uniqueName($name)) {
      $msg_unique = '<label class="error">The ' . $name . ' is already registered</label>';
      $response->addCommand(new HtmlCommand('.msg-validation', $msg_unique));

      return $response;
    }


    try {
      $userId = $this->myUsersRegister->saveUser($form_state->getValues()['my_name']);
    }
    catch (\Exception $e) {
      \Drupal::messenger()->addMessage('The name could not be saved. Try again');
    }


    if ((!$form_state->hasAnyErrors() || empty($form_state->getErrors())) && !empty($userId)) {
//      $name = $form_state->getValues()['my_name'];
      $response->addCommand(new openModalAjaxCommand($userId, $name));
    }
    return $response;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // $name = $form_state->getValues()['my_name'];
    //
    //    if (strlen($name) <= 5) {
    //      $form_state->setErrorByName('my_name', 'The name must have a minimum of 5 characters');
    //    }
    //    if ($this->myUsersRegister->uniqueName($name)) {
    //      $form_state->setErrorByName('my_name', 'The ' . $name . ' is already registered');
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
