<?php

namespace Zugy\AlgoliaEloquentTrait;

use AlgoliaSearch\Laravel\ModelHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class ZugyModelHelper extends ModelHelper
{
    public function getFinalIndexName(Model $model, $indexName)
    {
        $appEnv = App::environment('testing') ? 'local' : App::environment();

        $env_suffix = property_exists($model, 'perEnvironment') && $model::$perEnvironment === true ? '_' . $appEnv : '';

        return $indexName.$env_suffix;
    }
}