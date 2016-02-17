<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 1/21/16
 * Time: 10:05 PM
 */

namespace Drupal\livesource\views;


class VenueStyle implements StyleInterface {

    public $query;

    private $instance_id = 'venues:1.0';

    public function __construct(QueryBuilder $query){
        $this->query = $query;
    }

    public function getInstanceId() {
        return $this->instance_id;
    }

    public function getQuery() {
        return $this->query->getQuery();
    }

    public function render($results) {
        $venue = $results[0];
        $element = array();
        $element['name'] = $venue->name;
        $element['image'] = $this->imageProcess($venue->image, $venue->name);
        $element['address'] = $venue->address;
        $element['phone'] = $venue->phone;
        $element['social'] = $this->socialProcess($venue->social);
        $element['map'] = $this->mapProcess($venue->geo, $venue->name);
        $element['about'] = $venue->about;
        return $element;
    }

    public function imageProcess($image, $title) {
        $variables = array();

        $variables['style_name'] = 'xl';
        $variables['path'] = $image->uri;
        $variables['alt'] = $title;
        $variables['title'] = $title;
        $variables['class'][] = 'img-responsive';

        return theme('image_style', $variables);
    }

    public function socialProcess($social) {
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

    /**
     * @param $geo
     * @return string
     *
     * API_KEY = AIzaSyD7eKp9vZ3qRRyttawSrx4zdKkFn-YolE8
     * MAKE SURE TO SET REFERRER ON KEY IN PRODUCTION
     *
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
}