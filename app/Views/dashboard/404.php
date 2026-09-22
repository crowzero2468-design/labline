
  <?= view('dashboard/layout/head') ?>
<body>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="flash-message" style="position: fixed; top: 12px; left: 50%; transform: translateX(-50%); z-index: 1200; width: min(90vw, 520px); opacity: 1; transition: opacity 0.5s ease;">
      <div style="background: #ffe4e6; color: #991b1b; border: 1px solid #fecdd3; padding: 12px 16px; border-radius: 10px; font-weight: 600;">
        <?= esc(session()->getFlashdata('error')) ?>
      </div>
    </div>
  <?php endif; ?>
  <?php if (session()->getFlashdata('success')): ?>
    <div class="flash-message" style="position: fixed; top: 12px; left: 50%; transform: translateX(-50%); z-index: 1200; width: min(90vw, 520px); opacity: 1; transition: opacity 0.5s ease;">
      <div style="background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; padding: 12px 16px; border-radius: 10px; font-weight: 600;">
        <?= esc(session()->getFlashdata('success')) ?>
      </div>
    </div>
  <?php endif; ?>


 <!-- ==========================================
         START: 404 Error Page Container & Card
         ========================================== -->
    <div class="login-wrapper">
        <!-- Glowing background shapes matching theme aesthetic -->
        <div class="login-bg-shape login-bg-shape-1"></div>
        <div class="login-bg-shape login-bg-shape-2"></div>
        
        <!-- Main centered error card layout -->
        <div class="login-card text-center">
            
            <!-- Brand Identity -->
            <a href="<?= site_url('dashboard') ?>" class="login-brand text-decoration-none">
                <!-- <i class="bi bi-asterisk"></i> -->
                <span>Joshua Admin Wait for Update</span>
            </a>
            
            <!-- Giant 404 header with spinning asterisk Zero -->
            <div class="error-title-huge">
                <span>4</span>
                <i class="bi bi-asterisk"></i>
                <span>4</span>
            </div>
            
            <h2 class="error-subtitle">Page Not Found</h2>
            <p class="error-desc">
                The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.
            </p>
            
            <div class="error-actions-group">
                <a href="<?= site_url('dashboard') ?>" class="btn-custom btn-custom-primary">
                    <i class="bi bi-house"></i> Back to Dashboard
                </a>
            </div>
            
        </div>
    </div>

 


    <script>
      setTimeout(function () {
        const messages = document.querySelectorAll('.flash-message');
        messages.forEach(function (message) {
          message.style.opacity = '0';
          setTimeout(function () {
            message.remove();
          }, 500);
        });
      }, 5000);

      document.addEventListener('DOMContentLoaded', function () {
        const statValue = document.getElementById('all-machine-total');
        const trendBadge = document.getElementById('all-machine-trend');

        document.querySelectorAll('.machine-count-item').forEach(function (button) {
          button.addEventListener('click', function () {
            const total = Number(button.dataset.total || 0);
            const machineName = button.dataset.machine || 'Machine';

            if (statValue) {
              statValue.textContent = new Intl.NumberFormat().format(total);
            }

            if (trendBadge) {
              const icon = trendBadge.querySelector('i');
              const text = trendBadge.querySelector('span');

              if (icon) {
                icon.className = 'bi bi-box';
              }

              if (text) {
                text.textContent = machineName + ' total';
              }
            }

            const dropdownElement = button.closest('.dropdown');
            if (dropdownElement && window.bootstrap && bootstrap.Dropdown) {
              const toggleButton = dropdownElement.querySelector('[data-bs-toggle="dropdown"]');
              if (toggleButton) {
                const dropdownInstance = bootstrap.Dropdown.getOrCreateInstance(toggleButton);
                dropdownInstance.hide();
              }
            }
          });
        });
      });
    </script>

</body>


</html>