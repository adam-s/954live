<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 1/21/16
 * Time: 9:14 PM
 */

namespace Drupal\livesource\views;

class MicrodataArtistStyle extends MicrodataStyle {

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

        $genres = array();
        foreach($this->wrapper->field_genres->value() as $genre) {
            $genres[] = $genre->name;
        }

        $title = $this->wrapper->title->value();
        $about =  $this->wrapper->field_about->value();
        $uri = entity_uri('node', $this->wrapper->value());
        $image_uri = $this->wrapper->field_image->value()['uri'];

        $output = array(
            '@type' => 'MusicGroup',
            "@context" => "http://schema.org",
            'name' => $title,
            'description' => $about,
            'url' => url($uri['path'], array('absolute' => TRUE)),
            'sameAs' => $social,
            'image' => file_create_url($image_uri),
            'genre' => $genres,
        );

        if (!empty($results)) {
            $output['event'] = $this->eventJSON($results);
        }


        $element = array(
            '#type' => 'markup',
            '#markup' =>  '<script type="application/ld+json">' . json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "</script>",
        );

        drupal_add_html_head($element, 'livesource_jsonld');
    }
}