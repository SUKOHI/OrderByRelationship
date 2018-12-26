# OrderByRelationship
A Laravel package that allows you to sort DB data by relationship column.  
This package is maintained under Laravel 5.7.

# Installation

    composer require sukohi/order-by-relationship:1.*

# Preparation

Set `OrderByRelationshipTrait` and `relationship` which is `HasOne` or `BelongsTo` in your model.

    use Sukohi\OrderByRelationship\Traits\OrderByRelationshipTrait;

    class User extends Model
    {
        use OrderByRelationshipTrait;
        
        // Relationship
        public function user_type() {
    
            return $this->hasOne(\App\UserType::class, 'id', 'user_type_id');
    
        }

    }
    
Now your model has `orderByRelationship()`.

# Usage

Set relationship name and closure for sort as follows.

    $users = \App\User::orderByRelationship('user_type', function($q){

        return $q->orderBy('name', 'desc');

    })
    ->get();
    
Note: You need to return query.

# Dependency

This package could not be available in your environment because SQL query contains `ORDER BY FIELD()` clause.  
I mean MySQL has the clause but it depends on the other databases and their versions, I guess.

# License
This package is licensed under the MIT License.

Copyright 2018 Sukohi Kuhoh