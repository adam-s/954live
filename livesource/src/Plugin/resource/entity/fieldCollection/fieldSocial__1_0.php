<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 1/23/16
 * Time: 1:00 PM
 */

namespace Drupal\livesource\Plugin\resource\entity\fieldCollection;

use Drupal\restful\Plugin\resource\ResourceEntity;

/**
 * Class fieldSocial__1_0
 * @package Drupal\livesource\Plugin\resource\entity\fieldCollection
 *
 * @Resource(
 *   name = "fieldSocial:1.0",
 *   resource = "fieldSocial",
 *   label = "field_social",
 *   description = "Export the field_social with all authentication providers.",
 *   authenticationTypes = TRUE,
 *   authenticationOptional = TRUE,
 *   dataProvider = {
 *     "entityType": "field_collection_item",
 *     "bundles": {
 *       "field_test"
 *     },
 *   },
 *   majorVersion = 1,
 *   minorVersion = 0
 * )
 */

class fieldSocial__1_0 extends ResourceEntity {
    protected function publicFields() {
        $public_fields = parent::publicFields();

        $public_fields['link'] = array(
            'property' => 'field_social_link'
        );

        $public_fields['social_service'] = array(
            'property' => 'field_social_service'
        );

        return $public_fields;
    }
}