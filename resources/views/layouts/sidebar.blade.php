<ul
    class="navbar-nav sidebar sidebar-dark accordion" style="background-color: rgba(191, 28, 199, 0.8)"
    id="accordionSidebar"
>
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('dashboard')}}">
        <img src="<?= asset('img/logo ipcom - nobg.png') ?>" alt="logo ipcom" style='width: 50px'>
    </a>

    <hr class="sidebar-divider my-0"/>

    <li class="nav-item active">
        <a class="nav-link" href="{{route('dashboard')}}"> <span>Beranda</span></a>
    </li>

    <li class="nav-item">
        <a
            class="nav-link collapsed"
            href="#"
            data-toggle="collapse"
            data-target="#collapseTwo"
            aria-expanded="true"
            aria-controls="collapseTwo"
        >
            <span>Data Peserta</span>
        </a>
        <div
            id="collapseTwo"
            class="collapse"
            aria-labelledby="headingTwo"
            data-parent="#accordionSidebar"
        >
            <div class="bg-white py-2 collapse-inner rounded" style="overflow:hidden">
                <h6 class="collapse-header">Kategori Lomba</h6>
                @foreach($dataLomba as $row)
                    <a class="collapse-item" href="{{route('tampil', $row->id_lomba)}}">{{$row->nama_lomba}}</a>
                @endforeach
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a
            class="nav-link collapsed"
            href="#"
            data-toggle="collapse"
            data-target="#collapseUtilities"
            aria-expanded="true"
            aria-controls="collapseUtilities"
        >
            <span>Input Penilaian</span>
        </a>
        <div
            id="collapseUtilities"
            class="collapse"
            aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar"
        >
            <div class="bg-white py-2 collapse-inner rounded" style="overflow:hidden">
                <h6 class="collapse-header">Nomor Perlombaan</h6>
                @if(Auth::user()->id_role == 1)
                    @foreach($dataNomorLomba as $item)
                        <a class="collapse-item"
                           href="{{route('penilaian', $item->id_nomor_perlombaan)}}">{{$item->id_nomor_perlombaan." ".$item->nomor_lomba}}</a>
                    @endforeach
                @elseif(Auth::user()->id_role == 2)
                    @foreach($dataNomorLombaByJuri as $item)
                        <a class="collapse-item"
                           href="{{route('penilaian', $item->id_nomor_perlombaan)}}">{{$item->nomor_lomba}}</a>
                    @endforeach
                @endif
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{route('kategoriNomorLomba')}}">
            <span>Kategori Nomor Perlombaan</span></a
        >
    </li>
    {{--Role Admin--}}
    @if(Auth::user()->id_role == 1)
        <li class="nav-item">
            <a class="nav-link" href="{{route('dataUsers')}}">
                <span>Manajemen Pengguna</span></a
            >
        </li>
        {{--Role Juri--}}
    @elseif(Auth::user()->id_role == 2)

    @endif
    <li class="nav-item">
        @csrf
        <a class="nav-link" href="{{route('logout')}}">
            <span>Keluar</span></a>
    </li>

    <li class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </li>
</ul>
