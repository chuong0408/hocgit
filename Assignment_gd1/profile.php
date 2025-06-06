<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>User Profile & Promotions</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto&display=swap" rel="stylesheet" />
  <style>
    body {
      background: #f8f9fa;
      font-family: 'Roboto', Arial, sans-serif;
    }

    .menu {
      background: #fff;
      padding: 1.2rem 1rem;
      border-radius: 1rem;
      margin-bottom: 2rem;
    }

    .menu a {
      font-family: 'Playfair Display', serif;
      margin-right: 1.5rem;
      font-weight: 500;
      color: #0d6efd;
      text-decoration: none;
    }

    .menu a.active,
    .menu a:hover {
      color: #fff;
      background: #0d6efd;
      border-radius: 6px;
      padding: 0.25rem 0.75rem;
    }

    .profile-container {
      max-width: 940px;
      margin: 40px auto 0 auto;
    }

    .profile-card {
      background: #fff;
      border-radius: 1.5rem;
      box-shadow: 0 1px 8px #0001;
      padding: 2rem;
    }

    .profile-title {
      font-family: 'Playfair Display', serif;
      font-size: 2rem;
      font-weight: 700;
    }

    .profile-avatar {
      width: 90px;
      height: 90px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #dee2e6;
      background: #e9ecef;
    }

    .profile-form label {
      font-weight: 500;
    }

    .order-table th,
    .order-table td {
      vertical-align: middle;
    }

    .order-table .badge {
      font-size: 0.95em;
    }

    @media (max-width: 991px) {
      .profile-card {
        padding: 1rem;
      }

      .profile-title {
        font-size: 1.3rem;
      }
    }
  </style>
</head>

<body>
  <?php
  session_start();
  if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id']))
 {
    require_once './db_utils.php';
    $db_utils = new DB_UTILS;
    $query = "SELECT * FROM khachhang WHERE maKH = ?";
    $result = $db_utils->getOne($query, [$_SESSION['user_id']]);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $query_update = "UPDATE khachhang set tenKH = ?, email = ?, sdt =?,diaChi =? WHERE maKH =?";
      $result_update = $db_utils->execute($query_update, [
        $_POST['tenKH'],
        $_POST['email'],
        $_POST['sdt'],
        $_POST['diaChi'],
        $_SESSION['user_id']
      ]);
      var_dump($result_update);
      // header('location: profile.php');
      // exit();
    }
  } else {
    header('location: home.php');
    exit();
  }
  ?>
  <div class="container profile-container">
    <!-- Navigation menu -->
    <nav class="menu d-flex align-items-center mb-4">
      <a href="home.php">Home</a>
      <a href="product-list.php">Products</a>
      <a href="cart.html">Cart</a>
      <a href="profile.php" class="active">Profile</a>
    </nav>
    <div class="profile-card mb-5">
      <ul class="nav nav-tabs" id="profileTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">Cập nhật tài khoản</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button" role="tab">Lịch sử đơn hàng</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="promo-tab" data-bs-toggle="tab" data-bs-target="#promo" type="button" role="tab">Khuyến mãi</button>
        </li>
      </ul>
      <div class="tab-content pt-4" id="profileTabsContent">
        <!-- Cập nhật tài khoản -->
        <div class="tab-pane fade show active" id="profile" role="tabpanel">
          <div class="row g-4">
            <div class="col-lg-4 text-center">
              <img src="https://randomuser.me/api/portraits/men/41.jpg" alt="User Avatar" class="profile-avatar mb-2" />
              <div class="fw-semibold mb-2" id="profileNameShow">Tomny Son</div>
              <div class="text-muted small" id="profileEmailShow">tomny@example.com</div>
            </div>
            <div class="col-lg-8">
              <div class="profile-title mb-3">Cập nhật tài khoản</div>
              <form id="profileForm" class="profile-form row g-3" method="post">
                <div class="col-md-6">
                  <label class="form-label">Họ tên</label>
                  <input name="tenKH" type="text" class="form-control" id="profileName" value="<?php echo $result['tenKH'] ?>" required />
                </div>
                <div class="col-md-6">
                  <label class="form-label">Email</label>
                  <input name="email" type="email" class="form-control" id="profileEmail" value="<?php echo $result['email'] ?>" required />
                </div>
                <div class="col-md-6">
                  <label class="form-label">Số điện thoại</label>
                  <input name="sdt" type="tel" class="form-control" id="profilePhone" value="<?php echo $result['sdt'] ?>" required />
                </div>
                <div class="col-md-6">
                  <label class="form-label">Địa chỉ</label>
                  <input name="diaChi" type="text" class="form-control" id="profileAddress" value="<?php echo $result['diaChi'] ?>" required />
                </div>
                <div class="col-12 text-end">
                  <button class="btn btn-primary" type="submit">Cập nhật</button>
                </div>
              </form>
              <div id="profileAlert" class="alert alert-success mt-3 d-none">
                Cập nhật thành công!
              </div>
            </div>
          </div>
        </div>
        <!-- Lịch sử đơn hàng -->
        <div class="tab-pane fade" id="orders" role="tabpanel">
          <div class="profile-title mb-4">Lịch sử đơn hàng</div>
          <div class="table-responsive">
            <table class="table table-bordered order-table align-middle">
              <thead class="table-light">
                <tr>
                  <th>Mã đơn</th>
                  <th>Ngày</th>
                  <th>Trạng thái</th>
                  <th>Tổng</th>
                  <th>Chi tiết</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>#A1B2C3</td>
                  <td>2025-06-01</td>
                  <td><span class="badge bg-success">Đã giao</span></td>
                  <td>$3120</td>
                  <td><a href="order-detail.html?id=A1B2C3" class="btn btn-outline-primary btn-sm">Xem</a></td>
                </tr>
                <tr>
                  <td>#F4G5H6</td>
                  <td>2025-05-22</td>
                  <td><span class="badge bg-warning text-dark">Đang xử lý</span></td>
                  <td>$1200</td>
                  <td><a href="order-detail.html?id=F4G5H6" class="btn btn-outline-primary btn-sm">Xem</a></td>
                </tr>
                <tr>
                  <td>#Z9Y8X7</td>
                  <td>2025-05-10</td>
                  <td><span class="badge bg-danger">Đã huỷ</span></td>
                  <td>$780</td>
                  <td><a href="order-detail.html?id=Z9Y8X7" class="btn btn-outline-primary btn-sm">Xem</a></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <!-- Khuyến mãi -->
        <div class="tab-pane fade" id="promo" role="tabpanel">
          <div class="profile-title mb-4">Khuyến mãi của bạn</div>
          <div class="row g-4">
            <div class="col-md-6">
              <div class="card border-success h-100">
                <div class="card-body">
                  <h5 class="card-title text-success mb-2">Mã: SUMMER24</h5>
                  <p class="card-text mb-1">Giảm 10% cho đơn từ $1000</p>
                  <div class="mb-2 text-muted small">HSD: 30/06/2025</div>
                  <span class="badge bg-success">Còn hiệu lực</span>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card border-secondary h-100">
                <div class="card-body">
                  <h5 class="card-title text-secondary mb-2">Mã: FREESHIP</h5>
                  <p class="card-text mb-1">Miễn phí vận chuyển cho mọi đơn hàng</p>
                  <div class="mb-2 text-muted small">HSD: 15/07/2025</div>
                  <span class="badge bg-secondary">Còn hiệu lực</span>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card border-danger h-100">
                <div class="card-body">
                  <h5 class="card-title text-danger mb-2">Mã: NEWUSER50</h5>
                  <p class="card-text mb-1">Giảm $50 cho khách mới</p>
                  <div class="mb-2 text-muted small">Hết hạn: 01/06/2025</div>
                  <span class="badge bg-danger">Hết hiệu lực</span>
                </div>
              </div>
            </div>
          </div>
          <div class="alert alert-info mt-4">
            Bạn chưa có nhiều mã? Theo dõi <a href="promotions.html" class="fw-semibold text-decoration-underline">chương trình ưu đãi</a> mới nhất từ shop!
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap JS for tab functionality -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Profile update demo JS
    document.getElementById('profileForm').onsubmit = function(e) {
      e.preventDefault();
      document.getElementById('profileNameShow').textContent = document.getElementById('profileName').value;
      document.getElementById('profileEmailShow').textContent = document.getElementById('profileEmail').value;
      document.getElementById('profileAlert').classList.remove('d-none');
      setTimeout(function() {
        document.getElementById('profileAlert').classList.add('d-none');
      }, 3500);
    }
  </script> -->
</body>

</html>