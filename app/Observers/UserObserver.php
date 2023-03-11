<?php

namespace App\Observers;

use App\Models\User;
use Faker\Provider\zh_CN\Person;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;

class UserObserver
{
    /**
     */
    public function creating(User $user): void
    {
        if (!$user->name) {
            $user->name = Person::firstNameMale();
        }

        $user->email_md5 = md5($user->email);
        $user->uuid = Str::uuid();
    }

    public function created(User $user): void
    {
        event(new Registered($user));
    }

    public function updating(User $user): void
    {
        if ($user->isDirty('banned_at')) {
            if ($user->banned_at) {
                $user->tokens()->delete();
            }
        }

        if ($user->isDirty('email')) {
            $user->email_md5 = md5($user->email);
        }

        if ($user->isDirty('id_card') || $user->isDirty('real_name')) {
            if (empty($user->id_card) || empty($user->real_name)) {
                $user->real_name_verified_at = null;
            } else {
                $user->real_name_verified_at = now();
                $user->birthday_at = $user->getBirthdayFromIdCard();
            }
        }
    }

    public function forceDeleted(User $user): void
    {
        $user->tokens()->delete();
        $user->clients()->delete();
        $user->balances()->delete();
    }
}
