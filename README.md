# Website PCCC Phước Long — WordPress

Website giới thiệu Công ty CP PCCC Phước Long, dựng bằng **WordPress + theme block tùy chỉnh**.
Chạy thử ở máy local; khi đưa lên hosting (domain **pcccphuoclong.vn**) xem **[DEPLOY.md](DEPLOY.md)**.

## ▶ Cách chạy & xem website

Mở **Terminal**, dán lệnh:

```bash
zsh /Volumes/ExtremeSSD/pccc_phuoc_long/start-website.sh
```

Sau đó mở trình duyệt:

| | Địa chỉ |
|---|---|
| 🌐 Trang web | http://127.0.0.1:8080 |
| 🔑 Trang quản trị | http://127.0.0.1:8080/wp-admin |

> Dùng **127.0.0.1** (không dùng `localhost`) để ảnh hiển thị chuẩn trên trình duyệt.

**Tài khoản quản trị:** `admin` · **Mật khẩu:** `PhuocLong@2025`
(Đổi mật khẩu trong: Người dùng → Hồ sơ.)

Dừng website: nhấn **Ctrl + C** trong Terminal.

## 🎨 Bộ màu thương hiệu (đổi 1 nơi → toàn site)

Khai báo trong `wp/wp-content/themes/pccc-phuoc-long/theme.json` → `settings.color.palette`:

| Tên | Mã | Vai trò |
|---|---|---|
| primary | `#1E4FA3` | Xanh dương chủ đạo |
| secondary | `#F7C600` | Vàng/gold |
| accent | `#E8312A` | Đỏ (nút CTA) |
| ink | `#15264A` | Chữ navy đậm |

Sửa mã màu trong file này rồi tải lại trang là toàn site đổi theo.
Hoặc đổi trực quan trong: **wp-admin → Giao diện → Trình chỉnh sửa (Editor) → Kiểu (Styles)**.

## 🗂 Cấu trúc nội dung

- **Trang:** Trang chủ, Giới thiệu, Dịch vụ, Năng lực, Liên hệ, Tin tức.
- **Dự án** (loại nội dung tùy chỉnh): 15 công trình thật (RMIT, Vietcombank, Saigon Centre…). Thêm/sửa tại **wp-admin → Dự án**.
- **Sản phẩm** (loại nội dung tùy chỉnh): 12 thiết bị mẫu theo 7 danh mục. Quản lý tại **wp-admin → Sản phẩm**.
- **Tin tức:** các bài viết (Bài viết).
- **Menu:** wp-admin → Giao diện → Trình chỉnh sửa → Điều hướng (Navigation).

## ✏️ Sửa nội dung
- Sửa text/ảnh từng trang: **wp-admin → Trang / Dự án / Sản phẩm → chọn mục → Sửa** (trình soạn khối).
- **Logo:** đã gắn (logo PL). Đổi tại wp-admin → Giao diện → Trình chỉnh sửa → Header → khối Logo.
- **Ảnh dự án/sản phẩm:** mở mục cần sửa → đặt "Ảnh đại diện" (Featured image). (Ảnh dự án đã lấy thật từ PDF.)
- **Hồ sơ năng lực PDF:** wp-admin → Media → tải file PDF lên → vào trang Năng lực gắn link vào nút tải.

## 🚚 Đưa lên hosting (domain pcccphuoclong.vn)
Xem hướng dẫn đầy đủ từng bước trong **[DEPLOY.md](DEPLOY.md)** (dùng All-in-One WP Migration).
Lưu ý: hosting cần **WordPress ≥ 6.6**; sau khi import nhớ **xoá `wp-content/db.php`** và thư mục
`plugins/sqlite-database-integration` (chỉ dùng cho local SQLite).

## 🛠 Thông tin kỹ thuật
- PHP 8.3 (Homebrew) · WordPress 7.0 (vi) · CSDL local: **SQLite** (plugin SQLite Database Integration).
- URL: `wp-config.php` tự nhận môi trường — local dùng `127.0.0.1:8080`, trên host dùng domain thật.
- Theme tùy chỉnh: `wp/wp-content/themes/pccc-phuoc-long/`
- CPT Dự án/Sản phẩm: `wp/wp-content/mu-plugins/pccc-cpt.php`
- Ảnh dự án/tin tức: lấy thật từ file PDF hồ sơ năng lực.
- Nội dung nguồn & script: thư mục `scripts/`
- WP-CLI: `~/bin/wp` (chạy bằng PHP 8.3 — xem `start-website.sh`).
