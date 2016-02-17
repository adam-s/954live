<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 1/21/16
 * Time: 9:14 PM
 */

namespace Drupal\livesource\views;


class ArtistStyle implements StyleInterface {

    private $query;

    private $instance_id = 'artists:1.0';

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
        $artist = $resultObject[0];
        $output['genres'] = $this->genresProcess($artist->genres);
        $output['social'] = $this->socialRender($artist->social);
        $output['youtube'] = $this->youtubeProcess($artist->youtube);
        $output['image'] = $artist->image;
        $output['about'] = $artist->about;
        return $output;
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

    public function socialRender($social) {
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