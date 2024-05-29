<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="dashboard">
            <img src="../assets/img/logo-ct.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold text-white">Admin Account Center</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('dashboard') ? 'active bg-gradient-primary' : '' }}" href="../dashboard">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">leaderboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Halaman Utama</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ in_array(Request::path(), ['data-karyawan']) ? 'active bg-gradient-primary' : '' }}
                " href="../data-karyawan">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">contact_page</i>
                    </div>
                    <span class="nav-link-text ms-1">Data Karyawan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('pengaturan-libur') ? 'active bg-gradient-primary' : '' }}" href="../pengaturan-libur">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">edit_calendar</i>
                    </div>
                    <span class="nav-link-text ms-1">Pengaturan Libur</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('pengajuan-pembaruan') ? 'active bg-gradient-primary' : '' }}" href="../pengajuan-pembaruan">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">edit_note</i>
                    </div>
                    <span class="nav-link-text ms-1">Pengajuan Pembaruan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('pengajuan-izin') ? 'active bg-gradient-primary' : '' }}" href="../pengajuan-izin">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">assignment_late</i>
                    </div>
                    <span class="nav-link-text ms-1">Pengajuan Izin</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('klasifikasi-karyawan') ? 'active bg-gradient-primary' : '' }}" href="../klasifikasi-karyawan">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">folder_shared</i>
                    </div>
                    <span class="nav-link-text ms-1">Klasifikasi Karyawan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('notifikasi') ? 'active bg-gradient-primary' : '' }}" href="../notifikasi">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">notifications</i>
                    </div>
                    <span class="nav-link-text ms-1">Notifikasi</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Pengaturan akun</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('manajemen-hak-akses') ? 'active bg-gradient-primary' : '' }}" href="../manajemen-hak-akses">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">manage_accounts</i>
                    </div>
                    <span class="nav-link-text ms-1">Manajemen Hak Akses</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('manajemen-hak-akses') ? 'active bg-gradient-primary' : '' }}" href="../manajemen-hak-akses">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">key</i>
                    </div>
                    <span class="nav-link-text ms-1">Ganti Password</span>
                </a>
            </li>

        </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0">
        <div class="mx-3">
            <li class="btn btn-outline-light mt-4 w-100">
                <a class="nav-link text-white {{ Request::is('sign-in') ? 'active bg-gradient-primary' : '' }}" href="logout">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">logout</i>
                    </div>
                    <span class="nav-link-text ms-1">Keluar</span>
                </a>
            </li>
        </div>
    </div>
</aside>
