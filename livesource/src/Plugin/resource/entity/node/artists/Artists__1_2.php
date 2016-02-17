<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 1/18/16
 * Time: 8:19 PM
 */

namespace Drupal\livesource\Plugin\resource\entity\node\artists;

use Drupal\restful\Plugin\resource\ResourceNode;

/**
 * Class Artist__1_2
 * @package Drupal\livesource\Plugin\resource\entity\node\artists
 *
 * @Resource(
 *   name = "artists:1.2",
 *   resource = "artists",
 *   label = "Artists",
 *   description = "Export the artists with all authentication providers.",
 *   authenticationTypes = TRUE,
 *   authenticationOptional = TRUE,
 *   dataProvider = {
 *     "entityType": "node",
 *     "bundles": {
 *       "artists"
 *     },
 *   },
 *   majorVersion = 1,
 *   minorVersion = 2
 * )
 */
 
class Artists__1_2 extends ResourceNode {

    /**
     * {@inheritdoc
     */
    protected function publicFields() {

        $public_fields = parent::publicFields();
        $public_fields['name'] = $public_fields['label'];
        unset($public_fields['label']);

        $public_fields['social'] = array(
            'property' => 'field_social',
            'formatter' => 'socialfield_formatter',
        );

        $public_fields['image'] = array(
            'property' => 'field_image',
            'process_callbacks' => array(
                array($this, 'renderImage'),
            ),
        );

        $public_fields['youtube'] = array(
            'property' => 'field_youtube'
        );

        $public_fields['about'] = array(
            'property' => 'field_about',
        );

        $public_fields['genres'] = array(
            'property' => 'field_genres',
            'formatter' => 'term_term'
        );

        return $public_fields;
    }

    public function renderImage($image) {
        $variables = array();

        $variables['style_name'] = 'xl';
        $variables['path'] = $image['uri'];


        return theme('image_style', $variables);
    }

    public function formatGenres($genres) {
        $element = array();
        foreach($genres as $delta => $resource) {
            $wrapper = $resource->getInterpreter()->getWrapper();
            $uri = entity_uri('taxonomy_term', $wrapper->value());

            $element[$delta] = array(
                '#type' => 'link',
                '#title' => $wrapper->name->value(),
                '#href' => $uri['path'],
                '#options' => $uri['options'],
            );

        }

        return drupal_render($element);
    }

}