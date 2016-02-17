<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 2/7/16
 * Time: 10:15 PM
 */

namespace Drupal\livesource\views;


class QueryBuilder {
    public $query = array();

    public $id;

    public $type;

    public function __construct($type = NULL, $id = NULL){
        $this->type = $type;
        $this->id = $id;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setSort($sort) {
        $this->query['sort'] = $sort;
    }

    public function setRange($range) {
        $this->query['range'] = $range;
        return $this;
    }

    public function setPage($page) {
        $this->query['page'] = $page;
        return $this;
    }

    public function setDateFilter($date = NULL) {
        if (!isset($date)) {
            $date = new \DateTime('today +3 hour', new \DateTimeZone('UCT'));
            $date = $date->format('c');
        }
        $this->query['filter']['date'] = array(
            'value' => $date,
            'operator' => '>',
        );
        return $this;
    }

    public function setIdFilter($key, $id) {
        $this->query['filter'][$key] = $id;
        return $this;
    }

    public function getQuery() {
        return $this->query;
    }

    public function getType() {
        return $this->type;
    }

    public function getId() {
        return $this->id;
    }


}