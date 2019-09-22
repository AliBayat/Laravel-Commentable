
Laravel Commentable Package
============

This Package makes it easy to implement Commenting system for Eloquent's Models. just use the trait in the model and you're good to go.


### Requirements
PHP 7.2+
Laravel 5.8+

#### Composer Install

	composer require alibayat/laravel-commentable

#### Publish and Run the migrations


```bash
php artisan vendor:publish --provider="AliBayat\LaravelCommentable\CommentableServiceProvider"

php artisan migrate
```


LaravelCommentable package will be auto-discovered by Laravel. and if not: register your package in config/app.php providers array manually.
```php
'providers' => [
	...
	\AliBayat\LaravelCommentable\CommentableServiceProvider::class,
],
```


#### Setup models - just use the Trait in the Model.

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use AliBayat\LaravelCommentable\Commentable;

class Post extends Model
{
	use Commentable;

}

```

### Usage
```php
//  assuming that we have these variables
$user = User::first();
$post = Post::first();
$commentBody = 
[
	'title' => 'comment title (nullable)', 
	'body' => 'comment body'
];
$commentId = 1;
```
### Create a comment

```php
    $post->comment($commentBody, $user);
```

### Create a child comment

```php
    $post->comment($commentBody, $user, $parent);  
```

### Update a comment
```php
    $post->updateComment($commentId, $commentBody);
```
### Delete a comment
```php
    $post->deleteComment($commentId); 
```

### Count comments
```php
    $post->commentCount();
```


#### Credits

 - Ali Bayat - <ali.bayat@live.com>
