<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 1/18/16
 * Time: 8:19 PM
 *
 * Maps to ArtistStyle
 */

namespace Drupal\livesource\Plugin\resource\livesearch;

use Drupal\restful\Plugin\resource\ResourceNode;

/**
 * Class Livesearch__1_0
 * @package Drupal\livesource\Plugin\resource\livesearch
 *
 * @Resource(
 *   name = "livesearch:1.0",
 *   resource = "livesearch",
 *   label = "Livesearch",
 *   description = "Export the artists with all authentication providers.",
 *   authenticationTypes = TRUE,
 *   authenticationOptional = TRUE,
 *   dataProvider = {
 *     "entityType": "node",
 *     "bundles": {
 *       "artists",
 *       "venues"
 *     },
 *   },
 *   majorVersion = 1,
 *   minorVersion = 0
 * )
 */

class Livesearch__1_0 extends ResourceNode {

    /**
     * {@inheritdoc
     */
    protected function publicFields() {

        $public_fields = parent::publicFields();
        $public_fields['name'] = $public_fields['label'];
        unset($public_fields['label']);

        $public_fields['bundle'] = array(
            'wrapper_method' => 'getBundle',
            'wrapper_method_on_entity' => TRUE,
        );

        $public_fields['image'] = array(

        );

        $public_fields['image'] = array(
            'property' => 'field_image',
            'process_callbacks' => array(
                array($this, 'imageUrl'),
            ),
        );

        return $public_fields;
    }

    public function imageUrl($image) {
        return image_style_url('micronail', $image['uri']);
    }
}