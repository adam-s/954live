<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 1/21/16
 * Time: 9:14 PM
 */

namespace Drupal\livesource\views;


class MicrodataVenueStyle extends MicrodataStyle {

    private $wrapper;

    public function __construct(QueryBuilder $query, $node) {
        parent::__construct($query);
        $this->wrapper = entity_metadata_wrapper('node', $node);
        return $this;
    }

    public function render($results) {

        $social = NULL;
        if ($this->wrapper->field_social->value()[0]['url']) {
            $social = $this->wrapper->field_social->value()[0]['url'];
        }

        $uri =  entity_uri('node', $this->wrapper->value());
        $path =  drupal_get_path_alias($uri['path']);
        // ld+json microdata URLs are absolute

        $address = $this->wrapper->field_address->value();
        $geo = $this->wrapper->field_geo->value();

        $output = array(
            '@type' => 'MusicVenue',
            "@context" => "http://schema.org",
            'name' => $this->wrapper->title->value(),
            'description' => $this->wrapper->field_about->value(),
            'image' => file_create_url($this->wrapper->field_image->value()['uri']),
            'sameAs' => $social,
            'telephone' => $this->wrapper->field_phone->value(),
            'url' => url($path, array('absolute' => TRUE)),
            'address' => array(
                '@type' => 'PostalAddress',
                "@context" => "http://schema.org",
                'streetAddress' => $address['thoroughfare'],
                'addressLocality' => $address['locality'],
                'addressRegion' => $address['administrative_area'],
                'postalCode' => $address['postal_code'],
            ),
            'geo' => array(
                '@type' => 'GeoCoordinates',
                "@context" => "http://schema.org",
                'latitude' => $geo['lat'],
                'longitude' => $geo['lon'],
            ),
        );

        $output['event'] = $this->eventJSON($results);

        $element = array(
            '#type' => 'markup',
            '#markup' =>  '<script type="application/ld+json">' . json_encode($output) . "</script>",
        );
        // json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)

        drupal_add_html_head($element, 'livesource_jsonld');
    }
}