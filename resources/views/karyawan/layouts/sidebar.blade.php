<aside class="sidebar">
    <div class="sidebar-start">
        <div class="sidebar-head">
            <a href="/" class="logo-wrapper" title="Home">
                <span class="sr-only">Home</span>
                <span class="icon logo" aria-hidden="true"></span>
                <div class="logo-text">
                <span class="logo-subtitle">
                    @if(Auth::user()->role->role === 'kaprodi')
                        Kaprodi
                    @elseif(Auth::user()->role->role === 'tu')
                        Tata Usaha
                    @else
                        {{ Auth::user()->role->role }}
                    @endif
                </span>
                </div>
            </a>
            <button class="sidebar-toggle transparent-btn" title="Menu" type="button">
                <span class="sr-only">Toggle menu</span>
                <span class="icon menu-toggle" aria-hidden="true"></span>
            </button>
        </div>
        <div class="sidebar-body">
        <ul class="sidebar-body-menu">
            <li>
                <a href="{{ route('karyawan.dashboard', ['view' => 'main']) }}">
                    <span class="icon home" aria-hidden="true"></span>Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('karyawan.dashboard', ['view' => 'history']) }}">
                    <span class="icon document" aria-hidden="true"></span>History
                </a>
            </li>
        </ul>
        </div>
    </div>
    <div class="sidebar-footer">
        <a href="##" class="sidebar-user">
            <span class="sidebar-user-img">
                <picture><source srcset="{{ asset('asset/img/avatar/avatar-illustrated-01.webp')}}" type="image/webp"><img src="{{ asset('asset/img/avatar/avatar-illustrated-01.png')}}" alt="User name"></picture>
            </span>
            <div class="sidebar-user-info">
                <span class="sidebar-user__title">{{ Auth::user()->nama}}</span>
                <span class="sidebar-user__subtitle">{{ Auth::user()->programStudi->nama_prodi }}</span>
            </div>
        </a>
    </div>
</aside>
