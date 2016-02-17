<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 1/21/16
 * Time: 9:14 PM
 */

namespace Drupal\livesource\views;


class VenueEventsStyle implements StyleInterface {

    private $query;

    private $instance_id = 'events:1.4';

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
                    'image' => $this->imageProcess($artist->image),
                    'genres' => $this->genresProcess($artist->genres),
                    'zebra' => $artist_delta % 2 == 0 ? 'even' : 'odd',
                );
            }

            $variables = array(
                'event' => array(
                    'title' => $event->title,
                    'date' => $event->date,
                    'event_url' => $event->url,
                    'artists' => $artists,
                ),
            );
            $elements[$event_delta] = theme('venues_event__item', $variables);
        }
        return $elements;
    }

    public function imageProcess($image) {
        $variables = array();

        $variables['style_name'] = 'artist_card';
        $variables['path'] = $image->uri;
        $variables['class'] = 'img-responsive';

        return theme('image_style', $variables);
    }

    public function genresProcess($genres) {
        if (empty($genres)) {
            return NULL;
        }
        $output = '<span class="typewriter pull-left">#genres</span>';
        $output .= '<ul class="list-inline genres">';
        foreach ($genres as $genre) {
            $output .= '<li>';
            $output .= '<span class="red-highlight">//</span>';
            $output .= $genre->term;
            $output .= '</li>';
        }
        $output .= '</ul>';
        return $output;
    }
}