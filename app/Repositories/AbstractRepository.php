<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository {

    public function __construct(Model $model) {
        $this->model = $model;
    }

    public function selectAttributesRelatedRecords($attributes) {
        $this->model = $this->model->with($attributes);
       // the query is being assembled
    }

    public function filter($filters) {
        $filters = explode(';', $filters);
        
        foreach($filters as $key => $condicao) {

            $c = explode(':', $condicao);
            $this->model = $this->model->where($c[0], $c[1], $c[2]);
           // the query is being assembled
        }
    }

    public function selectAttributes($attributes) {
        $this->model = $this->model->selectRaw($attributes);
    }

    public function getResult() {
        return $this->model->get();
    }
}

?>