#### Conventions and Coding Style
* Please see [Kohana Userguide](http://kohanaframework.org/3.2/guide/kohana/conventions)

#### Database and Jelly Module
* All table names should be singular
 * Wrong: *posts* or *users*
 * Right: *post* or *user*
* The model must have the same name as the table
* The table name must be specified in the Model
 * e.g. $meta->table('post');