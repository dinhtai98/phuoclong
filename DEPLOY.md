# Hướng dẫn đưa website PCCC Phước Long lên hosting (domain: pcccphuoclong.vn)

Website chạy bằng **SQLite** (database nằm gọn trong 1 file, không dùng MySQL). Vì vậy cách lên host
đơn giản nhất là **bê nguyên cả thư mục `wp/` lên host** — giữ y hệt local, **không cần convert sang MySQL**.

> ✅ **Ưu điểm:** site lên host giống local 100% (theme, giỏ hàng, CPT dự án/sản phẩm, nội dung).
> Bản WordPress 7.0 đi kèm trong gói, nên dù host cài sẵn WordPress bản cũ (v5…) cũng không sao —
> mình ghi đè bằng bản trong gói.

---

## CHUẨN BỊ
1. **Tên miền** `pcccphuoclong.vn` (đã có) — trỏ về hosting.
2. **Gói hosting** Plesk, có **SSH Terminal** và chọn được **PHP 8.3**.
3. Tài khoản quản trị: **admin / PhuocLong@2025** (đổi mật khẩu sau khi lên host).
4. Gói deploy: **`deploy-pcccphuoclong.zip`** (ở thư mục gốc dự án, đã chứa sẵn cả file
   database `.ht.sqlite` và drop-in SQLite).
   - Tạo lại gói khi cần: `cd wp && zip -rqX ../deploy-pcccphuoclong.zip . -x "wp-content/upgrade/*" "*.DS_Store"`

---

## CÁC BƯỚC TRÊN PLESK

### Bước 1 — KHÔNG cài WordPress mới
Nếu Plesk mở dialog "Install WordPress" → bấm **Cancel**. Ta upload file thẳng, không cài mới
(cài mới sẽ tạo site trống dùng MySQL, không phải cái ta cần).

### Bước 2 — Đặt PHP về 8.3
Domain `pcccphuoclong.vn` → **PHP Settings** → chọn **PHP 8.3**.
⚠️ Không để 8.5/8.4 (deprecation), không để 7.x (WP 7.0 cần ≥ 7.4). Local dùng 8.3.

### Bước 3 — Upload & giải nén
**Files** (File Manager) → mở **`httpdocs`**:
1. **Xóa hết** file mặc định trong `httpdocs` (trang chào mừng của Plesk…).
2. Upload **`deploy-pcccphuoclong.zip`** vào `httpdocs`.
3. Chuột phải file zip → **Extract Files** (giải nén ngay tại `httpdocs`).
4. Xóa file zip sau khi giải nén.

> Kết quả đúng: `httpdocs/wp-config.php`, `httpdocs/wp-content/`, `httpdocs/wp-admin/`… nằm thẳng
> trong `httpdocs`, **không** nằm trong `httpdocs/wp/`.

### Bước 4 — Sửa địa chỉ site (wp-config.php)
Mở **`httpdocs/wp-config.php`**, thêm 2 dòng ngay trên `/* That's all, stop editing! */`:

```php
define( 'WP_HOME',    'https://pcccphuoclong.vn' );
define( 'WP_SITEURL', 'https://pcccphuoclong.vn' );
```

> Lưu ý: dòng `define( 'DB_HOST', 'localhost' )` trong wp-config **giữ nguyên, không sửa** —
> đó là host MySQL, nhưng site dùng SQLite nên không đụng tới.

### Bước 5 — Đổi link cũ trong nội dung (SSH Terminal)
2 dòng trên chỉ fix URL chính; link/ảnh trong các trang vẫn trỏ `localhost:8080`. Mở **SSH Terminal**:

```bash
cd ~/httpdocs
/opt/plesk/php/8.3/bin/php "$(which wp)" search-replace 'http://localhost:8080' 'https://pcccphuoclong.vn' --all-tables --skip-columns=guid
```

> - SSH mặc định dùng PHP cũ (7.2) → **phải gọi rõ** `/opt/plesk/php/8.3/bin/php` đứng trước `wp`.
> - Lỗi đỏ kiểu `SHOW FULL TABLES WHERE Table_Type = "VIEW" … print_error` là **vô hại** (SQLite
>   không hiểu truy vấn VIEW của MySQL) — kệ nó, miễn cuối cùng có `Success: Made N replacements.`

### Bước 6 — Tạo `.htaccess` cho permalink (SSH Terminal)
Local chạy PHP built-in server nên **không có `.htaccess`**. Lên Apache phải tạo, nếu không các trang con
(`/du-an/`, `/san-pham/`, `/gio-hang/`…) sẽ báo `error_docs/not_found.html` (404).

```bash
cd ~/httpdocs
cat > .htaccess <<'EOF'
# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
# END WordPress
EOF
/opt/plesk/php/8.3/bin/php "$(which wp)" rewrite flush
```

### Bước 7 — SSL (HTTPS) miễn phí
**Websites & Domains** → domain → **SSL/TLS Certificates** → **Let's Encrypt** → Install
(tích cả `www.pcccphuoclong.vn`) → **Get it free**. Sau đó bật **301 redirect HTTP → HTTPS**.

### Bước 8 — Chặn tải file database (bảo mật)
File DB là `wp-content/database/.ht.sqlite`. Trong gói đã có `.htaccess` (`DENY FROM ALL`) chặn ở
**Apache**, nhưng nếu host phục vụ file tĩnh bằng **nginx** thì cần chặn thêm.

1. **Kiểm tra trước:** mở `https://pcccphuoclong.vn/wp-content/database/.ht.sqlite`
   - Ra **403/404** → đã an toàn, bỏ qua bước này.
   - **Tải về được file** → cần chặn (xem dưới).
2. Nếu **Apache & nginx Settings** có ô **Additional nginx directives** → dán:
   ```nginx
   location ~* /wp-content/database/ { deny all; return 403; }
   location ~ /\.ht { deny all; return 403; }
   ```
3. Nếu hosting **khóa** ô nginx (không có ô đó) → chuyển file DB ra **ngoài web root**:
   ```bash
   mkdir -p ~/private_db
   mv ~/httpdocs/wp-content/database/.ht.sqlite ~/private_db/.ht.sqlite
   ```
   rồi thêm vào `wp-config.php`:
   ```php
   define( 'DB_DIR',  dirname(__DIR__) . '/private_db/' );
   define( 'DB_FILE', '.ht.sqlite' );
   ```
   *(Plugin sqlite-database-integration đọc 2 hằng số này — xác nhận trong `constants.php`.)*

### Bước 9 — Hoàn tất & kiểm tra
1. Đăng nhập `https://pcccphuoclong.vn/wp-admin` (admin / PhuocLong@2025) → **đổi mật khẩu**.
2. Kiểm tra: trang chủ, menu chuyển trang Dự án/Sản phẩm/Giỏ hàng, **ảnh hiện đủ**
   (chuột phải ảnh → địa chỉ phải là `https://pcccphuoclong.vn/wp-content/...`, không còn `localhost`),
   ổ khóa 🔒 trên thanh địa chỉ, nút Gọi/Zalo, thêm vào giỏ → gửi Zalo.

---

## ⚠️ KHÔNG ĐƯỢC LÀM
- **KHÔNG xóa** `wp-content/db.php` và thư mục `wp-content/plugins/sqlite-database-integration`.
  Đây là lớp SQLite — site đang chạy bằng nó. Xóa = website chết (trang trắng).
- **KHÔNG sửa** `DB_HOST`/`DB_NAME`/`DB_USER` trong wp-config (không dùng MySQL).

---

## GHI CHÚ
- **WP Toolkit của Plesk** sẽ không quản lý được site SQLite này (không auto-update/scan). Cập nhật
  WordPress/theme thủ công qua wp-admin khi cần.
- **Form liên hệ:** đang là demo mailto. Nên cài **Contact Form 7/WPForms** + **WP Mail SMTP** để
  nhận form qua email công ty.
- **Sao lưu:** chỉ cần copy thư mục `httpdocs` (gồm cả `wp-content/database/.ht.sqlite`) là backup
  trọn bộ — vì DB nằm trong file.
