<?php

namespace App\Repositories;

use App\Models\ShipmentCost;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class ShipmentRepository.
 */
class ShipmentRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return ShipmentCost::class;
    }
    
    public function setAllToDeactive()
    {
        $this->makeModel()->where(['active'=>1])->update(['active' => 0]);
        return $this;
    }
}
