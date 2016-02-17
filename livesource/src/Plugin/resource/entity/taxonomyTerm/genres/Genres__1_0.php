<?php

/**
 * @file
 * Contains \Drupal\restful_example\Plugin\resource\Tags__1_0.
 */

namespace Drupal\livesource\Plugin\resource\entity\taxonomyTerm\genres;

use Drupal\restful\Plugin\resource\ResourceEntity;
use Drupal\restful\Plugin\resource\ResourceInterface;
use Symfony\Component\Validator\Constraints\False;


/**
 * Class Genres__1_0
 * @package Drupal\livesource\Plugin\resource\entity\taxonomyTerm\genres
 *
 * @Resource(
 *   name = "genres:1.0",
 *   resource = "genres",
 *   label = "Genres",
 *   description = "Export the genres taxonomy term.",
 *   authenticationTypes = TRUE,
 *   authenticationOptional = TRUE,
 *   dataProvider = {
 *     "entityType": "taxonomy_term",
 *     "bundles": {
 *       "genres"
 *     },
 *   },
 *   renderCache = {
 *     "render": TRUE
 *   },
 *   majorVersion = 1,
 *   minorVersion = 0
 * )
 */


class Genres__1_0 extends ResourceEntity {

    protected function publicFields() {
        $public_fields = parent::publicFields();

        $public_fields['term'] = array(
            'wrapper_method' => 'value',
            'wrapper_method_on_entity' => TRUE,
            'process_callbacks' => array(
                array($this, 'termProcess'),
            ),
        );

        return $public_fields;
    }

    public function termProcess($term) {
        // Graciously borrowed from function taxonomy_field_formatter_view in taxonomy.module
        $uri = entity_uri('taxonomy_term', $term);
        $element = array(
            '#type' => 'link',
            '#title' => $term->name,
            '#href' => $uri['path'],
            '#options' => $uri['options'],
        );
        if (!isset($element['#options']['attributes'])) {
            $element['#options']['attributes'] = array();
        }
        // Found at function rdf_field_attach_view_alter in rdf.module
        if (!empty($term->rdf_mapping['rdftype'])) {
            $element['#options']['attributes']['typeof'] = $term->rdf_mapping['rdftype'];
        }
        if (!empty($term->rdf_mapping['name']['predicates'])) {
            // A property attribute is used with an empty datatype attribute so
            // the term name is parsed as a plain literal in RDFa 1.0 and 1.1.
            $element['#options']['attributes']['property'] = $term->rdf_mapping['name']['predicates'];
            $element['#options']['attributes']['datatype'] = '';
        }
        return drupal_render($element);
    }
}