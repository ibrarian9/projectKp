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
              <a class="collapse-item" href="">Psy-Tahfidz Juz 30</a>
              <a class="collapse-item" href="cards.html">Psy-Tahfidz 5 Juz</a>
              <a class="collapse-item" href="buttons.html"
                >Psy-Debat B. Indonesia</a
              >
              <a class="collapse-item" href="cards.html"
                >Psy-Debat B. Inggris</a
              >
              <a class="collapse-item" href="buttons.html">Psy-Cerdas Cermat</a>
              <h6 class="collapse-header">Modus Daring-2</h6>
                @foreach($menu as $row)
                    <a class="collapse-item" href="cards.html">{{$row->menu}}</a>

                @endforeach
              <a class="collapse-item" href="cards.html">Psy-Esai</a>
              <a class="collapse-item" href="PsyPaper.html">Psy-Paper</a>
              <a class="collapse-item" href="cards.html">Psy-Proposal</a>
              <a class="collapse-item" href="buttons.html">Psy-HCMotion</a>
              <h6 class="collapse-header">Modus Daring-3</h6>
              <a class="collapse-item" href="cards.html">Psy-Qira'ah</a>
              <a class="collapse-item" href="cards.html">Psy-Photografi</a>
              <a class="collapse-item" href="cards.html">Psy-Roster</a>
              <a class="collapse-item" href="cards.html">Psy-Dakwah</a>
              <a class="collapse-item" href="cards.html">Psy-Lagu Religi</a>
              <a class="collapse-item" href="cards.html"
                >Psy-Cerita Pendek Islami</a
              >
              <a class="collapse-item" href="cards.html">Psy-Pantun</a>
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
              <a class="collapse-item" href="penilaianpsyfotografi.html"
                >Psy-Tahfidz Juz 30</a
              >
              <a class="collapse-item" href="cards.html">Psy-Tahfidz 5 Juz</a>
              <a class="collapse-item" href="buttons.html"
                >Psy-Debat B. Indonesia</a
              >
              <a class="collapse-item" href="cards.html"
                >Psy-Debat B. Inggris</a
              >
              <a class="collapse-item" href="buttons.html">Psy-Cerdas Cermat</a>
              <h6 class="collapse-header">Modus Daring-2</h6>
              <a class="collapse-item" href="{{route('PenilaianEsai')}}">Psy-Esai</a>
              <a class="collapse-item" href="{{route('PenilaianPaper')}}">Psy-Paper</a>
              <a class="collapse-item" href="{{route('PenilaianProposal')}}"
                >Psy-Proposal</a
              >
              <a class="collapse-item" href="{{route('PenilaianHCMotion')}}"
                >Psy-HCMotion</a
              >
              <h6 class="collapse-header">Modus Daring-3</h6>
              <a class="collapse-item" href="{{route('PenilaianQiraah')}}"
                >Psy-Qira'ah</a
              >
              <a class="collapse-item" href="{{route('PenilaianFotografi')}}"
                >Psy-Fotografi</a
              >
              <a class="collapse-item" href="{{route('PenilaianPoster')}}"
                >Psy-Poster</a
              >
              <a class="collapse-item" href="{{route('PenilaianDakwah')}}"
                >Psy-Dakwah</a
              >
              <a class="collapse-item" href="PenilaianPsyLaguReligi.html"
                >Psy-Lagu Religi</a
              >
             <a class="collapse-item" href="{{route('PenilaianCerpen')}}"
                >Psy-Cerita Pendek Islami</a
              >
              <a class="collapse-item" href="cards.html">Psy-Pantun</a>
            </div>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="">
            <span>Nilai Peserta</span></a
          >
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('indexPengguna')}}">
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
