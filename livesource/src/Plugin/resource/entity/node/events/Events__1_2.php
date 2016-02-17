<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 1/18/16
 * Time: 7:46 AM
 */

namespace Drupal\livesource\Plugin\resource\entity\node\events;

use Drupal\restful\Plugin\resource\ResourceInterface;
use Drupal\restful\Plugin\resource\ResourceNode;

/**
 * Class Events__1_2
 * @package Drupal\livesource\src\Plugin\resource\entity\node\events
 *
 * @Resource(
 *   name = "events:1.2",
 *   resource = "events",
 *   label = "Events",
 *   description = "Export the events with all authentication providers.",
 *   authenticationTypes = TRUE,
 *   authenticationOptional = TRUE,
 *   dataProvider = {
 *     "entityType": "node",
 *     "bundles": {
 *       "events"
 *     },
 *   },
 *   majorVersion = 1,
 *   minorVersion = 2
 * )
 */
class Events__1_2 extends ResourceNode implements ResourceInterface{
    /**
     * {@inheritdoc
     */
    protected function publicFields() {
        $public_fields = parent::publicFields();

        $public_fields['id']['methods'] = array();

        // Rename label to name;
        $public_fields['title'] = $public_fields['label'];
        unset($public_fields['label']);
        unset($public_fields['self']);
        unset($public_fields['links']);

        $public_fields['venue'] = array(
            'property' => 'field_venue',
            'resource' => array(
                'name' => 'venues',
                'full_view' => TRUE,
                'majorVersion' => '1',
                'minorVersion' => '2'
            )
        );

        $public_fields['artists'] = array(
            'property' => 'field_artists',
            'resource' => array(
                'name' => 'artists',
                'majorVersion' => '1',
                'minorVersion' => '2'
            )
        );

        return $public_fields;
    }
}