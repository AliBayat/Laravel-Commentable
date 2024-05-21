
Laravel Commentable Package
============

This Package makes it easy to implement Commenting system for Eloquent's Models. just use the trait in the model and you're good to go.


### Requirements
- PHP 7.2+
- Laravel 7+

## Installation
```bash
composer require alibayat/laravel-commentable
```

#### Publish and Run the migrations

```bash
php artisan vendor:publish --provider="AliBayat\LaravelCommentable\CommentableServiceProvider"
```

```bash
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

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use AliBayat\LaravelCommentable\Commentable;

class Post extends Model
{
	use Commentable;

}

```

## Usage
```php
use App\Models\User;
use App\Models\Post;
use AliBayat\LaravelCommentable\Comment;


//  assuming that we have these variables
$user = User::first();
$post = Post::first();

```
### Create a comment for the post

```php
$commentData = [
	'title' => 'comment title (nullable)',
	'body' => 'comment body'
];

$post->comment($commentData, $user);
```

### Create a child comment for the post

```php
$parentComment = Comment::first();

$childCommentData = [
	'title' => 'comment title (nullable)',
	'body' => 'comment body'
];

$post->comment($childCommentData, $user, $parentComment);
```

### Update a comment of the post
```php
$comment = Comment::first();

$newData = [
	'body' => 'new body of the comment to update'
];

$post->updateComment($comment->id, $newData);
```

### Delete a single comment of the post
```php
$comment = Comment::first();

$post->deleteComment($comment->id);
```

### Delete all the comments of the post
```php
$post->comments()->delete();
```

### Check if a comment has any children (boolean)
```php
$comment = Comment::first();

$comment->hasChildren();
```

### Count comments of the post
```php
$post->commentCount();
```

### Show comments on a post
```php
$post->allComments(); // shows all comments (including children)
$post->comments(); // shows only top level comments
```

---

## Activation

by default when you create a comment, it will be stored as a deactivated comment, unless you provide an 'active' field and set it to true:
```php
$activeComment = [
	'body'   => 'comment body',
	'active' => true
];

$comment = $post->comment($activeComment, $user);
```

but you can always change the comment's state of activation by using below methods:

### Activate
```php
$comment->active();

// returns a boolean indicating the state of operation
```

### Deactivate
```php
$comment->deactivate();

// returns a boolean indicating the state of operation
```
---

## Relationships

### comments Relationship
```php
$postWithComments = Post::with('comments')->get();

// returns a collection of all comments associated with the post

```


### activeComments Relationship
```php
$postWithActiveComments = Post::with('activeComments')->get();

// returns a collection of all active comments associated with the post

```



### parent Relationship
```php
$comment = Comments::latest()->first();

$comment->parent;

// returns the comment's parent if available

```



### children Relationship
```php
$comment = Comments::latest()->first();

$comment->children;

// returns the comment's children if available

```


### ancestors Relationship
```php
$comment = Comments::latest()->first();

$comment->ancestors;

// return the comment's ancestors if available

```


### descendants Relationship
```php
$comment = Comments::latest()->first();

$comment->descendants;

// return the comment's descendants if available

```

---

## Additional functionalities
thanks to the great [laravel-nestedset](https://github.com/lazychaser/laravel-nestedset) package, you have access to some additional functionalities, we review some of them here but you can always refer to the package's repository for the full documentation.

### toTree()
```php
$post->comments->toTree();

// returns a collection of the comment's tree structure associated with the post

```


### toFlatTree()
```php
$post->comments->toFlatTree();

// return a collection of the comment's flat tree structure associated with the post

```

### saveAsRoot()
```php
$comment = $post->comments()->latest()->first();

$comment->saveAsRoot();

// Implicitly change the comment's position to Root
// returns boolean

```


### makeRoot()
```php
$comment = $post->comments()->latest()->first();

$comment->makeRoot()->save();

// Explicitly change the comment's position to Root
// returns boolean

```


## Credits

 - [Ali Bayat](https://github.com/AliBayat)
 - [All Contributors](../../contributors)
