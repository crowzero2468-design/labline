    <!-- START: Top Navbar Component -->
    <header class="navbar-custom">
      <div class="navbar-left">
        <!-- Desktop sidebar toggle (visible on large screens only) -->
        <button class="btn-desktop-toggle d-none d-xl-flex align-items-center justify-content-center me-3"
          id="desktop-sidebar-toggle" aria-label="Minimize Sidebar">
          <i class="bi bi-chevron-bar-left"></i>
        </button>
        <!-- Mobile sidebar toggle -->
        <button class="sidebar-toggle-btn me-2" id="sidebar-toggle" aria-label="Toggle Navigation">
          <i class="bi bi-list"></i>
        </button>

        <!-- Quick Actions Dropdown -->
        <div class="dropdown ms-2">
          <!-- <button class="btn-quick-action dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"
            id="quick-actions-dropdown">
            <i class="bi bi-plus-lg"></i>
            <span>Create</span>
          </button>
          <ul class="dropdown-menu dropdown-menu-quick-action" aria-labelledby="quick-actions-dropdown">
            <li class="dropdown-header">Quick Action Shortcuts</li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-file-earmark-plus"></i> New Invoice</a></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-person-plus"></i> New User</a></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-box-seam"></i> New Product</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> System Settings</a></li>
          </ul> -->
        </div>
      </div>

      <!-- Mid navbar: search pill -->
      <div class="navbar-search-wrapper">
        <!-- <input type="text" class="navbar-search-input" placeholder="Search anything in Spark..." id="main-search">
        <button class="navbar-search-btn" aria-label="Search">
          <i class="bi bi-search"></i>
        </button> -->
      </div>

      <!-- Right actions -->
      <?php
        $todaySupportNotifications = [];
        $todayDate = date('Y-m-d');
        try {
          $supportDatabase = db_connect();
          if ($supportDatabase->tableExists('tb_support')) {
              $todaySupportNotifications = $supportDatabase->table('tb_support')
                  ->select('id, clinic_name, machine, technician, status, support_date, concern, created_at')
                  ->where('support_date', $todayDate)
                  ->whereIn('status', ['ongoing', 'done', 'pullout', 'canceled', 'unservicable'])
                  ->orderBy('created_at', 'DESC')
                  ->get()
                  ->getResultArray();
          }
        } catch (Throwable $e) {
          $todaySupportNotifications = [];
        }
      ?>
      <div class="navbar-actions">
        <!-- Fullscreen Toggle -->
        <button class="navbar-action-btn me-1" aria-label="Toggle Fullscreen" id="btn-fullscreen">
          <i class="bi bi-arrows-fullscreen"></i>
        </button>
        <div class="dropdown">
          <button class="navbar-action-btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
            aria-expanded="false" id="btn-notifications" data-bs-auto-close="outside">
            <i class="bi bi-bell"></i>
            <?php if (!empty($todaySupportNotifications)): ?>
              <span class="navbar-action-badge"><?= count($todaySupportNotifications) ?></span>
            <?php endif; ?>
          </button>
          <div class="dropdown-menu dropdown-menu-end dropdown-menu-notification p-0"
            aria-labelledby="btn-notifications">
            <div class="notification-header">
              <h6 class="notification-title">Today's Support Updates</h6>
              <button class="btn-clear-all" type="button">Mark all read</button>
            </div>
            <div class="notification-list">
              <?php if (!empty($todaySupportNotifications)): ?>
                <?php foreach ($todaySupportNotifications as $notification): ?>
                  <?php
                    $notificationStatus = strtolower((string) ($notification['status'] ?? ''));
                    $notificationIcon = 'bi-wrench-adjustable';
                    $notificationClass = 'bg-primary';

                    if ($notificationStatus === 'done') {
                        $notificationIcon = 'bi-check-circle';
                        $notificationClass = 'bg-success';
                    } elseif ($notificationStatus === 'pullout') {
                        $notificationIcon = 'bi-box-arrow-up';
                        $notificationClass = 'bg-danger';
                    } elseif ($notificationStatus === 'canceled') {
                        $notificationIcon = 'bi-x-circle';
                        $notificationClass = 'bg-secondary';
                    } elseif ($notificationStatus === 'unservicable') {
                        $notificationIcon = 'bi-slash-circle';
                        $notificationClass = 'bg-dark';
                    } elseif ($notificationStatus === 'ongoing') {
                        $notificationIcon = 'bi-clipboard-check';
                        $notificationClass = 'bg-warning text-dark';
                    }
                  ?>
                  <a href="<?= site_url('dashboard/support') ?>" class="notification-item">
                    <div class="notification-icon <?= esc($notificationClass) ?> text-white">
                      <i class="bi <?= esc($notificationIcon) ?>"></i>
                    </div>
                    <div class="notification-content">
                      <p class="notification-text">
                        <strong><?= esc($notification['clinic_name'] ?? 'Support') ?></strong>
                        <?= $notificationStatus === 'ongoing' ? ' accepted the ticket' : ' status: ' . esc(ucfirst($notificationStatus)) ?>
                      </p>
                      <span class="notification-time"><?= esc($notification['machine'] ?? 'Machine') ?> • <?= esc($notification['technician'] ?? 'Technician') ?></span>
                    </div>
                    <span class="notification-unread-dot"></span>
                  </a>
                <?php endforeach; ?>
              <?php else: ?>
                <div class="notification-item text-muted px-3 py-3">
                  No support updates today.
                </div>
              <?php endif; ?>
            </div>
            <a href="<?= site_url('dashboard/support') ?>" class="notification-footer">View Support Tickets</a>
          </div>
        </div>

        <!-- Profile Dropdown -->
        <div class="dropdown ms-2">
          <button class="navbar-profile-btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
            aria-expanded="false" id="profile-dropdown">
            <img src="<?= base_url('assets/images/avatar.png') ?>" alt="Profile Image" class="navbar-profile-img">
            <span class="navbar-profile-name d-none d-md-inline">
                <?= esc(session()->get('user')['fname'] . ' ' . session()->get('user')['lname'] ?? 'User') ?>
            </span>
            <i class="bi bi-chevron-down navbar-profile-caret"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-profile" aria-labelledby="profile-dropdown">
            <li class="dropdown-header">Welcome !</li>
            <li><a class="dropdown-item" href="<?= site_url('404') ?>"><i class="bi bi-person"></i> My Account</a></li>
            <li><a class="dropdown-item" href="<?= site_url('404') ?>"><i class="bi bi-gear"></i> Settings</a></li>
            <li><a class="dropdown-item" href="<?= site_url('404') ?>"><i class="bi bi-lock"></i> Lock Screen</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item text-danger" href="<?= site_url('logout') ?>"><i class="bi bi-box-arrow-right"></i>
                Logout</a></li>
          </ul>
        </div>
      </div>
    </header>
    <!-- END: Top Navbar Component -->