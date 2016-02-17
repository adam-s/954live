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

use Drupal\restful\Plugin\resource\ResourceEntity;

/**
 * Class LivesearchGenres__1_0
 * @package Drupal\livesource\Plugin\resource\livesearch
 *
 * @Resource(
 *   name = "livesearchGenres:1.0",
 *   resource = "livesearchGenres",
 *   label = "Livesearch Genres",
 *   description = "Export the artists with all authentication providers.",
 *   authenticationTypes = TRUE,
 *   authenticationOptional = TRUE,
 *   dataProvider = {
 *     "entityType": "taxonomy_term",
 *     "bundles": {
 *       "genres"
 *     },
 *   },
 *   majorVersion = 1,
 *   minorVersion = 0
 * )
 */

class LivesearchGenres__1_0 extends ResourceEntity {
    /**
     * {@inheritdoc
     */
    protected function publicFields() {

        $public_fields = parent::publicFields();
        $public_fields['name'] = $public_fields['label'];
        unset($public_fields['label']);

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
        $uri =  entity_uri('taxonomy_term', $entity);
        $path =  drupal_get_path_alias($uri['path']);
        return url($path);
    }

}