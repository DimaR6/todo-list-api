<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('magicLinks.index') }}" class="nav-link {{ Request::is('magicLinks*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-book"></i>
        <p>Magic Links</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('luckyDraws.index') }}" class="nav-link {{ Request::is('luckyDraws*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-dice"></i>
        <p>Roll The Dice</p>
    </a>
</li>