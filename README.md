
Laravel Commentable Package
============

This Package makes it easy to implement Commenting system for Eloquent's Models. just use the trait in the model and you're good to go.


### Requirements
- PHP 7.2+
- Laravel 7+

## Installation

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

## Usage
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

## Activation

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

## Relationships

### comments Relationship
```php
    $postWithComments = Post::with('comments')
	    ->get();
    // return all comments associated with the post

```


### activeComments Relationship
```php
    $postWithActiveComments = Post::with('activeComments')
	    ->get();
    // return all active comments associated with the post

```



### parent Relationship
```php
    $comment = Post::first()->comments()->first();
    
    $comment->parent;
    // return the comment's parent if available

```



### children Relationship
```php
    $comment = Post::first()->comments()->first();
    
    $comment->children;
    // return the comment's children if any

```


### ancestors Relationship
```php
    $comment = Post::first()->comments()->first();
    
    $comment->ancestors;
    // return the comment's ancestors if any

```


### descendants Relationship
```php
    $comment = Post::first()->comments()->first();
    
    $comment->descendants;
    // return the comment's descendants if any

```




---

## Additional functionalities
thanks to the great [laravel-nestedset](https://github.com/lazychaser/laravel-nestedset) package, you have access to some additional functionalities, we review some of them here but you can always refer to the package's repository for the full documentation.

### toTree()
```php
    Post::first()->comments->toTree();
    
    // return a collection of the comment's tree structure

```


### toFlatTree()
```php
    Post::first()->comments->toFlatTree();
    
    // return a collection of the comment's flat tree structure

```

### saveAsRoot()
```php
    $comment = Post::first()->comments()->latest()->first();
    $comment->saveAsRoot();
    
    // Implicitly change the comment's position to Root
    // return bool

```


### makeRoot()
```php
    $comment = Post::first()->comments()->latest()->first();
    $comment->makeRoot()->save();
    
    // Explicitly change the comment's position to Root
    // return bool

```


#### Credits

 - Ali Bayat - <ali.bayat@live.com>
