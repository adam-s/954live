<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 1/18/16
 * Time: 8:19 PM
 *
 * Maps to DefaultStyle (aka front page)
 */

namespace Drupal\livesource\Plugin\resource\entity\node\artists;

use Drupal\restful\Plugin\resource\ResourceNode;

/**
 * Class Artist__1_1
 * @package Drupal\livesource\Plugin\resource\entity\node\artists
 *
 * @Resource(
 *   name = "artists:1.1",
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
 *   renderCache = {
 *     "render": false
 *   },
 *   majorVersion = 1,
 *   minorVersion = 1
 * )
 */

class Artists__1_1 extends ResourceNode {

    /**
     * {@inheritdoc
     */
    protected function publicFields() {

        $public_fields = parent::publicFields();
        $public_fields['name'] = $public_fields['label'];
        unset($public_fields['label']);

        $public_fields['image'] = array(
            'property' => 'field_image',
            'process_callbacks' => array(
                array($this, 'renderImage'),
            ),
        );

        $public_fields['youtube'] = array(
            'property' => 'field_youtube'
        );

        $public_fields['genres'] = array(
            'property' => 'field_genres'
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