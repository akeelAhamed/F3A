<?php

namespace App\Models;

use App\Helpers\Model;

/**
 * Employer table model
 */
class User
{

    use Model;
    
    /**
     * Table Name
     *
     * @var string
     */
    public static $table_name = "users";

    /**
     * Relation to get category details
     */
    public function getCategory()
    {
        /**
         * Table to relate
         *
         * Columns related [Relation table, Foreign key column(this table), Foreign key table column(to relate)]
         *
         * Condition
         */

        // return [
        //     'type'      => 'hasMany',
        //     'relate'    => \App\Models\Category::class,
        //     'foreignKey'    => 'category',
        //     'localKey'   => 'id',
        // ];
    }
}