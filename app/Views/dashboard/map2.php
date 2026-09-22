
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

    <div class="page-header">
      <div>
        <h1 class="page-title">Philippines Clinic Map</h1>
        <p class="page-subtitle">Province totals from tb_data</p>
      </div>
      <a href="<?= site_url('dashboard') ?>" class="btn btn-outline-secondary btn-sm">Back to Dashboard</a>
    </div>

    <div class="row g-4">
      <div class="col-12">
        <div class="card">
          <div class="card-body p-4">
            <div class="province-map-panel">
              <svg class="philippines-outline" viewBox="0 0 900 620" aria-label="Philippines map">
                <g class="philippines-shape">
                  <path d="M200 90 L250 70 L310 82 L350 110 L390 118 L420 142 L446 170 L462 206 L492 218 L500 240 L474 260 L442 292 L420 322 L398 344 L362 360 L336 398 L314 430 L278 442 L250 430 L220 404 L182 390 L150 348 L132 312 L150 278 L118 252 L126 220 L160 200 L176 164 L188 132 Z" fill="#dff7d5" stroke="#1f6f45" stroke-width="3"/>
                  <path d="M308 280 L346 264 L392 274 L430 290 L456 324 L448 356 L410 374 L382 404 L344 408 L318 380 L290 348 Z" fill="#cfeec1" stroke="#1f6f45" stroke-width="2.5"/>
                  <path d="M444 356 L500 344 L548 370 L584 402 L570 448 L532 472 L484 482 L452 452 L432 412 Z" fill="#d4f0c0" stroke="#1f6f45" stroke-width="2.5"/>
                  <path d="M536 470 L590 486 L634 524 L650 580 L620 602 L568 594 L526 560 L502 514 Z" fill="#dff7d5" stroke="#1f6f45" stroke-width="2.5"/>
                  <path d="M604 548 L638 540 L668 556 L676 594 L654 610 L620 604 L596 576 Z" fill="#cfeec1" stroke="#1f6f45" stroke-width="2"/>
                  <path d="M160 430 L196 416 L214 430 L206 458 L174 470 L148 454 Z" fill="#dff7d5" stroke="#1f6f45" stroke-width="2"/>
                  <path d="M510 268 L532 256 L552 270 L548 296 L522 304 L500 288 Z" fill="#dff7d5" stroke="#1f6f45" stroke-width="2"/>
                  <path d="M468 204 L490 194 L512 210 L500 232 L474 230 Z" fill="#dff7d5" stroke="#1f6f45" stroke-width="2"/>
                </g>
              </svg>

              <?php
              $provinceLayout = [
                  'Metro Manila' => ['x' => 44, 'y' => 18],
                  'Cavite' => ['x' => 38, 'y' => 24],
                  'Laguna' => ['x' => 50, 'y' => 23],
                  'Batangas' => ['x' => 43, 'y' => 31],
                  'Bulacan' => ['x' => 52, 'y' => 16],
                  'Pangasinan' => ['x' => 16, 'y' => 18],
                  'Isabela' => ['x' => 60, 'y' => 16],
                  'Cagayan' => ['x' => 70, 'y' => 9],
                  'Bohol' => ['x' => 41, 'y' => 54],
                  'Cebu' => ['x' => 35, 'y' => 58],
                  'Iloilo' => ['x' => 25, 'y' => 63],
                  'Davao' => ['x' => 61, 'y' => 72],
                  'Misamis Oriental' => ['x' => 68, 'y' => 58],
                  'Zamboanga' => ['x' => 18, 'y' => 79],
                  'Cotabato' => ['x' => 55, 'y' => 82],
              ];

              $provinceData = [];
              foreach ($province_totals ?? [] as $entry) {
                  $provinceData[trim((string) ($entry['Province'] ?? ''))] = (int) ($entry['total'] ?? 0);
              }

              $orderedProvinces = $province_totals ?? [];
              foreach ($orderedProvinces as $index => $entry) {
                  $provinceName = trim((string) ($entry['Province'] ?? ''));
                  if ($provinceName === '') {
                      continue;
                  }
                  $layout = $provinceLayout[$provinceName] ?? [
                      'x' => 25 + (($index % 6) * 12),
                      'y' => 32 + floor($index / 6) * 12,
                  ];
                  $value = (int) ($entry['total'] ?? 0);
                  $colorValue = min(1, max(0.25, $value / max(1, max(array_column($orderedProvinces, 'total')))));
                  $color = sprintf('#%02x%02x%02x', 255, (int) (150 + (105 * $colorValue)), 170);
                  echo '<div class="province-pin" style="left:' . $layout['x'] . '%; top:' . $layout['y'] . '%; background:' . $color . ';">';
                  echo '<span class="province-name">' . esc($provinceName) . '</span>';
                  echo '<span class="province-total">' . number_format($value) . '</span>';
                  echo '</div>';
              }
              ?>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h2 class="card-title mb-0">Province Clinic Totals</h2>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-dark">
                  <tr>
                    <th>Province</th>
                    <th class="text-end">Clinic Count</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($province_totals)): ?>
                    <?php foreach ($province_totals as $entry): ?>
                      <tr>
                        <td><?= esc($entry['Province'] ?? '') ?></td>
                        <td class="text-end"><?= number_format((int) ($entry['total'] ?? 0)) ?></td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="2" class="text-center py-4 text-muted">No province data found.</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?= view('dashboard/layout/footer') ?>
  </div>

  <style>
    .province-map-panel {
      position: relative;
      min-height: 620px;
      background: linear-gradient(180deg, rgba(13, 86, 52, 0.03), rgba(13, 86, 52, 0.1));
      border: 1px solid rgba(13, 86, 52, 0.08);
      border-radius: 20px;
      padding: 18px;
      overflow: hidden;
    }

    .philippines-outline {
      width: 100%;
      height: 100%;
      min-height: 580px;
      display: block;
      opacity: 0.9;
    }

    .province-pin {
      position: absolute;
      transform: translate(-50%, -50%);
      min-width: 90px;
      padding: 6px 8px;
      border-radius: 999px;
      color: #0b1f16;
      font-size: 0.7rem;
      font-weight: 700;
      border: 1px solid rgba(15, 65, 44, 0.25);
      box-shadow: 0 8px 18px rgba(15, 65, 44, 0.15);
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      z-index: 2;
    }

    .province-pin .province-name {
      line-height: 1.1;
      white-space: nowrap;
    }

    .province-pin .province-total {
      font-size: 0.8rem;
      font-weight: 800;
    }
  </style>

</body>
</html>