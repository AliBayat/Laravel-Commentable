<?php

declare(strict_types=1);

/**
 * Laravel Commentable Package by Ali Bayat.
 */

namespace AliBayat\LaravelCommentable;

use AliBayat\LaravelCommentable\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Commentable
{
    /**
     * @return string
     */
    public function commentableModel(): string
    {
        return config('laravel-commentable.model');
    }

    /**
     * @return mixed
     */
    public function comments(): MorphMany
    {
        return $this->morphMany($this->commentableModel(), 'commentable')->whereNull('parent_id');
    }

    /**
     * @return mixed
     */
    public function allComments(): MorphMany
    {
        return $this->morphMany($this->commentableModel(), 'commentable');
    }


    /**
     * @return mixed
     */
    public function activeComments(): MorphMany
    {
        return $this->morphMany($this->commentableModel(), 'commentable')->whereNull('parent_id')->where('active', true);
    }


    /**
     * @return mixed
     */
    public function allActiveComments(): MorphMany
    {
        return $this->morphMany($this->commentableModel(), 'commentable')->where('active', true);
    }
    
    
    /**
     * @param $data
     * @param Model      $creator
     * @param Model|null $parent
     *
     * @return static
     */
    public function comment($data, Model $creator, Model $parent = null)
    {
        $commentableModel = $this->commentableModel();

        $comment = (new $commentableModel())->createComment($this, $data, $creator);

        if (!empty($parent)) {
            $parent->appendNode($comment);
        }

        return $comment;
    }

    /**
     * @param $id
     * @param $data
     * @param Model|null $parent
     *
     * @return mixed
     */
    public function updateComment($id, $data, Model $parent = null)
    {
        $commentableModel = $this->commentableModel();

        $comment = (new $commentableModel())->updateComment($id, $data);

        if (!empty($parent)) {
            $parent->appendNode($comment);
        }

        return $comment;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function deleteComment($id): bool
    {
        $commentableModel = $this->commentableModel();

        return (bool) (new $commentableModel())->deleteComment($id);
    }

    /**
     * @return mixed
     */
    public function commentCount(): int
    {
        return $this->allComments()->count();
    }
}
