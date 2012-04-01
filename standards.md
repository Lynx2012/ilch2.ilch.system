#### Conventions and Coding Style
* Please see [Kohana Userguide](http://kohanaframework.org/3.2/guide/kohana/conventions)

#### Database and Jelly Module
* All table names should be plural
 * Wrong: *post* or *user*
 * Right: *posts* or *users*
* The model must have the same name as the table
* The table name must be specified in the Model
 * e.g. $meta->table('posts');