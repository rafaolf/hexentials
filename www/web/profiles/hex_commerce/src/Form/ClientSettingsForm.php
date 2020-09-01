<?php

namespace Drupal\hex_commerce\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use Drupal\user\UserInterface;

/**
 * Implements an example form.
 */
class ClientSettingsForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'hex_commerce_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['#title'] = $this->t('Configure client preferences');

    $form['image'] = [
      '#type' => 'managed_file',
      '#title' => t('Company\'s logo.'),
      // '#default_value' => theme_get_setting('custom_logo'),
      '#progress_indicator' => 'bar',
      '#progress_message'   => t('Please wait...'),
      '#upload_location' => 'public://',
      '#upload_validators'  => [
        'file_validate_extensions' => ['gif png jpg jpeg'],
      ],
    ];

    $form['slogan'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Slogan'),
      '#description' => $this->t('Slogan to display for the users.'),
      '#default_value' => '',
      '#required' => FALSE,
      '#maxlength' => UserInterface::USERNAME_MAX_LENGTH,
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email address'),
      '#default_value' => '',
      '#description' => $this->t('E-mail address to display for the users.'),
      '#required' => TRUE,
    ];

    $form['phone_number'] = [
      '#type' => 'tel',
      '#title' => $this->t('Phone number'),
      '#description' => $this->t('Phone number to display for the users.'),
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (strlen($form_state->getValue('phone_number')) < 3) {
      $form_state->setErrorByName('phone_number', $this->t('The phone number is too short. Please enter a full phone number.'));
    }

    // @TODO: check if this error validation is needed.
    // if ($error = user_validate_name($form_state->getValue(['account', 'name']))) {
    //   $form_state->setErrorByName('account][name', $error);
    // }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    if ($file_id = $form_state->getValue(['image', '0'])) {
      $file = File::load($file_id);
      $file->setPermanent();
      $file->save();

      \Drupal::configFactory()->getEditable('flexi_cart.settings')
        ->set('logo.use_default', FALSE)
        ->set('logo.path', (string) $file->getFileUri())
        ->save();
    }

    $this->updateConfiguration($form_state);
  }

  /**
   * Update the configuration values per installation data.
   */
  public function updateConfiguration(FormStateInterface $form_state) {
    \Drupal::configFactory()->getEditable('system.site')->set('slogan', (string) $form_state->getValue('slogan'));

    \Drupal::configFactory()
      ->getEditable('flexi_cart.settings')
      ->set('header_email', (string) $form_state->getValue('email'))
      ->set('header_phone', (string) $form_state->getValue('phone_number'))
      ->save();
  }

}
