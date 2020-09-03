<?php

namespace Drupal\hex_commerce\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\UserInterface;

/**
 * Implements an example form.
 */
class StoreSettingsForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'hex_commerce_store_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['#title'] = $this->t('Create the main store');

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email address'),
      '#default_value' => '',
      '#description' => $this->t('Fill out the email address for the main store.'),
      '#required' => TRUE,
    ];

    $form['address'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Address'),
      '#description' => $this->t('Fill out the street address.'),
      '#default_value' => '',
      '#required' => TRUE,
      '#maxlength' => UserInterface::USERNAME_MAX_LENGTH,
    ];

    $form['locality'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Locality'),
      '#description' => $this->t('Fill out the locality.'),
      '#default_value' => '',
      '#required' => TRUE,
      '#maxlength' => UserInterface::USERNAME_MAX_LENGTH,
    ];

    $form['state'] = [
      '#type' => 'textfield',
      '#title' => $this->t('State'),
      '#description' => $this->t('Fill out the state.'),
      '#default_value' => '',
      '#required' => TRUE,
      '#maxlength' => UserInterface::USERNAME_MAX_LENGTH,
    ];

    $form['postal_code'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Postal code'),
      '#description' => $this->t('Fill out the postal code.'),
      '#default_value' => '',
      '#required' => TRUE,
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
    if (strlen($form_state->getValue('state')) > 2) {
      $form_state->setErrorByName('state', $this->t('The state is too long. Please use the abbreviation.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $address = [
      'country_code' => 'US',
      'address_line1' => $form_state->getValue('address'),
      'locality' => $form_state->getValue('locality'),
      'administrative_area' => $form_state->getValue('state'),
      'postal_code' => $form_state->getValue('postal_code'),
    ];

    $currency = 'USD';

    // If needed, this will import the currency.
    $currency_importer = \Drupal::service('commerce_price.currency_importer');
    $currency_importer->import($currency);

    $store = \Drupal\commerce_store\Entity\Store::create([
      'type' => 'custom_store_type',
      'uid' => 1,
      'name' => 'Main',
      'mail' => $form_state->getValue('email'),
      'address' => $address,
      'default_currency' => $currency,
      'billing_countries' => ['BR'],
    ]);
    $store->save();

    // If needed, this sets the store as the default store.
    $store_storage = \Drupal::service('entity_type.manager')->getStorage('commerce_store');
    $store_storage->markAsDefault($store);
  }

}
