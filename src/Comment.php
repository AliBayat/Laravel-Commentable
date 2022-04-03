<?php

declare(strict_types=1);

/**
 * Laravel Commentable Package by Ali Bayat.
 */

namespace AliBayat\LaravelCommentable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Kalnoy\Nestedset\NodeTrait;

class Comment extends Model
{
    use NodeTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];


    /**
     * @return bool
     */
    public function hasChildren(): bool
    {
        return $this->children()->count() > 0;
    }

    /**
     * @return mixed
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return mixed
     */
    public function creator(): MorphTo
    {
        return $this->morphTo('creator');
    }

    /**
     * @param Model $commentable
     * @param $data
     * @param Model $creator
     *
     * @return static
     */
    public function createComment(Model $commentable, $data, Model $creator): self
    {
        return $commentable->comments()->create(array_merge($data, [
            'creator_id'   => $creator->getAuthIdentifier(),
            'creator_type' => $creator->getMorphClass(),
        ]));
    }

    /**
     * @param $id
     * @param $data
     *
     * @return mixed
     */
    public function updateComment($id, $data): bool
    {
        return (bool) static::find($id)->update($data);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function deleteComment($id): bool
    {
        return (bool) static::find($id)->delete();
    }
    

    /**
     * activate a comment
     */
    public function active()
    {
        if ($this->update(['active' => true])) {
            return true;
        }
        return false;
    }
    

    /**
     * deactivate a comment
     */
    public function deactivate()
    {
        if ($this->update(['active' => false])) {
            return true;
        }
        return false;
    }    
    
    
}
