<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Product Grid</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Roboto&display=swap" rel="stylesheet" />
  <style>
    body {
      background: #f8f9fa;
    }

    .menu {
      background: #fff;
      padding: 1.5rem 1rem;
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

    .sidebar {
      background: #fff;
      border-radius: 1rem;
      padding: 1.5rem 1rem;
      margin-bottom: 2rem;
      box-shadow: 0 2px 8px #0001;
    }

    .sidebar-title {
      font-family: 'Playfair Display', serif;
      font-size: 1.25rem;
      font-weight: 700;
      margin-bottom: 1rem;
    }

    .category-list {
      list-style: none;
      padding-left: 0;
    }

    .category-list li {
      margin-bottom: 0.7rem;
    }

    .category-list a {
      color: #343a40;
      text-decoration: none;
      font-weight: 500;
      cursor: pointer;
    }

    .category-list a.active,
    .category-list a:hover {
      color: #0d6efd;
      text-decoration: underline;
    }

    .product-list {
      background: #fff;
      border-radius: 1rem;
      padding: 2rem;
    }

    .product-card {
      border-radius: 1rem;
      border: 1px solid #dee2e6;
      background: #fff;
      padding: 1.25rem;
      margin-bottom: 2rem;
      box-shadow: 0 2px 8px #0001;
    }

    .product-title {
      font-family: 'Playfair Display', serif;
      font-weight: 700;
    }

    .product-category {
      font-size: 0.95rem;
      color: #6c757d;
    }

    .product-actions a {
      margin-right: 0.5rem;
    }

    .product-img {
      width: 100%;
      height: 180px;
      object-fit: contain;
      background: #f3f3f3;
      border-radius: 0.5rem;
      margin-bottom: 1rem;
    }

    .add-cart-btn {
      font-weight: 500;
      letter-spacing: 0.04em;
    }

    .filter-row {
      margin-bottom: 1.7rem;
    }

    @media (max-width: 991px) {
      .col-lg-4 {
        margin-bottom: 1.5rem;
      }

      .sidebar {
        margin-bottom: 1.2rem;
      }
    }

    @media (max-width: 767px) {
      .sidebar {
        display: none;
      }
    }
  </style>
</head>

<body>
  <?php
  session_start();
  require_once './db_utils.php';
  $db_utils = new DB_UTILS;
  $error = "";
  $query_danhmuc = "SELECT * FROM danhmuc";
  $list_danhmuc = $db_utils->getAll($query_danhmuc);
  if (empty($_GET['id'])) {
    $query = "SELECT * FROM sanpham sp left join danhmuc dm on sp.maDM = dm.maDM WHERE sp.ngayTao >= NOW() - INTERVAL 7 DAY;";
    $list_sanpham = $db_utils->getAll($query);
  } else {
    $query = "SELECT * FROM sanpham sp left join danhmuc dm on sp.maDM = dm.maDM left join thuonghieu th on sp.maTH = th.maTH WHERE dm.tenDM = ? or th.tenTH = ?";
    $list_sanpham = $db_utils->getAll($query, [$_GET['id']]);
  }


  ?>
  <div class="container" style="max-width: 1150px; margin-top: 48px;">
    <nav class="menu d-flex align-items-center mb-4">
      <a href="home.php" class="active">Home</a>
      <a href="product-list.php">Products</a>
      <a href="about.html">About</a>
      <a href="contact.html">Contact</a>
      <a href="admin.php">Admid</a>
       <a href="profile.php">Tài khoản</a>
    </nav>
    <div class="row">
      <!-- Sidebar category -->
      <aside class="col-lg-3 sidebar">
        <div class="sidebar-title">Danh mục sản phẩm</div>
        <ul class="category-list" id="categoryList">
          <li><a href="#" class="active" data-category="all">Tất cả</a></li>
          <?php
          if (count($list_danhmuc) > 0) {
            foreach ($list_danhmuc as $item) { ?>
              <li>
                <a href="product-list.php?id=<?= $item['tenDM'] ?>">
                  <?= $item['tenDM'] ?>
                </a>
              </li>
            <?php }
            ?>
          <?php  } ?>
          <li><a href="#" data-category="Smartphone">Smartphone</a></li>
          <li><a href="#" data-category="Laptop">Laptop</a></li>
          <li><a href="#" data-category="Wearables">Wearables</a></li>
          <li><a href="#" data-category="Phụ kiện">Phụ kiện</a></li>
        </ul>
        <div class="sidebar-title">Thương hiệu</div>
        <ul class="category-list" id="categoryList">
          <li><a href="#" class="active" data-category="all">Tất cả</a></li>
          <li><a href="#" data-category="Smartphone">Smartphone</a></li>
          <li><a href="#" data-category="Laptop">Laptop</a></li>
          <li><a href="#" data-category="Wearables">Wearables</a></li>
          <li><a href="#" data-category="Phụ kiện">Phụ kiện</a></li>
        </ul>
      </aside>
      <!-- Product grid -->
      <div class="col-lg-9">
        <div class="product-list">
          <div class="row filter-row align-items-center mb-3">
            <div class="col-sm-6">
              <h2 style="font-family: 'Playfair Display', serif;" class="mb-0 fs-4">Sản phẩm mới nhất</h2>
            </div>
            <div class="col-sm-6 text-sm-end mt-2 mt-sm-0">
              <input type="text" class="form-control" id="searchInput" style="max-width: 320px; display: inline-block;" placeholder="Tìm kiếm sản phẩm..." />
            </div>
          </div>
          <div class="row" id="productGrid">
            <!-- Sản phẩm -->
            <?php
            if (count($list_sanpham) > 0) {
              foreach ($list_sanpham as $item) { ?>
                <div class="col-lg-4 col-md-6 mb-4 product-item" data-category="Smartphone" data-title="iphone 15 pro">
                  <div class="product-card h-100 d-flex flex-column">
                    <a href="product-detail.php?id=<?= $item['tenSP'] ?>"><img src="<?php echo $item['hinhAnh'] ?>" alt="iPhone 15 Pro" class="product-img" /></a>
                    <div class="product-title"><?php echo $item['tenSP'] ?></div>
                    <div class="product-category"><?php echo $item['tenDM'] ?></div>
                    <div class="my-2">Quantity: <?php echo $item['soLuong'] ?></div>
                    <div class="product-actions mt-auto">
                      <a href="cart.html?add=1" class="btn btn-warning add-cart-btn w-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-cart-plus mb-1 me-1" viewBox="0 0 16 16">
                          <path d="M8 7v3.5a.5.5 0 0 0 1 0V7h1.5a.5.5 0 0 0 0-1H9V4.5a.5.5 0 0 0-1 0V6H6.5a.5.5 0 0 0 0 1H8Zm-4.236 6.496A.5.5 0 0 1 3.5 13h9a.5.5 0 0 1 .491.408l1.5 8A.5.5 0 0 1 14 15.5h-2a.5.5 0 0 1-.491-.408L10.57 13H5.43l-.439 2.092A.5.5 0 0 1 4.5 15.5h-2a.5.5 0 0 1-.491-.408l-1.5-8A.5.5 0 0 1 2 7.5h12a.5.5 0 0 1 .491.408l1.5 8A.5.5 0 0 1 16 15.5h-2a.5.5 0 0 1-.491-.408L13.57 13H2.43l-.439 2.092ZM5 16a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm6 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" />
                        </svg>
                        Add to Cart
                      </a>
                    </div>
                  </div>
                </div>
              <?php }
              ?>
            <?php  } ?>
            <!-- Thêm nhiều sản phẩm hơn ở đây nếu muốn -->
          </div>
          <div class="text-center mt-4 d-none" id="noResult">
            <div class="alert alert-warning">Không tìm thấy sản phẩm nào phù hợp.</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    // Filter theo text và category
    const searchInput = document.getElementById('searchInput');
    const categoryLinks = document.querySelectorAll('#categoryList a');
    const productItems = document.querySelectorAll('.product-item');
    const noResult = document.getElementById('noResult');
    let currentCategory = 'all';

    categoryLinks.forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        categoryLinks.forEach(l => l.classList.remove('active'));
        this.classList.add('active');
        currentCategory = this.dataset.category;
        filterProducts();
      });
    });

    searchInput.addEventListener('input', filterProducts);

    function filterProducts() {
      const keyword = searchInput.value.trim().toLowerCase();
      let found = 0;
      productItems.forEach(item => {
        const title = item.dataset.title;
        const category = item.dataset.category;
        const matchCategory = (currentCategory === 'all' || category === currentCategory);
        const matchText = (title.indexOf(keyword) !== -1);
        if (matchCategory && matchText) {
          item.style.display = '';
          found++;
        } else {
          item.style.display = 'none';
        }
      });
      noResult.classList.toggle('d-none', found > 0);
    }
  </script>
</body>

</html>