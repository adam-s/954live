<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 1/27/16
 * Time: 11:06 AM
 */

namespace Drupal\livesource\views;

class DefaultStyle implements StyleInterface {

    public $query;

    private $instance_id = 'events:1.1';

    public function __construct(QueryBuilder $query) {
        $this->query = $query;
    }

    public function getInstanceId() {
        return $this->instance_id;
    }

    public function getQuery() {
        return $this->query->getQuery();
    }

    public function render($resultObject) {
        $output = array();
        foreach($resultObject as $delta => $result) {

            $output[] = array(
                '#theme' => 'event__item',
                '#items' => array(
                    'image' => $result->artists[0]->image,
                    'title' => $result->title,
                    'date' => $result->date,
                    'url' => $result->url,
                    'venue' => array(
                        'name' => $result->venue->name,
                        'location' => $result->venue->location,
                        'url' => $result->venue->url,
                    ),
                    'artists' => $this->processArtists($result->artists)
                ),
            );
        }
        return $output;
    }

    private function processArtists($result) {
        $artists = array();
        foreach ($result as $artist) {
            $artists[] = array(
                'name' => $artist->name,
                'url' => $artist->url,
            );
        }
        return $artists;
    }
}