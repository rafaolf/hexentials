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
   * Maximum length of username text field.
   *
   * Keep this under 191 characters so we can use a unique constraint in MySQL.
   */
  const ADDRESS_MAX_LENGTH = 120;

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'hex_commerce_client_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form_state->disableCache();
    $form['#title'] = $this->t('Configure client preferences');

    // @TODO: image not working due to an AJAX issue.
    // $form['image'] = [
      // '#type' => 'managed_file',
      // '#title' => t('Company logo.'),
      // '#default_value' => theme_get_setting('image'),
      // 'data-lazy' => TRUE,
      // '#progress_indicator' => 'bar',
      // '#progress_message'   => t('Please wait...'),
      // '#upload_location' => 'public://',
      // '#upload_validators'  => [
        // 'file_validate_extensions' => ['gif png jpg jpeg'],
      // ],
    // ];

    $form['slogan'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Slogan'),
      '#description' => $this->t('Slogan to display for the users.'),
      '#default_value' => t('The best products for your needs.'),
      '#required' => FALSE,
      '#maxlength' => self::ADDRESS_MAX_LENGTH,
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email address'),
      '#default_value' => 'oliveirafrafa@gmail.com',
      '#description' => $this->t('E-mail address to display for the users.'),
      '#required' => TRUE,
    ];

    $form['phone_number'] = [
      '#type' => 'tel',
      '#title' => $this->t('Phone number'),
      '#description' => $this->t('Phone number to display for the users.'),
      '#default_value' => '+55 (19) 1111-1111',
      // @TOdo; keep this commented out while we don't have a functionality to
      // auto-fill the special characters.
      // '#pattern' => '\(\d{2,}\) \d{4,}\-\d{4}',
    ];

    $form['phone_whatsapp'] = [
      '#type' => 'tel',
      '#title' => $this->t('Phone number - WhatsApp'),
      '#description' => $this->t('WhatsApp phone number to display for the users.'),
      '#default_value' => '+55 (19) 22222-2222',
    ];

    $form['address'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Address'),
      '#description' => $this->t('Address to display for the users.'),
      '#default_value' => 'John Doe - 123 Main St. - City/State',
      '#required' => FALSE,
      '#maxlength' => UserInterface::USERNAME_MAX_LENGTH,
    ];

    $form['facebook'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Facebook'),
      '#description' => $this->t('Facebook to display for the users.'),
      '#default_value' => 'https://www.facebook.com/',
      '#required' => FALSE,
      '#maxlength' => UserInterface::USERNAME_MAX_LENGTH,
    ];

    $form['twitter'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Twitter'),
      '#description' => $this->t('Twitter to display for the users.'),
      '#default_value' => 'https://www.twitter.com/',
      '#required' => FALSE,
      '#maxlength' => UserInterface::USERNAME_MAX_LENGTH,
    ];

    $form['linkedin'] = [
      '#type' => 'textfield',
      '#title' => $this->t('LinkedIn'),
      '#description' => $this->t('LinkedIn to display for the users.'),
      '#default_value' => 'https://www.linkedin.com/',
      '#required' => FALSE,
      '#maxlength' => UserInterface::USERNAME_MAX_LENGTH,
    ];

    $form['instagram'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Instagram'),
      '#description' => $this->t('Instagram to display for the users.'),
      '#default_value' => 'https://www.instagram.com/',
      '#required' => FALSE,
      '#maxlength' => UserInterface::USERNAME_MAX_LENGTH,
    ];

    $form['copyrights'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Copyrights'),
      '#description' => $this->t('Copyrights to display for the users.'),
      '#default_value' => t('© Copyright 2020 - Company name here'),
      '#required' => FALSE,
      '#maxlength' => UserInterface::USERNAME_MAX_LENGTH,
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
    $message = $this->t('The phone number is too short. Please enter a full phone number.');

    if (strlen($form_state->getValue('phone_number')) < 8) {
      $form_state->setErrorByName('phone_number', $message);
    }

    if (strlen($form_state->getValue('phone_whatsapp')) < 8) {
      $form_state->setErrorByName('phone_whatsapp', $message);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    if ($file_id = $form_state->getValue(['image', '0'])) {
      $file = File::load($file_id);
      $file->setPermanent();
      $file->save();

      \Drupal::configFactory()->getEditable('hex.settings')
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
    \Drupal::configFactory()->getEditable('system.site')->set('slogan', (string) $form_state->getValue('slogan'))->save();

    \Drupal::configFactory()
      ->getEditable('hex.settings')
      ->set('address', (string) $form_state->getValue('address'))
      ->set('phone', (string) $form_state->getValue('phone_number'))
      ->set('phone_whatsapp', (string) $form_state->getValue('phone_whatsapp'))
      ->set('email', (string) $form_state->getValue('email'))
      ->set('facebook', (string) $form_state->getValue('facebook'))
      ->set('twitter', (string) $form_state->getValue('twitter'))
      ->set('linkedin', (string) $form_state->getValue('linkedin'))
      ->set('instagram', (string) $form_state->getValue('instagram'))
      ->set('copyrights', (string) $form_state->getValue('copyrights'))
      ->set('slideshow_display', 1)
      ->set('slide_title_1', $this->t('What we do'))
      ->set('slide_title_2', $this->t('Who we are'))
      ->set('slide_title_3', $this->t('Our service'))
      ->set('slide_title_4', $this->t('Our mission'))
      ->set('slide_title_5', $this->t('Our vision'))
      ->set('slide_desc_1', $this->t('This is the first slide description to display what we do'))
      ->set('slide_desc_2', $this->t('This is the second slide description to display who we are'))
      ->set('slide_desc_3', $this->t('This is the third slide description to display our service'))
      ->set('slide_desc_4', $this->t('This is the fourth slide description to display our mission'))
      ->set('slide_desc_5', $this->t('This is the fourth slide description to display our vision'))
      ->set('slide_button_text_1', $this->t('More'))
      ->set('slide_button_text_2', $this->t('More'))
      ->set('slide_button_text_3', $this->t('More'))
      ->set('slide_button_text_4', $this->t('More'))
      ->set('slide_button_text_5', $this->t('More'))
      ->save();
  }

}
