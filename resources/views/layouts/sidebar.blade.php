<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-text mx-3">{{ Session::get('nama_usaha') }}</div>
    </a>
    <br>
    @foreach (Session::get('menu') as $menu)
        @if ($menu->status == 'A')
            @if ($menu->child->isEmpty())
                @if (!$loop->last)
                    <hr class="sidebar-divider" style="margin-bottom: 0;">
                @endif
                <li class="nav-item active">
                    <a class="nav-link" href="{{ $menu->link }}">
                        <i class="{{ $menu->icon }}"></i>
                        <span>{{ $menu->title }}</span>
                    </a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse"
                        data-target="#collapse{{ $menu->id }}" aria-expanded="true"
                        aria-controls="collapse{{ $menu->id }}">
                        <i class="{{ $menu->icon }}"></i>
                        <span>{{ $menu->title }}</span>
                    </a>
                    <div id="collapse{{ $menu->id }}" class="collapse" aria-labelledby="heading{{ $menu->id }}"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            @foreach ($menu->child as $child)
                                @if ($child->status == 'A')
                                    <a class="dropdown-item" href="{{ $child->link }}">{{ $child->title }}</a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </li>
            @endif
        @endif
    @endforeach
</ul>
<!-- Sidebar -->
