<?php

namespace App\Repositories;

use App\Interface\CriteriaInterfaces;
use App\Models\Criteria;
use App\Traits\HttpResponseTraits;

class CriteriaRepositories implements CriteriaInterfaces
{
    use HttpResponseTraits;
    protected $criteria;
    public function __construct(Criteria $criteria)
    {
        $this->criteria = $criteria;
    }
    public function getAlldata()
    {
        $data = $this->criteria::all();
        if (!$data) {
            return $this->dataNotFound();
        }
        return $this->success($data);
    }
}
