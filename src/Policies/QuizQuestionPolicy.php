<?php

namespace XtendLunar\Addons\QuizApp\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use XtendLunar\Addons\QuizApp\Models\QuizQuestion;

class QuizQuestionPolicy
{
    use HandlesAuthorization;

    public function allowRestify(User $user = null): bool
    {
        return true;
    }

    public function show(User $user = null, QuizQuestion $model): bool
    {
        return true;
    }

    public function store(User $user): bool
    {
        return true;
    }

    public function storeBulk(User $user): bool
    {
        return false;
    }

    public function update(User $user, QuizQuestion $model): bool
    {
        return true;
    }

    public function updateBulk(User $user, QuizQuestion $model): bool
    {
        return false;
    }

    public function deleteBulk(User $user, QuizQuestion $model): bool
    {
        return false;
    }

    public function delete(User $user, QuizQuestion $model): bool
    {
        return false;
    }
}
