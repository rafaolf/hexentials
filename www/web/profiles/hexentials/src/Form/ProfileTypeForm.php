<?php

namespace Drupal\hexentials\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use Drupal\user\UserInterface;

/**
 * Implements an example form.
 */
class ProfileTypeForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'hexentials_profile_type_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form_state->disableCache();
    $form['#title'] = $this->t('Select the profile type');

    $form['profile_type'] = [
      '#type' => 'radios',
      '#title' => t('Select the profile type'),
      '#description' => t('This option will determine which way to proceed during the installation.'),
      '#options' => [
        'brochure' => t('Brochure'),
        'commerce' => t('Commerce'),
      ],
      '#default_value' => 'commerce',
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
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $profile_type = (string) $form_state->getValue('profile_type');

    \Drupal::state()->set('profile_type', $profile_type);
    \Drupal::configFactory()->getEditable('hex.settings')->set('profile_type', $profile_type)->save();
  }

}
