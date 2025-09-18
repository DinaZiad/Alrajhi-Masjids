@props(['items' => []])

<nav class="main-navbar fixed-navbar">
    <div class="navbar-content breadcrumb-nav breadcrumb-nav-top">
        @foreach($items as $index => $item)
            @if($index === 0)
                {{-- First item (main section) - always non-clickable --}}
                <span class="breadcrumb-current" style="color:#d4af37;">{{ $item['title'] }}</span>
            @elseif($index === count($items) - 1)
                {{-- Last item (current page) --}}
                <span class="breadcrumb-sep" style="color:white">&larr;</span>
                <span class="breadcrumb-current " style="color:white;">{{ $item['title'] }}</span>
            @else
                {{-- Middle items --}}
                <span class="breadcrumb-sep" style="color:white">&larr;</span>
                @if(isset($item['url']))
                    <a href="{{ $item['url'] }}" style="color:white;">{{ $item['title'] }}</a>
                @else
                    <span style="color:white;">{{ $item['title'] }}</span>
                @endif
            @endif
        @endforeach
    </div>
</nav>

<style>
.main-navbar.fixed-navbar {
    position: fixed;
    top: 0;
    right: 68px;
    left: 0;
    width: calc(100vw - 68px);
    background: #174032;
    padding: 0.7rem 0 0.7rem 0;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 12px rgba(23,64,50,0.07);
    z-index: 900;
    border-radius: 0 0 18px 0;
    transition: right 0.35s cubic-bezier(.4,0,.2,1), width 0.35s cubic-bezier(.4,0,.2,1);
}
.navbar-content {
    max-width: 95vw;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    direction: rtl;
    gap: 0.7em;
    font-size: 1.08rem;
    font-weight: 700;
    padding-right: 2.5rem;
}
@media (max-width: 900px) {
    .navbar-content {
        padding-right: 1rem;
    }
    .main-navbar.fixed-navbar {
        right: 56px;
        width: calc(100vw - 56px);
    }
}
.sider {
    z-index: 1001 !important;
}
.sider:not(.sider-collapsed) ~ .main-navbar.fixed-navbar {
    right: 320px;
    width: calc(100vw - 320px);
}
</style>