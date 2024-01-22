<ul
        class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"
        id="accordionSidebar"
      >
        <a class="sidebar-brand d-flex align-items-center" href="index.html">
          <div class="sidebar-brand-text mx-3">IPCOM</div>
        </a>

        <hr class="sidebar-divider my-0" />

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
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Modus Daring-1</h6>
                @foreach($namaLomba as $row)
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
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Modus Daring-1</h6>
              @foreach($namaLomba as $item)
                    <a class="collapse-item" href="{{$item->id_tim_lomba}}">{{$item->nama_lomba}}</a>
              @endforeach
            </div>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{route('dataUsers')}}">
            <span>Manajemen Pengguna</span></a
          >
        </li>

        <li class="nav-item">
            @csrf
            <a class="nav-link" href="{{route('logout')}}">
                <span>Keluar</span></a>
        </li>

        <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
      </ul>
