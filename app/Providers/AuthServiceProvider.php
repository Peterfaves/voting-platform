<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Contestant;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Vote;
use App\Policies\CategoryPolicy;
use App\Policies\ContestantPolicy;
use App\Policies\EventPolicy;
use App\Policies\TicketPolicy;
use App\Policies\VotePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Event::class => EventPolicy::class,
        Category::class => CategoryPolicy::class,
        Contestant::class => ContestantPolicy::class,
        Ticket::class => TicketPolicy::class,
        Vote::class => VotePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}