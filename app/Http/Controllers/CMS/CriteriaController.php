<?php

namespace App\Http\Controllers\CMS;

use App\Repositories\CriteriaRepositories;

class CriteriaController
{
    protected $criteriaRepo;
    public function __construct(CriteriaRepositories $criteriaRepo)
    {
        $this->criteriaRepo = $criteriaRepo;
    }
    public function getAllData()
    {
        return $this->criteriaRepo->getAlldata();
    }
}
