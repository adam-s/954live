<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 2/8/16
 * Time: 5:33 PM
 */

namespace Drupal\livesource\Plugin\resource\entity\node\events;


use Drupal\restful\Plugin\resource\DataProvider\DataProviderEntity;
use Drupal\restful\Plugin\resource\DataProvider\DataProviderInterface;

class DataProviderEvents extends DataProviderEntity implements DataProviderInterface{
    protected function addExtraInfoToQuery($query) {
        // Add a generic tags to the query.
        parent::addExtraInfoToQuery($query);
        $query->addTag('restful_events');
    }
}