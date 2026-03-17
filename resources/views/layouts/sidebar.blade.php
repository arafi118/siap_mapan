<style>
    .nav-link span {
        font-weight: normal !important;
    }
</style>
<!-- Sidebar -->
@if (auth()->user()->jabatan == 5)
    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
            <div class="sidebar-brand-text mx-3">{{ Session::get('nama_usaha') }}</div>
        </a>
        <br>
        <li class="nav-item active">
            <a class="nav-link fw-normal" href="/dashboard/usagesDashboard/?cater_id={{ auth()->user()->id }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item active">
            <a class="nav-link fw-normal" href="/usages/?cater_id={{ auth()->user()->id }}">
                <i class="fas fa-tint"></i>
                <span>Pemakaian Air Bersih</span>
            </a>
        </li>
        <li class="nav-item active">
            <a class="nav-link fw-normal" href="/usages/sampah/?cater_id={{ auth()->user()->id }}">
                <i class="fas fa-street-view"></i>
                <span>Retribusi Sampah</span>
            </a>
        </li>
    </ul>
@else
<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-text mx-3">{{ Session::get('nama_usaha') }}</div>
    </a>
    <br>
    @foreach (Session::get('menu') as $menu)
        @if ($menu->child->isEmpty())
            @if (!$loop->last)
                <hr class="sidebar-divider" style="margin-bottom: 0;">
            @endif
            <li class="nav-item active">
                <a class="nav-link fw-normal" href="{{ $menu->link }}">
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
                            <a class="dropdown-item" href="{{ $child->link }}">{{ $child->title }}</a>
                        @endforeach
                    </div>
                </div>
            </li>
        @endif
    @endforeach
</ul>
@endif
<!-- Sidebar -->
