#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Convert san-pham.csv -> sanpham-import.csv for WP All Import.

Site dùng Custom Post Type `sanpham` + taxonomy `danh_muc_sp`
(xem wp/wp-content/mu-plugins/pccc-cpt.php), KHÔNG dùng WooCommerce.

Script này:
  1. Sửa lỗi font (mojibake) tiếng Việt nếu file bị double-encode UTF-8.
  2. Bỏ BOM, đổi tên/sắp lại cột theo đúng dạng WP All Import cần.
  3. Xuất UTF-8 chuẩn để import.

Dùng:  python3 scripts/convert-products-csv.py san-pham.csv sanpham-import.csv
"""

import csv
import sys

# ftfy sửa mojibake tốt nhất; nếu không có thì fallback thủ công.
try:
    from ftfy import fix_text
except ImportError:
    def fix_text(s: str) -> str:
        if not s:
            return s
        try:
            # double-encoded UTF-8 (vd: "DÃY CÃP" -> "DÂY CÁP")
            return s.encode("cp1252", "strict").decode("utf-8", "strict")
        except (UnicodeEncodeError, UnicodeDecodeError):
            return s  # text đã đúng -> giữ nguyên


def main() -> None:
    src = sys.argv[1] if len(sys.argv) > 1 else "san-pham.csv"
    dst = sys.argv[2] if len(sys.argv) > 2 else "sanpham-import.csv"

    # utf-8-sig: tự bỏ BOM nếu có.
    with open(src, "r", encoding="utf-8-sig", newline="") as f:
        rows = list(csv.reader(f))

    if not rows:
        sys.exit("File rỗng.")

    # Header đích cho WP All Import (cột theo VỊ TRÍ của file gốc).
    out_header = [
        "post_title",      # 1 - Tên sản phẩm  -> Title
        "danh_muc",        # 0 - Danh mục       -> taxonomy danh_muc_sp
        "sku",             # 2 - Mã hàng (SKU)  -> custom field
        "xuat_xu",         # 3 - Xuất xứ        -> custom field
        "don_vi_tinh",     # 4 - Đơn vị tính    -> custom field
        "post_content",    # 5 - Mô tả (HTML)   -> Content
        "image_url",       # 7 - Link hình ảnh  -> Featured image (nhiều ảnh ngăn bởi |)
        "link_tham_khao",  # 8 - Link tham khảo -> custom field (nội bộ)
    ]
    # chỉ số cột nguồn tương ứng từng cột đích ở trên
    src_index = [1, 0, 2, 3, 4, 5, 7, 8]

    n_in, n_out = 0, 0
    with open(dst, "w", encoding="utf-8", newline="") as f:
        w = csv.writer(f, quoting=csv.QUOTE_ALL)
        w.writerow(out_header)
        for row in rows[1:]:  # bỏ header gốc
            n_in += 1
            if not any(cell.strip() for cell in row):
                continue  # bỏ dòng trống
            cells = [fix_text(row[i].strip()) if i < len(row) else "" for i in src_index]
            if not cells[0]:
                continue  # bỏ dòng không có tên sản phẩm
            w.writerow(cells)
            n_out += 1

    print(f"Đọc {n_in} dòng, xuất {n_out} sản phẩm -> {dst}")


if __name__ == "__main__":
    main()
