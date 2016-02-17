<?php
///**
// * Created by PhpStorm.
// * User: adam
// * Date: 1/21/16
// * Time: 9:14 PM
// */
//
//namespace Drupal\livesource\views;
//
//
//class ArtistsMicrodataStyle implements StyleInterface {
//
//    private $query = array();
//
//    private $type = 'event';
//
//    private $instance_id = 'events:1.5';
//
//    public function __construct() {
//        return $this;
//    }
//
//    public function getInstanceId() {
//        return $this->instance_id;
//    }
//
//    public function setFilter($type, $id) {
//        $this->type = $type;
//
//        if ($type != 'event') {
//            $key = $type . '.id';
//        } else {
//            $key = 'id';
//        }
//
//        $this->query['filter'][$key] = $id;
//        return $this;
//    }
//
//    public function setRange($range) {
//        $this->query['range'] = $range;
//        return $this;
//    }
//
//    public function setDateFilter($date) {
//        $this->query['filter']['date'] = array(
//            'value' => $date,
//            'operator' => '>=',
//        );
//        return $this;
//    }
//
//    public function getQuery() {
//        return $this->query;
//    }
//
//    public function venueJSON ($venue) {
//        return array(
//            '@type' => 'MusicVenue',
//            'name' => $venue->name,
//            'description' => $venue->about,
//            'image' => file_create_url($venue->image->uri),
//            'sameAs' => $venue->social[0]->url,
//            'telephone' => $venue->phone,
//            'address' => array(
//                '@type' => 'PostalAddress',
//                'streetAddress' => $venue->address->thoroughfare,
//                'addressLocality' => $venue->address->locality,
//                'addressRegion' => $venue->address->administrative_area,
//                'postalCode' => $venue->address->postal_code,
//            ),
//            'geo' => array(
//                '@type' => 'GeoCoordinates',
//                'latitude' => $venue->geo->lat,
//                'longitude' => $venue->geo->lon,
//            ),
//        );
//    }
//
//    public function artistJSON ($artists) {
//        $output = array();
//        foreach ($artists as $artist) {
//            if (!empty($artist->social[0])) {
//                $social = $artist->social[0]->url;
//            } else {
//                $social = NULL;
//            }
//            $genres = array();
//            foreach($artist->genres as $genre) {
//                $genres[] = $genre->label;
//            }
//            $output[] = array(
//                '@type' => 'MusicGroup',
//                'name' => $artist->name,
//                'description' => $artist->about,
//                'url' => url($artist->url, array('absolute' => TRUE)),
//                'sameAs' => $social,
//                'image' => file_create_url($artist->image->uri),
//                'genre' => $genres,
//            );
//        }
//        return $output;
//    }
//
//    public function eventJSON($results) {
//        $events = array();
//        $venue = $results[0]->venue;
//        foreach ($results as $event) {
//            $artists = $this->artistJSON($event->artists);
//            $events[] = array(
//                '@type' => 'MusicEvent',
//                'name' => $event->title,
//                'startDate' => format_date($event->date, 'custom', 'c', 'UTC'),
//                'location' =>  $this->venueJSON($venue),
//                'artists' => $artists,
//            );
//        }
//        return $events;
//    }
//
//    public function render($results) {
//
//        if ($this->type == 'venue') {
//            $output = $this->venueJSON($results[0]->venue);
//            $output['@context'] = array('schema' => 'http://schema.org');
//            $output['events'] = $this->eventJSON($results);
//        }
//
//        if ($this->type == 'event') {
//            $output = $this->eventJSON($results)[0];
//            $output['@context'] = array('schema' => 'http://schema.org');
//        }
//
//        $element = array(
//            '#type' => 'markup',
//            '#markup' =>  '<script type="application/ld+json">' . drupal_json_encode($output) . "</script>",
//        );
//
//        drupal_add_html_head($element, 'livesource_jsonld');
//    }
//}