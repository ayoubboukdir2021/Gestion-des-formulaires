

<div class="sidebar-menu">
    <ul class="menu">
        <li class="sidebar-title"> @if(Auth::user()->image != "" || Auth::user()->image != null) <img src="{{ asset('assets/users/'.Auth::user()->image) }}" alt="default" class="img-thumbnail" /> @else <img src="{{ asset('assets/users/default.png') }}" alt="..." class="img-thumbnail" /> @endif</li>

        <li class="sidebar-item @if($page=="dashboard") active @endif ">
            <a href="{{ route('home') }}" class='sidebar-link'>
                <i class="bi bi-grid-fill"></i>
                <span>Tableau de bord</span>
            </a>
        </li>

        <li class="sidebar-item  has-sub @if($page=="gestion-formulaire") active @endif">
            <a href="#" class='sidebar-link '>
                <i class="bi bi-file-earmark-spreadsheet-fill"></i>
                <span>Gestion Formulaire</span>
            </a>
            <ul class="submenu">
                <li class="submenu-item">
                    <a href="{{ route('index.forms') }}">List des formulaires</a>
                </li>
                <li class="submenu-item">
                    <a href="{{ route('create.form') }}">Créer un formulaire</a>
                </li>
            </ul>


        </li>

        <li class="sidebar-item  has-sub @if($page=="gestion-utilisateurs") active @endif">
            <a href="#" class='sidebar-link'>
                <i class="bi bi-person-badge-fill"></i>
                <span>Gestion des utilisateurs</span>
            </a>
            <ul class="submenu">
                <li class="submenu-item">
                    <a href="{{ route('add.admin') }}">Ajouter un administrateur - superviseur</a>
                </li>
                <li class="submenu-item">
                    <a href="{{ route('list.users') }}">List des utilisateur</a>
                </li>
            </ul>
        </li>

        <li class="sidebar-item @if($page=="profile") active @endif">
            <a href="{{ route('admin.profile') }}" class='sidebar-link'>
                <i class="bi bi-card-image"></i>
                <span>Profile</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a href="{{ route('logout') }}" class='sidebar-link' onclick="event.preventDefault();document.getElementById('logout').submit()">
                <i class="bi bi-outlet"></i>
                <span>Logout</span>
            </a>
            <form action="{{ route('logout') }}" method="POST" id="logout">
                @csrf
            </form>
        </li>
    </ul>
</div>

</div>



