<?php

namespace App\Repositories;

use App\Models\Sales;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class SalesRepository.
 */
class SalesRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Sales::class;
    }
}
