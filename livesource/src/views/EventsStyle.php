<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 1/21/16
 * Time: 9:14 PM
 *
 * Maps to Events__1_0
 */

namespace Drupal\livesource\views;


class EventsStyle implements StyleInterface {

    private $query;

    private $instance_id = 'events:1.0';

    public function __construct($query) {
        $this->query = $query;
    }

    public function getInstanceId() {
        return $this->instance_id;
    }

    public function getQuery() {
        return $this->query->getQuery();
    }

    public function render($results){
        $event = $results[0];
        $venue = $event->venue;
        $element = array();

        $element['title'] = $event->title;
        $element['date'] = $event->date;

        $element['venue'] = array(
            'name' => $venue->name,
            'location' => $this->locationProcess($venue->location),
            'address' => $venue->address,
            'map' => $this->mapProcess($venue->geo, $venue->name),
            'phone' => $venue->phone,
            'social' => $this->venueSocialProcess($venue->social),
            'image' => $this->imageProcess($venue->image, $venue->name, 'xl'),
            'url' => $venue->url,
        );

        foreach($event->artists as $delta => $artist) {
            $element['artists'][$delta] = array(
                'name' => $artist->name,
                'image' => $artist->image,
                'youtube' => $this->youtubeProcess(array($artist->youtube[0])),
                'genres' => $this->genresProcess($artist->genres),
                'url' => $artist->url,
                'social' => $this->artistSocialRender($artist->social),
            );
        }

        return $element;
    }

    public function youtubeProcess($youtube) {
        $element = array();
        foreach($youtube as $delta => $video) {
            $src = "http://www.youtube.com/embed/" . $video->video_id ."?autoplay=0";
            $output = '<div class="embed-responsive embed-responsive-16by9">';
            $output .= '<iframe class="embed-responsive-item" src="' . $src . '" ' .
                'frameborder="0" wmode="Opaque" allowfullscreen=""></iframe>';
            $output .= '</div>';

            $element[] = $output;
        }
        return $element;
    }

    public function locationProcess($address) {
        return $address->locality . ', ' . $address->administrative_area;
    }
    public function imageProcess($image, $title, $style = 'xl') {
        $variables = array();

        $variables['style_name'] = $style;
        $variables['path'] = $image->uri;
        $variables['alt'] = $title;
        $variables['title'] = $title;
        $variables['class'][] = 'img-responsive';

        return theme('image_style', $variables);
    }

    /**
     * @param $geo
     * @param $name
     * @return string API_KEY = AIzaSyD7eKp9vZ3qRRyttawSrx4zdKkFn-YolE8
     *
     * API_KEY = AIzaSyD7eKp9vZ3qRRyttawSrx4zdKkFn-YolE8
     * MAKE SURE TO SET REFERRER ON KEY IN PRODUCTION
     * @link https://developers.google.com/maps/documentation/static-maps/intro#Markers
     */
    public function mapProcess($geo, $name) {
        $map = 'https://maps.googleapis.com/maps/api/staticmap?';
        $map .= 'center=' . $geo->lat . ',' . $geo->lon;
        $map .= '&zoom=13';
        $map .= '&size=400x300';
        $map .= '&maptype=roadmap';
        $map .= '&markers=color:0x701650|' . $geo->lat . ',' . $geo->lon;
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
        return '<a href="https://maps.google.com/?q=' . $name . '" target="_black"><img class="img-responsive" src="' . $map . '"/></a>';
    }

    public function artistSocialRender($social) {
        $social_field = variable_get('socialfield_services');
        foreach($social as $service) {
            $text = '<i class="icon icon-' . $service->service . '"></i>';
            $element['links'][] = array (
                '#type' => 'link',
                '#title' => $text,
                '#href' => $service->url,
                '#options' => array(
                    'attributes' => array(
                        'target' => '_blank',
                        'title' => $social_field[$service->service]['name'],
                        'class' => 'btn btn-social-icon btn-' . $service->service,
                    ),
                    'html' => TRUE,
                ),
            );
        }

        return drupal_render($element);
    }

    public function venueSocialProcess($social) {
        $social_field = variable_get('socialfield_services');
        foreach($social as $service) {
            $text = '<span class="icon icon-' . $service->service . '"></span> Website';
            $element['links'][] = array (
                '#type' => 'link',
                '#title' => $text,
                '#href' => $service->url,
                '#options' => array(
                    'attributes' => array(
                        'target' => '_blank',
                        'title' => $social_field[$service->service]['name'],
                        'class' => 'btn-sm btn-block btn-social btn-' . $service->service,
                    ),
                    'html' => TRUE,
                ),
            );
        }

        return drupal_render($element);
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