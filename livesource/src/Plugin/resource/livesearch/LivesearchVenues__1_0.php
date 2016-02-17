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
 * Class LivesearchVenue__1_0
 * @package Drupal\livesource\Plugin\resource\livesearch
 *
 * @Resource(
 *   name = "livesearchVenues:1.0",
 *   resource = "livesearchVenues",
 *   label = "Livesearch Venues",
 *   description = "Export the artists with all authentication providers.",
 *   authenticationTypes = TRUE,
 *   authenticationOptional = TRUE,
 *   dataProvider = {
 *     "entityType": "node",
 *     "bundles": {
 *       "venues"
 *     },
 *   },
 *   majorVersion = 1,
 *   minorVersion = 0
 * )
 */

class LivesearchVenues__1_0 extends ResourceNode {

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

        $public_fields['address'] = array(
            'property' => 'field_address',
        );

        $public_fields['image'] = array(
            'property' => 'field_image',
            'process_callbacks' => array(
                array($this, 'imageUrl'),
            ),
        );

        $public_fields['map'] = array(
            'property' => 'field_geo',
            'process_callbacks' => array(
                array($this, 'mapProcess')
            )
        );

        $public_fields['mapLink'] = array(
            'wrapper_method' => 'label',
            'wrapper_method_on_entity' => TRUE,
            'process_callbacks' => array(
                array($this, 'mapLinkProcess'),
            ) ,
        );

        $public_fields['url'] = array(
            'wrapper_method' => 'value',
            'wrapper_method_on_entity' => TRUE,
            'process_callbacks' => array(
                array($this, 'uriProcess'),
            ),
        );

        $public_fields['phone'] = array(
            'property' => 'field_phone',
        );

        $public_fields['social'] = array(
            'property' => 'field_social',
            'process_callbacks' => array(
                array($this, 'socialProcess'),
            ),
        );

        return $public_fields;
    }

    public function mapLinkProcess($label) {
        return "https://maps.google.com/?q=" . rawurlencode($label);
    }

    public function imageUrl($image) {
        return image_style_url('xl', $image['uri']);
    }

    public function uriProcess ($entity) {
        $uri =  entity_uri('node', $entity);
        $path =  drupal_get_path_alias($uri['path']);
        return url($path);
    }

    public function socialProcess($social) {
        $social_field = variable_get('socialfield_services');
        $element = array();
        foreach($social as $service) {
            if ($service['service'] == 'website') {
                $element = array(
                    'service' => $service['service'],
                    'url' => $service['url'],
                    'name' => $social_field[$service['service']]['name'],
                );
            }
        }

        return $element;
    }

    public function mapProcess($geo) {
        $map = 'https://maps.googleapis.com/maps/api/staticmap?';
        $map .= 'center=' . $geo['lat'] . ',' . $geo['lon'];
        $map .= '&zoom=13';
        $map .= '&size=400x300';
        $map .= '&maptype=roadmap';
        $map .= '&markers=color:0x701650|' . $geo['lat'] . ',' . $geo['lon'];
        $map .= '&style=feature:all|element:labels.text.fill|color:0xffffff';
        $map .= '&style=feature:all|element:labels.text.stroke|color:0x000000|lightness:13';
        $map .= '&style=feature:administrative|element:geometry.fill|color:0x000000';
        $map .= '&style=feature:administrative|element:geometry.stroke|color:0x144b53|lightness:14|weight:1.4';
        $map .= '&style=feature:landscape|element:all|color:0x08304b';
        $map .= '&style=feature:poi|element:geometry|color:0x0c4152|lightness:5';
        $map .= '&style=feature:road.highway|geometry.fill|color:0x000000';
        $map .= '&style=feature:road.highway|element:geometry.stroke|color:0x0b434f';
        $map .= '&style=feature:road.arterial|geometry.fill|color:0x000000';
        $map .= '&style=feature:road.arterial|geometry.stroke|color:0x0b3d51|lightness:16';
        $map .= '&style=feature:road.local|element:geometry|color:0x000000';
        $map .= '&style=feature:transit|element:all|color:0x146474';
        $map .= '&style=feature:water|element:all|color:0x021019';
        $map .= '&key=AIzaSyD7eKp9vZ3qRRyttawSrx4zdKkFn-YolE8';
        return $map;
    }
}