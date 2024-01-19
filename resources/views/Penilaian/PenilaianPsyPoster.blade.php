<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>SB Admin 2 - Tables</title>

    <!-- Custom fonts for this template -->
    <link
      href="/vendor/fontawesome-free/css/all.min.css"
      rel="stylesheet"
      type="text/css"
    />
    <link
      href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
      rel="stylesheet"
    />

    <!-- Custom styles for this template -->
    <link href="/css/sb-admin-2.min.css" rel="stylesheet" />

    <!-- Custom styles for this page -->
    <link
      href="/vendor/datatables/dataTables.bootstrap4.min.css"
      rel="stylesheet"
    />
  </head>

  <body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
      <!-- Sidebar -->
      <ul
        class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"
        id="accordionSidebar"
      >
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center" href="index.html">
          <div class="sidebar-brand-text mx-3">IPCOM</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0" />

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
          <a class="nav-link" href="index.html"> <span>Beranda</span></a>
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
            <span>Online</span>
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
                >Psy-Debat Bahasa Indonesia</a
              >
              <a class="collapse-item" href="cards.html"
                >Psy-Debat Bahasa Inggris</a
              >
              <a class="collapse-item" href="buttons.html">Psy-Cerdas Cermat</a>
              <h6 class="collapse-header">Modus Daring-2</h6>
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
            <span>Penilaian</span>
          </a>
          <div
            id="collapseUtilities"
            class="collapse"
            aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar"
          >
            <div
              class="bg-white py-2 collapse-inner rounded"
              style="overflow: hidden"
            >
              <h6 class="collapse-header">Modus Daring-1</h6>
              <a class="collapse-item" href="penilaianpsyfotografi.html"
                >Psy-Tahfidz Juz 30</a
              >
              <a class="collapse-item" href="cards.html">Psy-Tahfidz 5 Juz</a>
              <a class="collapse-item" href="buttons.html"
                >Psy-Debat Bahasa Indonesia</a
              >
              <a class="collapse-item" href="cards.html"
                >Psy-Debat Bahasa Inggris</a
              >
              <a class="collapse-item" href="buttons.html">Psy-Cerdas Cermat</a>
              <h6 class="collapse-header">Modus Daring-2</h6>
              <a class="collapse-item" href="PenilaianPsyEsai.html">Psy-Esai</a>
              <a class="collapse-item" href="PenilaianPsyPaper.html"
                >Psy-Paper</a
              >
              <a class="collapse-item" href="PenilaianPsyProposal.html"
                >Psy-Proposal</a
              >
              <a class="collapse-item" href="PenilaianPsyHCMotion.html"
                >Psy-HCMotion</a
              >
              <h6 class="collapse-header">Modus Daring-3</h6>
              <a class="collapse-item" href="PenilaianPsyQiraah.html"
                >Psy-Qira'ah</a
              >
              <a class="collapse-item" href="PenilaianPsyFotografi.html"
                >Psy-Fotografi</a
              >
              <a class="collapse-item" href="#">Psy-Poster</a>
              <a class="collapse-item" href="PenilaianPsyDakwah.html"
                >Psy-Dakwah</a
              >
              <a class="collapse-item" href="PenilaianPsyLaguReligi.html"
                >Psy-Lagu Religi</a
              >
              <a class="collapse-item" href="PenilaianPsyCerpenIslami.html"
                >Psy-Cerita Pendek Islami</a
              >
              <a class="collapse-item" href="cards.html">Psy-Pantun</a>
            </div>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="tables.html">
            <span>Manajemen Pengguna</span></a
          >
        </li>

        <li class="nav-item">
          <a class="nav-link" href="tables.html"> <span>Keluar</span></a>
        </li>

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
      </ul>
      <!-- End of Sidebar -->

      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
          <!-- Topbar -->
          <nav
            class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"
          >
            <!-- Sidebar Toggle (Topbar) -->
            <form class="form-inline">
              <button
                id="sidebarToggleTop"
                class="btn btn-link d-md-none rounded-circle mr-3"
              >
                <i class="fa fa-bars"></i>
              </button>
            </form>

            <ul class="navbar-nav ml-auto">
              <div class="topbar-divider d-none d-sm-block"></div>

              <li class="nav-item dropdown no-arrow">
                <a
                  class="nav-link dropdown-toggle"
                  href="#"
                  id="userDropdown"
                  role="button"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  <span class="mr-2 d-none d-lg-inline text-gray-600 small"
                    >Douglas McGee</span
                  >
                  <img
                    class="img-profile rounded-circle"
                    src="img/undraw_profile.svg"
                  />
                </a>

                <div
                  class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                  aria-labelledby="userDropdown"
                >
                  <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                  </a>
                  <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                  </a>
                  <a class="dropdown-item" href="#">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                    Activity Log
                  </a>
                  <div class="dropdown-divider"></div>
                  <a
                    class="dropdown-item"
                    href="#"
                    data-toggle="modal"
                    data-target="#logoutModal"
                  >
                    <i
                      class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"
                    ></i>
                    Logout
                  </a>
                </div>
              </li>
            </ul>
          </nav>
          <!-- End of Topbar -->

          <!-- Begin Page Content -->
          <div class="container-fluid">
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                  FORM PENILAIAN DEWAN JURI LOMBA
                </h6>
              </div>

              <div class="card-body">
                <h1 class="h3 mb-2 text-gray-800"></h1>
                <h4 class="h5 mb-2 text-gray-800">Nama Juri :</h4>
                <h4 class="h5 mb-2 text-gray-800">Asal Universitas :</h4>
                <h4 class="h5 mb-2 text-gray-800">Tanggal Pemeriksaan :</h4>
                <!-- <div class="table-responsive"></div> -->
              </div>
            </div>
            <div
              class="d-sm-flex align-items-center justify-content-between mb-4"
            >
              <a
                href="adduser.html"
                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
                ><i></i> Tambah Data Peserta
              </a>
            </div>
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                  FORM PENILAIAN PESERTA
                </h6>
              </div>

              <div class="card-body">
                <div class="table-responsive">
                  <table
                    class="table table-bordered"
                    id="dataTable"
                    width="100%"
                    cellspacing="0"
                  >
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Peserta</th>
                        <th>Asal Universitas</th>
                        <th>Nilai Ide dan Kreativitas</th>
                        <th>Nilai Kesesuaian Konten dengan Tema/topik</th>
                        <th>Nilai Estetika Gambar</th>
                        <th>Nilai Komposisi Gambar</th>
                        <th>Total</th>
                        <th>Penilaian Kualitatif Juri</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>Muhammad Fari aja</td>
                        <td>UINSUSKA</td>
                        <td>25</td>
                        <td>30</td>
                        <td>25</td>
                        <td>20</td>
                        <td>100</td>
                        <td>
                          Secara umum, aspek-aspek penilaian dikuasai sangat
                          baik
                        </td>
                        <td>
                          <a
                            href="penilaian.html"
                            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
                            ><i></i> Edit</a
                          >
                          <a
                            href="penilaian.html"
                            class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"
                            ><i></i> Hapus</a
                          >
                                     
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Copyright &copy; Your Website 2020</span>
            </div>
          </div>
        </footer>
        <!-- End of Footer -->
      </div>
      <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div
      class="modal fade"
      id="logoutModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button
              class="close"
              type="button"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            Select "Logout" below if you are ready to end your current session.
          </div>
          <div class="modal-footer">
            <button
              class="btn btn-secondary"
              type="button"
              data-dismiss="modal"
            >
              Cancel
            </button>
            <a class="btn btn-primary" href="login.html">Logout</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="/js/demo/datatables-demo.js"></script>
  </body>
</html>
