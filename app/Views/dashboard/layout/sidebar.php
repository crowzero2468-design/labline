  <!-- ==========================================
         START: Sidebar Component
         Highly polished, dark-green sticky navigation
         ========================================== -->
  <?php
    $currentUri = strtolower(trim(uri_string(), '/'));
  ?>

  <div class="sidebar-wrapper" id="sidebar">
    <!-- Brand Logo / Identity -->
    <a href="<?= site_url('dashboard') ?>" class="sidebar-brand" style="display: inline-block;">
      <img src="<?= base_url('img/logo.php') ?>" alt="LABLINE INC." style="height: 50px; width: auto; display: block; filter: drop-shadow(0 0 6px rgba(0, 0, 0, 0.35)); animation: logo-breathe-shadow 2.8s ease-in-out infinite;">
    </a>

    <style>
      @keyframes logo-breathe-shadow {
        0%, 100% {
          filter: drop-shadow(0 0 6px rgba(0, 0, 0, 0.25)) drop-shadow(0 0 14px rgba(0, 0, 0, 0.12));
          transform: translateY(0);
        }
        50% {
          filter: drop-shadow(0 0 12px rgba(0, 0, 0, 0.5)) drop-shadow(0 0 24px rgba(0, 0, 0, 0.2));
          transform: translateY(-1px);
        }
      }
    </style>

    <!-- Navigation Menu -->
    <div class="flex-grow-1 overflow-y-auto">
      <!-- Group: Menu -->
      <div class="sidebar-menu-section">
        <div class="sidebar-menu-title">Menu</div>
        <ul class="sidebar-menu-list">
          <li class="sidebar-menu-item">
            <a href="<?= site_url('dashboard') ?>" class="sidebar-menu-link <?= ($currentUri === 'dashboard') ? 'active' : '' ?>" id="menu-overview" title="Overview">
              <i class="bi bi-grid-fill"></i>
              <span>Dashboard</span>
            </a>
          </li>
        </ul>
      </div>

      <!-- Group: Components -->
      <div class="sidebar-menu-section">
        <div class="sidebar-menu-title">Tools</div>
        <ul class="sidebar-menu-list">
          <li class="sidebar-menu-item">
            <a href="<?= site_url('404') ?>" class="sidebar-menu-link <?= ($currentUri === '404') ? 'active' : '' ?>" id="menu-map" title="Clinic Map">
              <i class="bi bi-geo-alt-fill"></i>
              <span>Map</span>
            </a>
          </li>
          <li class="sidebar-menu-item">
            <a href="<?= site_url('dashboard/support') ?>" class="sidebar-menu-link <?= ($currentUri === 'dashboard/support') ? 'active' : '' ?>" id="menu-support" title="Support Tickets">
              <i class="bi bi-ticket-perforated"></i>
              <span>Support</span>
            </a>
          </li>
          <?php if ((int) (session()->get('user')['role'] ?? 0) === 2): ?>
            <li class="sidebar-menu-item">
              <a href="<?= site_url('dashboard/user') ?>" class="sidebar-menu-link <?= ($currentUri === 'dashboard/user' || $currentUri === 'dashboard/users') ? 'active' : '' ?>" id="menu-users" title="Users">
                <i class="bi bi-people-fill"></i>
                <span>Users</span>
              </a>
            </li>
          <?php endif; ?>
          <li class="sidebar-menu-item">
            <a href="<?= site_url('dashboard/history') ?>" class="sidebar-menu-link <?= ($currentUri === 'dashboard/history' || $currentUri === 'history') ? 'active' : '' ?>" id="menu-history" title="Support History">
              <i class="bi bi-clock-history"></i>
              <span>Support History</span>
            </a>
          </li>
        </ul>

          <?php
          $equipmentActive = in_array($currentUri, [
              'dashboard/pms',
              'mfs',
              'fsr',
              'monitoring'
          ]);
          ?>

          <li class="sidebar-menu-item">

              <a href="#equipmentMenu"
                class="sidebar-menu-link <?= $equipmentActive ? 'active' : 'collapsed' ?>"
                data-bs-toggle="collapse"
                role="button"
                aria-expanded="<?= $equipmentActive ? 'true' : 'false' ?>"
                aria-controls="equipmentMenu">

                  <i class="bi bi-tools"></i>
                  <span>PMS | MSF | FSR</span>
                  <i class="bi bi-chevron-down ms-auto"></i>
              </a>

              <ul class="collapse sidebar-submenu <?= $equipmentActive ? 'show' : '' ?>"
                  id="equipmentMenu">

                  <!-- PMS -->
                  <li class="sidebar-menu-item">
                      <a href="<?= site_url('dashboard/pms') ?>"
                        class="sidebar-menu-link <?= ($currentUri === 'dashboard/pms') ? 'active' : '' ?>"
                        id="menu-pms">
                          <i class="bi bi-wrench"></i>
                          <span>PMS</span>
                      </a>
                  </li>

                  <!-- MFS -->
                  <li class="sidebar-menu-item">
                      <a href="<?= site_url('mfs') ?>"
                        class="sidebar-menu-link <?= ($currentUri === 'mfs') ? 'active' : '' ?>"
                        id="menu-mfs">
                          <i class="bi bi-clipboard-check"></i>
                          <span>MSF</span>
                      </a>
                  </li>

                  <!-- FSR -->
                  <li class="sidebar-menu-item">
                      <a href="<?= site_url('fsr') ?>"
                        class="sidebar-menu-link <?= ($currentUri === 'fsr') ? 'active' : '' ?>"
                        id="menu-fsr">
                          <i class="bi bi-file-earmark-text"></i>
                          <span>FSR</span>
                      </a>
                  </li>

                  <li class="sidebar-menu-item">
                      <a href="<?= site_url('monitoring') ?>"
                        class="sidebar-menu-link <?= ($currentUri === 'monitoring') ? 'active' : '' ?>"
                        id="menu-monitoring">
                          <i class="bi bi-calendar-check"></i>
                          <span>MONTHLY LOG</span>
                      </a>
                  </li>

              </ul>
          </li>


          <li class="sidebar-menu-item">
              <a href="<?= site_url('rotor_replace') ?>"
                class="sidebar-menu-link <?= ($currentUri === 'rotor_replace') ? 'active' : '' ?>"
                id="menu-rotor-replace">

                  <i class="bi bi-wrench"></i>
                  <span>Rotor Replacement</span>

              </a>
          </li>

          <li class="sidebar-menu-item">
                      <a href="<?= site_url('dashboard/receipts') ?>"
                        class="sidebar-menu-link <?= ($currentUri === 'dashboard/receipts') ? 'active' : '' ?>"
                        id="menu-receipts">
                          <i class="bi bi-wrench"></i>
                          <span>Upload Receipt</span>
                      </a>
                  </li>

            
          <li class="sidebar-menu-item">
                      <a href="<?= site_url('404') ?>" class="sidebar-menu-link <?= ($currentUri === '404') ? 'active' : '' ?>" id="menu-map" title="Clinic Map">
                        <i class="bi bi-geo-alt-fill"></i>
                        <span>Accounting</span>
                      </a>
                    </li>
                            
                </div>

      <!-- Group: Pages -->
      <!-- <div class="sidebar-menu-section">
        <div class="sidebar-menu-title">Pages</div>
        <ul class="sidebar-menu-list">
          <li class="sidebar-menu-item">
            <a href="page-blank.html" class="sidebar-menu-link" id="menu-blankpage" title="Blank Page">
              <i class="bi bi-file-earmark"></i>
              <span>Blank Page</span>
            </a>
          </li>
          <li class="sidebar-menu-item">
            <a href="page-login.html" class="sidebar-menu-link" id="menu-loginpage" title="Login Page">
              <i class="bi bi-box-arrow-in-right"></i>
              <span>Login Screen</span>
            </a>
          </li>
          <li class="sidebar-menu-item">
            <a href="page-404.html" class="sidebar-menu-link" id="menu-404" title="404 Page">
              <i class="bi bi-slash-circle"></i>
              <span>Error 404</span>
            </a>
          </li>
        </ul>
      </div> -->
    </div>

    <!-- Sidebar Profile Card (Dynamic Footer) -->
    <?php
      $currentUser = session()->get('user') ?? [];
      $userRole = (int) ($currentUser['role'] ?? 0);
      $userRoleLabel = $userRole === 2 ? 'Admin' : 'User';
    ?>
    <div class="sidebar-profile">
      <img src="<?= base_url('assets/images/avatar.png') ?>" alt="Administrator" class="sidebar-profile-img">
      <div class="sidebar-profile-info">
        <div class="sidebar-profile-name"><?= esc(($currentUser['fname'] ?? '') . ' ' . ($currentUser['lname'] ?? '')) ?: 'User' ?></div>
        <div class="sidebar-profile-email"><?= esc($userRoleLabel) ?></div>
      </div>
    </div>
  </div>
  <!-- ==========================================
         END: Sidebar Component
         ========================================== -->
