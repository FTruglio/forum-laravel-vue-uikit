<?php

namespace App;

trait Favoriteable
{
    protected static function bootFavoriteable()
    {
        static::deleting(function ($model) {
            $model->favorites->each->delete();
        });
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];
        if (!$this->favorites()->where($attributes)->exists()) {
            return $this->favorites()->create(['user_id' => auth()->id()]);
        }
    }

    public function unfavorite()
    {
        $attributes = ['user_id' => auth()->id()];
        // Get a collection of the favorites, loop through and delete each model
        $this->favorites()->where($attributes)->get()->each(function ($favorite) {
            $favorite->delete();
        });
    }


    public function isFavorited()
    {
        return !! $this->favorites->where('user_id', auth()->id())->count();
    }

    public function getIsFavoritedAttribute() // $reply->isFavorited;
    {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}
