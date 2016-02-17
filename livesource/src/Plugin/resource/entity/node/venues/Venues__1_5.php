<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 1/18/16
 * Time: 9:40 PM
 *
 * Maps to VenueStyle
 */

namespace Drupal\livesource\Plugin\resource\entity\node\venues;

use Drupal\restful\Plugin\resource\ResourceNode;

/**
 * Class Venues__1_5
 * @package Drupal\livesource\Plugin\resource\entity\node\venues
 * 
 * @Resource(
 *   name = "venues:1.5",
 *   resource = "venues",
 *   label = "Venues",
 *   description = "Export the venues with all authentication providers.",
 *   authenticationTypes = TRUE,
 *   authenticationOptional = TRUE,
 *   dataProvider = {
 *     "entityType": "node",
 *     "bundles": {
 *       "venues"
 *     },
 *   },
 *   majorVersion = 1,
 *   minorVersion = 5
 * )
 */

class Venues__1_5 extends ResourceNode {

    /**
     * {@inheritdoc}
     */
    protected function publicFields() {

        $public_fields = parent::publicFields();
        $public_fields['name'] = $public_fields['label'];
        unset($public_fields['label']);

        $public_fields['image'] = array(
            'property' => 'field_image',
        );

        $public_fields['phone'] = array(
            'property' => 'field_phone',
        );

        $public_fields['address'] = array(
            'property' => 'field_address',
        );

        $public_fields['location'] = array(
            'property' => 'field_address',
        );

        $public_fields['geo'] = array(
            'property' => 'field_geo',
        );

        $public_fields['social'] = array(
            'property' => 'field_social',
        );

        $public_fields['about'] = array(
            'property' => 'field_about'
        );

        $public_fields['url'] = array(
            'wrapper_method' => 'value',
            'wrapper_method_on_entity' => TRUE,
            'process_callbacks' => array(
                array($this, 'uriProcess'),
            ),
        );

        return $public_fields;
    }

    public function uriProcess ($entity) {
        $uri =  entity_uri('node', $entity);
        $path =  drupal_get_path_alias($uri['path']);
        return url($path);
    }
}
