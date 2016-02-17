<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 1/18/16
 * Time: 8:19 PM
 *
 * Maps to ArtistStyle
 */

namespace Drupal\livesource\Plugin\resource\entity\node\artists;

use Drupal\restful\Plugin\resource\ResourceNode;

/**
 * Class Artist__1_6
 * @package Drupal\livesource\Plugin\resource\entity\node\artists
 *
 * @Resource(
 *   name = "artists:1.6",
 *   resource = "artists",
 *   label = "Artists",
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
 *   minorVersion = 6
 * )
 */
 
class Artists__1_6 extends ResourceNode {

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

        return $public_fields;
    }
}