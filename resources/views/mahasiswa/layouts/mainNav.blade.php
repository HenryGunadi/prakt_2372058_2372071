<nav class="main-nav--bg">
    <div class="container main-nav">
        <div class="main-nav-start">
            <div class="search-wrapper">
                <i data-feather="search" aria-hidden="true"></i>
                <input type="text" placeholder="Enter keywords ..." required>
            </div>
            </div>
            <div class="main-nav-end">
            <button class="sidebar-toggle transparent-btn" title="Menu" type="button">
                <span class="sr-only">Toggle menu</span>
                <span class="icon menu-toggle--gray" aria-hidden="true"></span>
            </button>
            <button class="theme-switcher gray-circle-btn" type="button" title="Switch theme">
                <span class="sr-only">Switch theme</span>
                <i class="sun-icon" data-feather="sun" aria-hidden="true"></i>
                <i class="moon-icon" data-feather="moon" aria-hidden="true"></i>
            </button>
            <div class="nav-user-wrapper">
                <button href="##" class="nav-user-btn dropdown-btn" title="My profile" type="button">
                <span class="sr-only">My profile</span>
                <span class="nav-user-img">
                    <picture><source srcset="{{asset('asset/img/avatar/avatar-illustrated-02.webp')}}" type="image/webp"><img src="{{asset('asset/img/avatar/avatar-illustrated-02.png')}}" alt="User name"></picture>
                </span>
                </button>
                <ul class="users-item-dropdown nav-user-dropdown dropdown">
                    <li>
                        <form method="POST" action="{{ route('mahasiswa.logout') }}" id="logout-form">
                            @csrf
                            <a class="danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i data-feather="log-out" aria-hidden="true"></i>
                                <span>Log out</span>
                            </a>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
