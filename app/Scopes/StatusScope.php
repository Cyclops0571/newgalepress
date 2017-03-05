<?php

namespace App\Scopes;

use eStatus;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class StatusScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        $builder->where('StatusID', eStatus::Active);
    }

}
