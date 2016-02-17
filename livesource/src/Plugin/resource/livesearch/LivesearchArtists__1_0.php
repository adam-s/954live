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
 * Class LivesearchArtists__1_0
 * @package Drupal\livesource\Plugin\resource\livesearch
 *
 * @Resource(
 *   name = "livesearchArtists:1.0",
 *   resource = "livesearchArtists",
 *   label = "Livesearch Artists",
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
 *   minorVersion = 0
 * )
 */

class LivesearchArtists__1_0 extends ResourceNode {
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

        $public_fields['social'] = array(
            'property' => 'field_social',
            'process_callbacks' => array(
                array($this, 'socialProcess'),
            ),
        );

        $public_fields['image'] = array(
            'property' => 'field_image',
            'process_callbacks' => array(
                array($this, 'imageProcess'),
            ),
        );

        $public_fields['youtube'] = array(
            'property' => 'field_youtube',
            'process_callbacks' => array(
                array( $this, 'youtubeProcess'),
            ),
        );

        $public_fields['about'] = array(
            'property' => 'field_about',
        );

        $public_fields['genres'] = array(
            'property' => 'field_genres',
            'process_callbacks' => array(
                array($this, 'genresProcess'),
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
    public function youtubeProcess($youtube) {
        return  $youtube[0]['video_id'];
    }

    public function uriProcess ($entity) {
        $uri =  entity_uri('node', $entity);
        $path =  drupal_get_path_alias($uri['path']);
        return url($path);
    }

    public function imageProcess($image) {
        return image_style_url('xl', $image['uri']);
    }

    public function socialProcess($social) {
        $social_field = variable_get('socialfield_services');
        $element = array();
        foreach($social as $service) {
            $element[] = array(
                'service' => $service['service'],
                'url' => $service['url'],
                'name' => $social_field[$service['service']]['name'],
            );
        }

        return $element;
    }

    public function genresProcess($tids) {
        $genres = taxonomy_term_load_multiple($tids);
        if (empty($genres)) {
            return NULL;
        }
        $element = [];
        foreach ($genres as $genre) {
            $path = entity_uri('taxonomy_term', $genre);
            $element[] = array(
                'name' => entity_label('taxonomy_term', $genre),
                'path' => url($path['path'], $path['options']),
            );
        }
        return $element;
    }
}