<div class="container-fluid">
      <div class="row">
        <?php
        $uri_path = parse_url($_SERVER['REQUEST_URI'],
        PHP_URL_PATH);
        $uri_segments = explode('/', $uri_path);
        $menu       = $uri_segments[2];

        $userLogin = $_SESSION['ssUserRM']; 
        $cekUser   = mysqli_query($koneksi, "SELECT * FROM tb_user 
        WHERE username = '$userLogin'");
        $dataUser  = mysqli_fetch_assoc($cekUser);
        ?>
        <div
          class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary"
        >
          <div
            class="offcanvas-md offcanvas-end bg-body-tertiary"
            tabindex="-1"
            id="sidebarMenu"
            aria-labelledby="sidebarMenuLabel"
          >
            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="sidebarMenuLabel">
                Company name
              </h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="offcanvas"
                data-bs-target="#sidebarMenu"
                aria-label="Close"
              ></button>
            </div>
            <div
              class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto"
            >
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a
                    class="nav-link d-flex align-items-center gap-2 <?= $menu == 
                    'index.php' ? 'active' : null ?>"
                    aria-current="page"
                    href="<?= $main_url ?>">
                    <svg class="bi" aria-hidden="true">
                      <use xlink:href="#house-fill"></use>
                    </svg>
                    Dashboard
                  </a>
                </li>
                <?php 
                if ($dataUser['jabatan'] == 1) { ?>
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center gap-2 <?= $menu == 
                    'user' ? 'active' : null ?>" href="<?= $main_url ?>user">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-add" viewBox="0 0 16 16">
                    <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
                    <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
              </svg>
                    User
                  </a>
                </li>
                <?php } ?>
                <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 <?= $menu == 'password.php' ? 'active' : null ?>" 
                href="<?= $main_url ?>autentikasi/password.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-key" viewBox="0 0 16 16">
  <path d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8m4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5"/>
  <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
  </svg>
                    Ganti Password
                  </a>
                </li>
                </ul>

                  <h6
                class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-body-secondary text-uppercase">
                <span>Data</span>
              </h6>
                 <ul class="nav flex-column mb-auto">
                 <?php if ($dataUser['jabatan'] != 3) { ?>
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center gap-2 <?= $menu == 
                    'pasien' ? 'active' : null ?>" href="<?= $main_url ?>pasien">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-hearts" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M11.5 1.246c.832-.855 2.913.642 0 2.566-2.913-1.924-.832-3.421 0-2.566M9 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h10s1 0 1-1-1-4-6-4-6 3-6 4m13.5-8.09c1.387-1.425 4.855 1.07 0 4.277-4.854-3.207-1.387-5.702 0-4.276ZM15 2.165c.555-.57 1.942.428 0 1.711-1.942-1.283-.555-2.281 0-1.71Z"/>
</svg>
                    Pasien
                  </a>
                </li>
                <?php } ?>
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center gap-2 <?= $menu == 
                    'obat' ? 'active' : null ?>" href="<?= $main_url ?>obat">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-capsule" viewBox="0 0 16 16">
  <path d="M1.828 8.9 8.9 1.827a4 4 0 1 1 5.657 5.657l-7.07 7.071A4 4 0 1 1 1.827 8.9Zm9.128.771 2.893-2.893a3 3 0 1 0-4.243-4.242L6.713 5.429z"/>
</svg>
                    Obat
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center gap-2 <?= $menu == 
                    'rekamedis' ? 'active' : null ?>" href="<?= $main_url ?>rekamedis">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard2-pulse" viewBox="0 0 16 16">
  <path d="M9.5 0a.5.5 0 0 1 .5.5.5.5 0 0 0 .5.5.5.5 0 0 1 .5.5V2a.5.5 0 0 1-.5.5h-5A.5.5 0 0 1 5 2v-.5a.5.5 0 0 1 .5-.5.5.5 0 0 0 .5-.5.5.5 0 0 1 .5-.5z"/>
  <path d="M3 2.5a.5.5 0 0 1 .5-.5H4a.5.5 0 0 0 0-1h-.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1H12a.5.5 0 0 0 0 1h.5a.5.5 0 0 1 .5.5v12a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5z"/>
  <path d="M9.979 5.356a.5.5 0 0 0-.968.04L7.92 10.49l-.94-3.135a.5.5 0 0 0-.926-.08L4.69 10H4.5a.5.5 0 0 0 0 1H5a.5.5 0 0 0 .447-.276l.936-1.873 1.138 3.793a.5.5 0 0 0 .968-.04L9.58 7.51l.94 3.135A.5.5 0 0 0 11 11h.5a.5.5 0 0 0 0-1h-.128z"/>
</svg>
                    Rekam Medis
                  </a>
                </li>
              <h6
                class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-body-secondary text-uppercase"
              >
                <span>Laporan</span>
              </h6>
              <ul class="nav flex-column mb-auto">
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center gap-2 <?= $menu == 
                    'riwayat-perekaman' ? 'active' : null ?>" href="<?= $main_url ?>riwayat-perekaman">
                    <svg class="bi" aria-hidden="true">
                      <use xlink:href="#file-earmark-text"></use>
                    </svg>
                    Riwayat Perekaman
                    
              <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-body-secondary text-uppercase">
                <span>Administrasi</span>
              </h6>

              <ul class="nav flex-column mb-auto">
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center gap-2 <?= $menu == 'pembayaran' ? 'active' : null ?>"
                     href="<?= $main_url ?>pembayaran">
                    <i class="bi bi-cash-stack"></i>
                    Pembayaran
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center gap-2 <?= $menu == 'asuransi' ? 'active' : null ?>"
                     href="<?= $main_url ?>asuransi">
                    <i class="bi bi-shield-check"></i>
                    BPJS & Asuransi
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center gap-2 <?= $menu == 'report-dokter' ? 'active' : null ?>"
                     href="<?= $main_url ?>report-dokter">
                    <i class="bi bi-clipboard-data"></i>
                    Report Dokter
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center gap-2 <?= $menu == 'nota' ? 'active' : null ?>"
                     href="<?= $main_url ?>nota">
                    <i class="bi bi-receipt"></i>
                    Nota Pembayaran
                  </a>
                </li>
              </ul>

                  </a>
                </li>
            </div>
          </div>
        </div>