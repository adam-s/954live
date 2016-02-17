<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 1/21/16
 * Time: 9:14 PM
 */

namespace Drupal\livesource\views;


class MicrodataStyle implements StyleInterface {

    protected $query;

    private $instance_id = 'events:1.5';

    public function __construct(QueryBuilder $query) {
        $this->query = $query;
        return $this;
    }

    public function getInstanceId() {
        return $this->instance_id;
    }

    public function getQuery() {
        return $this->query->getQuery();
    }

    public function venueJSON ($venue) {
        return array(
            '@type' => 'MusicVenue',
            "@context" => "http://schema.org",
            'name' => $venue->name,
            'description' => $venue->about,
            'image' => file_create_url($venue->image->uri),
            'sameAs' => $venue->social[0]->url,
            'telephone' => $venue->phone,
            'url' => url($venue->url, array('absolute' => TRUE)),
            'address' => array(
                '@type' => 'PostalAddress',
                "@context" => "http://schema.org",
                'streetAddress' => $venue->address->thoroughfare,
                'addressLocality' => $venue->address->locality,
                'addressRegion' => $venue->address->administrative_area,
                'postalCode' => $venue->address->postal_code,
            ),
            'geo' => array(
                '@type' => 'GeoCoordinates',
                "@context" => "http://schema.org",
                'latitude' => $venue->geo->lat,
                'longitude' => $venue->geo->lon,
            ),
        );
    }

    /**
     * @param $artists
     * @return array
     *
     * @link http://stackoverflow.com/questions/7685628/drupal-7-get-image-field-path
     * @link https://schema.org/url
     */
    public function artistJSON ($artists) {
        $output = array();
        if (!empty($artists)) {
            foreach ($artists as $artist) {
                if (!empty($artist->social[0])) {
                    $social = $artist->social[0]->url;
                } else {
                    $social = NULL;
                }
                $genres = array();
                foreach($artist->genres as $genre) {
                    $genres[] = $genre->label;
                }
                $output[] = array(
                    '@type' => 'MusicGroup',
                    "@context" => "http://schema.org",
                    'name' => $artist->name,
                    'description' => $artist->about,
                    'url' => url($artist->url, array('absolute' => TRUE)),
                    'sameAs' => $social,
                    'image' => file_create_url($artist->image->uri),
                    'genre' => $genres,
                );
            }
        }
        return $output;
    }

    public function eventJSON($results) {
        $events = array();
        if (!empty($results)) {
           //$venue = $results[0]->venue;
            foreach ($results as $event) {
                $artists = $this->artistJSON($event->artists);
                $events[] = array(
                    '@type' => 'MusicEvent',
                    "@context" => "http://schema.org",
                    'name' => $event->title,
                    'startDate' => format_date($event->date, 'custom', 'c', 'UTC'),
                    'location' =>  $this->venueJSON($event->venue),
                    'performer' => $artists,
                    'url' => url($event->url, array('absolute' => TRUE)),
                );
            }
        }
        return $events;
    }

    public function pluckArtist($artists) {
        foreach ($artists as $artist) {
            if ($artist->id == $this->query->getId()) {
                return $artist;
            }
        }
    }

    public function render($results) {
        $output = array();

        if ($this->query->getType() == 'venue') {
            $output = $this->venueJSON($results[0]->venue);
            $output['event'] = $this->eventJSON($results);
        }

        if ($this->query->getType() == 'event') {
            $output = $this->eventJSON($results)[0];
        }

        if ($this->query->getType() == 'events' || $this->query->getType() == 'genres') {
            $output = array_values($this->eventJSON($results));
        }

        if ($this->query->getType() == 'artists') {
            $artist = $this->pluckArtist($results[0]->artists);
            $output = $this->artistJSON(array($artist))[0];
            $output['event'] = $this->eventJSON($results);
        }

        $element = array(
            '#type' => 'markup',
            '#markup' =>  '<script type="application/ld+json">' . json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "</script>",
        );

        drupal_add_html_head($element, 'livesource_jsonld');
    }
}