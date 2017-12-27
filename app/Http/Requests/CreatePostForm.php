<?php

namespace App\Http\Requests;

use App\User;
use App\Reply;
use App\Rules\SpamFree;
use Illuminate\Support\Facades\Gate;
use App\Exceptions\ThrottleException;
use App\Notifications\YouWereMentioned;
use Illuminate\Foundation\Http\FormRequest;

class CreatePostForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('create', new Reply);
    }

    public function failedAuthorization()
    {
        throw new ThrottleException(
            'You are posting to frequently. Please take a break',
            429
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => ['required', new SpamFree]
        ];
    }

    public function persist($thread)
    {
        $reply = $thread->addReply(
            [
                'user_id' => auth()->id(),
                'body' => request('body')
            ]
        );

        // Inspect the body of the reply for username mentions
        // preg_match = will only return the first match
        // preg_match_all = will return all matches
        // Create a reg exp https://regexr.com/
        preg_match_all('/\@([^\s\.]+)/', $reply->body, $matches);

        $names = $matches[1];
        // And then for each mentioned user, notify them

        foreach ($names as $name) {
            $user = User::whereName($name)->first();
            if ($user) {
                $user->notify(new YouWereMentioned($reply));
            }
        }

        return $reply->load('owner');
    }
}
