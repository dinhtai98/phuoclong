#!/bin/zsh
# ============================================================
#  Khởi động website PCCC Phước Long (WordPress local)
#  Cách dùng: mở Terminal, chạy:  zsh start-website.sh
#  Dừng:      nhấn Ctrl + C
# ============================================================

PHP=/opt/homebrew/opt/php@8.3/bin/php
WP="$HOME/bin/wp"
WPDIR="$(cd "$(dirname "$0")" && pwd)/wp"
PORT=8080

echo "▶  Đang khởi động website PCCC Phước Long..."
echo "   Thư mục WordPress: $WPDIR"
echo "   Địa chỉ xem web:   http://127.0.0.1:$PORT"
echo "   Trang quản trị:    http://127.0.0.1:$PORT/wp-admin  (admin / PhuocLong@2025)"
echo "   (Dùng 127.0.0.1 thay vì localhost để ảnh hiển thị chuẩn. Nhấn Ctrl + C để dừng)"
echo "------------------------------------------------------------"

cd "$WPDIR"
# Cho phép server xử lý nhiều request đồng thời (ảnh, CSS...) — tránh ảnh bị vỡ
export PHP_CLI_SERVER_WORKERS=8
exec "$PHP" -d memory_limit=512M "$WP" server --host=0.0.0.0 --port=$PORT --path="$WPDIR"
