<!-- Primary Navigation Menu -->
<nav class="primary flex text-center" aria-label="{{ __('main menu') }}" x-data="{ 'open': false }" @click.away="open = false">
    <button class="borderless" x-bind:aria-expanded="open.toString()" x-on:click="open = !open"
        @keyup.escape.window="open = false" x-cloak>
        @svg('heroicon-o-bars-3', 'indicator')<span>{{ __('Menu') }}</span>
    </button>
    <ul role="list">
        @auth
            <li>
                <x-nav-link :href="localized_route('dashboard')" :active="request()->localizedRouteIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-nav-link>
            </li>
            @if (Auth::user()->hasVerifiedEmail() && Auth::user()->can('viewOwned', 'App\Models\Project'))
                <li>
                    <x-nav-link :href="Auth::user()->isAdministrator()
                        ? localized_route('projects.all-projects')
                        : localized_route('projects.my-projects')" :active="request()->localizedRouteIs('projects.my-projects')">
                        {{ __('Projects') }}
                    </x-nav-link>
                </li>
            @endif
        @else
            <li class="account">
                <x-nav-link :href="localized_route('register')">
                    {{ __('Create an account') }}
                </x-nav-link>
            </li>
            <li>
                <x-nav-link :href="localized_route('login')">
                    {{ __('Sign in') }}
                </x-nav-link>
            </li>
        @endauth

        @auth
            @if (Auth::user()->hasVerifiedEmail() &&
                    Auth::user()->can('viewAny', 'App\Models\Individual') &&
                    Auth::user()->can('viewAny', 'App\Models\Organization') &&
                    Auth::user()->can('viewAny', 'App\Models\RegulatedOrganization'))
                <li>
                    <x-nav-link :href="localized_route('people-and-organizations')">
                        {{ __('People and organizations') }}
                    </x-nav-link>
                </li>
            @endif
            <li>
                <x-nav-link :href="localized_route('resource-collections.index')" :active="request()->localizedRouteIs('resource-collections.index')">
                    {{ __('Resources and training') }}
                </x-nav-link>
            </li>
            <li class="account">
                <x-nav-link href="{{ localized_route('settings.show') }}" :active="request()->localizedRouteIs('users.settings')">
                    @svg('heroicon-o-cog') {{ __('My settings') }}
                </x-nav-link>
            </li>
            <!-- Authentication -->
            <li>
                <form method="POST" action="{{ localized_route('logout') }}">
                    @csrf
                    <button class="nav-button">
                        {{ __('Sign out') }}
                    </button>
                </form>
            </li>
        @endauth
    </ul>
</nav>
