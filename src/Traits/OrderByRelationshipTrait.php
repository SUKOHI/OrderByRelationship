<?php

namespace Sukohi\OrderByRelationship\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait OrderByRelationshipTrait {

    public function scopeOrderByRelationship($query, $relationship, $closure) {

        if(method_exists($this, $relationship)) {

            $model = $this->$relationship();

            if($model instanceof HasOne) {

                $parent_column = $model->getLocalKeyName();
                $child_column = $model->getForeignKeyName();

            } elseif($model instanceof BelongsTo) {

                $parent_column = $model->getForeignKey();
                $child_column = $model->getOwnerKey();

            } else {

                throw new \Exception('Relationship must be HasOne or BelongsTo');

            }

            $class = get_class($model->getModel());

            if(is_callable($closure) && class_exists($class)) {

                $ids = $closure(new $class())->pluck($child_column);

                if($ids->count() > 0) {

                    $query->orderBy(
                        \DB::raw('FIELD(`'. $parent_column .'`, '. $ids->implode(',') .')')
                    );

                }

            }

        } else {

            throw new \Exception('Relationship not found');

        }

    }

}