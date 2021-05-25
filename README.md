
Laravel Commentable Package
============

This Package makes it easy to implement Commenting system for Eloquent's Models. just use the trait in the model and you're good to go.


### Requirements
- PHP 7.2+
- Laravel 7+

#### Composer Install

	composer require alibayat/laravel-commentable

#### Publish and Run the migrations


```bash
php artisan vendor:publish --provider="AliBayat\LaravelCommentable\CommentableServiceProvider"

php artisan migrate
```


Laravel Commentable package will be auto-discovered by Laravel. and if not: register the package in config/app.php providers array manually.
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
use App\User;
use App\Post;
use AliBayat\LaravelCommentable\Comment;



//  assuming that we have these variables
$user = User::first();
$post = Post::first();
$comment = 
[
	'title' => 'comment title (nullable)', 
	'body' => 'comment body'
];
$commentId = 1;
```
### Create a comment

```php
    $post->comment($comment, $user);
```

### Create a child comment

```php
    $post->comment($comment, $user, $parent);  
```

### Check if a comment has children (boolean)
```php
    $comment = Comment::first();
    $comment->hasChildren(); 
```

### Update a comment
```php
    $post->updateComment($commentId, $comment);
```
### Delete a comment
```php
    $post->deleteComment($commentId); 
```

### Count comments
```php
    $post->commentCount();
```

---

### Activation

by default when you add a cooment it is stored as a deactive comment, unless you provide an 'active' field and set it to true:
```php
$activeComment = 
[
	'title'  => 'comment title (nullable)', 
	'body'   => 'comment body',
	'active' => true
];
$post->comment($activeComment, $user);
```

but you can always change the comment state by using below methods:

### Activate
```php
    $post->active();
    // returns true if operation is successful
```

### Deactivate
```php
    $post->deactive();
    // returns true if operation is successful
```
---

### comments() Relationship
```php
    $postWithComments = Post::with('comments')
	    ->get();
    // return all comments associated with the post

```


### activeComments() Relationship
```php
    $postWithComments = Post::with('activeComments')
	    ->get();
    // return all active comments associated with the post

```


#### Credits

 - Ali Bayat - <ali.bayat@live.com>
