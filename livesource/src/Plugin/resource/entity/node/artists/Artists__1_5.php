<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 1/18/16
 * Time: 8:19 PM
 *
 */

namespace Drupal\livesource\Plugin\resource\entity\node\artists;

use Drupal\restful\Plugin\resource\ResourceNode;

/**
 * Class Artist__1_5
 * @package Drupal\livesource\Plugin\resource\entity\node\artists
 *
 * @Resource(
 *   name = "artists:1.5",
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
 *   minorVersion = 5
 * )
 */
 
class Artists__1_5 extends ResourceNode {

    /**
     * {@inheritdoc
     */
    protected function publicFields() {

        $public_fields = parent::publicFields();
        $public_fields['name'] = $public_fields['label'];
        unset($public_fields['label']);

        $public_fields['social'] = array(
            'property' => 'field_social',
        );

        $public_fields['image'] = array(
            'property' => 'field_image',
        );

        $public_fields['youtube'] = array(
            'property' => 'field_youtube',
        );

        $public_fields['about'] = array(
            'property' => 'field_about',
        );

        $public_fields['genres'] = array(
            'property' => 'field_genres',
            'resource' => array(
                'name' => 'genres',
                'majorVersion' => 1,
                'minorVersion' => 0,
            ),
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