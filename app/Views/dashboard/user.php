
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

  <?= view('dashboard/layout/sidebar') ?>

  <div class="main-wrapper">
    <?= view('dashboard/layout/navbar') ?>

    <main class="content-area px-4 py-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h2 class="mb-1 fw-bold text-dark">Users</h2>
          <p class="text-muted mb-0">All registered users from tb_user</p>
        </div>
      </div>

      <div class="card shadow-sm border-0">
        <div class="card-body p-0">
          <!-- <div class="p-3 border-bottom">
            <form method="get" action="<?= site_url('dashboard/user') ?>" class="d-flex gap-2 align-items-center justify-content-end">
              <input type="text" name="search" class="form-control" value="<?= esc($search ?? '') ?>" placeholder="Search users..." style="max-width: 280px;">
              <button type="submit" class="btn btn-primary">Search</button>
              <?php if (!empty($search)): ?>
                <a href="<?= site_url('dashboard/user') ?>" class="btn btn-outline-secondary">Reset</a>
              <?php endif; ?>
            </form>
          </div> -->
          <div class="table-responsive">
            <table id="userTable" class="table table-striped table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th>No.</th>
                  <th>Company ID</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Username</th>
                  <th>Role</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($users)): ?>
                  <?php foreach ($users as $index => $row): ?>
                    <?php $status = strtolower((string) ($row['status'] ?? 'inactive')); ?>
                    <?php $role = (int) ($row['role'] ?? 1); ?>
                    <tr>
                      <td><?= (int) $index + 1 ?></td>
                      <td><?= esc($row['company_id'] ?? '-') ?></td>
                      <td><?= esc($row['fname'] ?? '-') ?></td>
                      <td><?= esc($row['lname'] ?? '-') ?></td>
                      <td><?= esc($row['uname'] ?? '-') ?></td>
                      <td>
                        <span class="badge bg-secondary">
                          <?= $role === 2 ? 'Admin' : 'User' ?>
                        </span>
                      </td>
                      <td>
                        <span class="badge bg-<?= $status === 'active' ? 'success' : 'secondary' ?>">
                          <?= ucfirst($status) ?>
                        </span>
                      </td>
                      <td>
                        <div class="d-flex gap-2 flex-wrap">
                          <form method="post" action="<?= site_url('dashboard/user/toggle-status') ?>">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= (int) ($row['id'] ?? 0) ?>">
                            <input type="hidden" name="status" value="<?= $status === 'active' ? 'inactive' : 'active' ?>">
                            <button type="submit" class="btn btn-sm btn-outline-<?= $status === 'active' ? 'warning' : 'success' ?>">
                              <?= $status === 'active' ? 'Inactive' : 'Active' ?>
                            </button>
                          </form>

                          <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editUserModal<?= (int) ($row['id'] ?? 0) ?>">
                            Edit
                          </button>

                          <form method="post" action="<?= site_url('dashboard/user/delete') ?>" onsubmit="return confirm('Delete this user?');">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= (int) ($row['id'] ?? 0) ?>">
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                          </form>
                        </div>
                      </td>
                    </tr>

                    <div class="modal fade" id="editUserModal<?= (int) ($row['id'] ?? 0) ?>" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <form method="post" action="<?= site_url('dashboard/user/update') ?>">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= (int) ($row['id'] ?? 0) ?>">
                            <div class="modal-header">
                              <h5 class="modal-title">Edit User</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body row g-3">
                              <div class="col-md-6">
                                <label class="form-label">First Name</label>
                                <input type="text" name="fname" class="form-control" value="<?= esc($row['fname'] ?? '') ?>" required>
                              </div>
                              <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="lname" class="form-control" value="<?= esc($row['lname'] ?? '') ?>" required>
                              </div>
                              <div class="col-md-6">
                                <label class="form-label">Username</label>
                                <input type="text" name="uname" class="form-control" value="<?= esc($row['uname'] ?? '') ?>" required>
                              </div>
                              <div class="col-md-6">
                                <label class="form-label">Company ID</label>
                                <input type="text" name="company_id" class="form-control" value="<?= esc($row['company_id'] ?? '') ?>">
                              </div>
                              <div class="col-md-6">
                                <label class="form-label">Role</label>
                                <select name="role" class="form-select">
                                  <option value="1" <?= $role === 1 ? 'selected' : '' ?>>Admin</option>
                                  <option value="2" <?= $role === 2 ? 'selected' : '' ?>>User</option>
                                </select>
                              </div>
                              <div class="col-md-6">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current password">
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                              <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="8" class="text-center text-muted py-4">No users found.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>

    <?= view('dashboard/layout/footer') ?>
  </div>

  <script>
    $(document).ready(function () {
      $('#userTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        order: [[0, 'asc']],
        columnDefs: [
          { targets: 0, orderable: false }
        ]
      });
    });

    setTimeout(function () {
      const messages = document.querySelectorAll('.flash-message');
      messages.forEach(function (message) {
        message.style.opacity = '0';
        setTimeout(function () {
          message.remove();
        }, 500);
      });
    }, 5000);
  </script>
</body>
</html>