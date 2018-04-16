<?php

namespace Drupal\google_map\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Google Map' Block.
 *
 * @Block(
 *   id = "google_map_block",
 *   admin_label = @Translation("Google Map block"),
 *   category = @Translation("Google Map block"),
 * )
 */
class GoogleMapBlock extends BlockBase implements BlockPluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function defaultConfiguration()
    {
        $default_config = \Drupal::config('google_map.settings');
        return [
            'width' => $default_config->get('width'),
            'height' => $default_config->get('height'),
            'zoom_level' => $default_config->get('zoom_level'),
            'center_position' => $default_config->get('center_position'),
            'markers' => $default_config->get('markers'),
            'api_key' => $default_config->get('api_key'),
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function build()
    {

        $config = $this->getConfiguration();

        return array(
            '#theme' => 'google_map',
            '#width' => $config['width'],
            '#height' => $config['height'],
            '#attached' => array(
                'library' => array(
                    'google_map/google-map-js',
                ),
                'drupalSettings' => [
                    'zoom' => $config['zoom_level'],
                    'center' => $config['center_position'],
                    'markers' => $config['markers'],
                    'api_key' => $config['api_key'],
                ]
            ),
        );
    }


    /**
     * {@inheritdoc}
     */
    public function blockForm($form, FormStateInterface $form_state)
    {
        $form = parent::blockForm($form, $form_state);
        $config = $this->getConfiguration();
        $form['width'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Width'),
            '#description' => $this->t('Width of your map '),
            '#default_value' => isset($config['width']) ? $config['width'] : '',
        ];
        $form['height'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Height'),
            '#description' => $this->t('Height of google your map '),
            '#default_value' => isset($config['height']) ? $config['height'] : '',
        ];
        $form['zoom_level'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Map Zoom Level'),
            '#default_value' => isset($config['zoom_level']) ? $config['zoom_level'] : '',
        ];

        $form['center_position'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Center Position'),
            '#placeholder' => "latitude,longitude",
            '#description' => $this->t('Use this link to get latitude and longitude <a target="_blank" href="https://www.latlong.net/">https://www.latlong.net/</a>'),
            '#default_value' => isset($config['center_position']) ? $config['center_position'] : '',
        ];


        $form['markers'] = [
            '#type' => 'textarea',
            '#title' => $this->t('Markers'),
            '#placeholder' => "latitude,longitude|latitude,longitude",
            '#description' => $this->t('Use | to separate markers. <br> Use this link to get latitude and longitude <a target="_blank" href="https://www.latlong.net/">https://www.latlong.net/</a>'),
            '#default_value' => isset($config['markers']) ? $config['markers'] : '',
        ];


        return $form;
    }


    /**
     * {@inheritdoc}
     */
    public function blockSubmit($form, FormStateInterface $form_state)
    {
        parent::blockSubmit($form, $form_state);
        $values = $form_state->getValues();
        $this->configuration['width'] = $values['width'];
        $this->configuration['height'] = $values['height'];
        $this->configuration['zoom_level'] = $values['zoom_level'];
        $this->configuration['center_position'] = $values['center_position'];
        $this->configuration['markers'] = $values['markers'];

    }

}