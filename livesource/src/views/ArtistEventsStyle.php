<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 1/21/16
 * Time: 9:14 PM
 */

namespace Drupal\livesource\views;


class ArtistEventsStyle implements StyleInterface {

    private $query;

    private $instance_id = 'events:1.3';

    public function __construct(QueryBuilder $query) {
        $this->query = $query;
    }

    public function getInstanceId() {
        return $this->instance_id;
    }

    public function getQuery() {
        return $this->query->getQuery();
    }

    /**
     * Needed for this is Venue image / Event date / Venue name / Venue location / List of artists names
     * @param $results
     * @return array of event artist events
     */
    public function render($results) {
        $elements = array();

        foreach($results as $event_delta => $event) {
            $artists = array();
            foreach($event->artists as $artist_delta => $artist) {
                $artists[$artist_delta] = array(
                    'name' => $artist->name,
                    'url' => $artist->url,
                );
            }

            $variables = array(
                'event' => array(
                    'title' => $event->title,
                    'date' => $event->date,
                    'event_url' => $event->url,
                    'venue_url' => $event->venue->url,
                    'venue' => truncate_utf8($event->venue->name, 55, TRUE, TRUE, FALSE),
                    'location' => $event->venue->location,
                    'image' => $this->renderImage($event->venue->image),
                    'artists' => $artists,
                ),
            );
            $elements[$event_delta] = theme('artists_event__item', $variables);
        }
        return $elements;
    }

    public function renderImage($image) {
        $variables = array();

        $variables['style_name'] = 'venue_card';
        $variables['path'] = $image->uri;
        $variables['class'] = 'img-responsive';

        return theme('image_style', $variables);
    }
}