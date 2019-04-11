<?php

return [

    /*
     * Define the table which is used in de database to retrieve the users
     */

    'users_table' => 'users',

    /*
     * Define the mmodel which is used for the relationships on your models
     */

    'users_model' => \App\User::class,

    /*
     * Define the column which is used in de database to save the user's id
     * which created the model.
     */

    'created_by_column' => 'created_by',

    /*
     * Define the column which is used in de database to save the user's id
     * which updated the model.
     */

    'updated_by_column' => 'updated_by',

    /*
     * Define the column which is used in de database to save the user's id
     * which deleted the model.
     */

    'deleted_by_column' => 'deleted_by',

];
