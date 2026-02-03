<?php

namespace App\Http\View\Composers;

use App\Models\Withdrawal;
use Illuminate\View\View;

class AdminComposer
{
    public function compose(View $view)
    {
        $view->with('pendingWithdrawalsCount', Withdrawal::pending()->count());
    }
}