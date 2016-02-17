<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 1/21/16
 * Time: 1:21 PM
 */

// artist events / venue events
// filter needs to be artist id and venue id

namespace Drupal\livesource\views;

class EventFormatter {

    public $resultObject;

    public $style;

    public function __construct(\Drupal\livesource\views\StyleInterface $style){
        $this->style = $style;

        return $this;
    }

    public function formattedResults() {
        $this->resultObject =  json_decode($this->getResult());
        return $this->render();
    }

    protected function render() {
        return $this->style->render($this->resultObject->data);
    }

    protected function getResult() {
        $handler = $this->getHandler();
        $fieldCollection = $handler->doGet('', $this->style->getQuery());
        $formatManager = restful()->getFormatterManager();
        $resultSet = $formatManager->format($fieldCollection);

        return $resultSet;
    }

    protected function getHandler () {
        return restful()
            ->getResourceManager()
            ->getPlugin($this->style->getInstanceId());
    }
}