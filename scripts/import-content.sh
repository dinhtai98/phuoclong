#!/bin/zsh
# Import nội dung cho website PCCC Phước Long
set -e
WP="$HOME/bin/wp83"
cd /Volumes/ExtremeSSD/pccc_phuoc_long/wp
S=/Volumes/ExtremeSSD/pccc_phuoc_long/scripts

echo "==> Xóa nội dung mẫu mặc định"
$WP post delete 1 2 3 --force >/dev/null 2>&1 || true   # Hello world, sample page, privacy

echo "==> Tạo trang chủ"
HOME_ID=$($WP post create --post_type=page --post_status=publish --post_title="Trang chủ" \
  --post_content="$(cat $S/homepage.html)" --porcelain)
$WP post meta update $HOME_ID _wp_page_template page-no-title >/dev/null
$WP option update show_on_front page >/dev/null
$WP option update page_on_front $HOME_ID >/dev/null
echo "   Trang chủ ID=$HOME_ID"

echo "==> Tạo các trang nội dung"
GT_ID=$($WP post create --post_type=page --post_status=publish --post_name="gioi-thieu" --post_title="Giới thiệu" --post_content="$(cat $S/page-gioi-thieu.html)" --porcelain)
DV_ID=$($WP post create --post_type=page --post_status=publish --post_name="dich-vu" --post_title="Dịch vụ" --post_content="$(cat $S/page-dich-vu.html)" --porcelain)
NL_ID=$($WP post create --post_type=page --post_status=publish --post_name="nang-luc" --post_title="Năng lực" --post_content="$(cat $S/page-nang-luc.html)" --porcelain)
LH_ID=$($WP post create --post_type=page --post_status=publish --post_name="lien-he" --post_title="Liên hệ" --post_content="$(cat $S/page-lien-he.html)" --porcelain)

echo "==> Trang Tin tức (posts page)"
TT_ID=$($WP post create --post_type=page --post_status=publish --post_name="tin-tuc" --post_title="Tin tức" --post_content="" --porcelain)
$WP option update page_for_posts $TT_ID >/dev/null

echo "==> Tạo dự án (CPT duan)"
mk_duan () {
  local TITLE="$1"; local DC="$2"; local CDT="$3"; local PV="$4"; local TG="$5"
  local CONTENT="<!-- wp:paragraph --><p><strong>Địa điểm:</strong> ${DC}</p><!-- /wp:paragraph --><!-- wp:paragraph --><p><strong>Chủ đầu tư / Nhà thầu chính:</strong> ${CDT}</p><!-- /wp:paragraph --><!-- wp:paragraph --><p><strong>Phạm vi công việc:</strong> ${PV}</p><!-- /wp:paragraph --><!-- wp:paragraph --><p><strong>Thời gian:</strong> ${TG}</p><!-- /wp:paragraph -->"
  $WP post create --post_type=duan --post_status=publish --post_title="$TITLE" \
    --post_excerpt="${CDT} — ${PV}" --post_content="$CONTENT" --porcelain >/dev/null
  echo "   + $TITLE"
}

mk_duan "Đại học RMIT — Tòa nhà 808" "702 Nguyễn Văn Linh, P. Tân Hưng, Quận 7, TP.HCM" "Công ty TNHH Đại học RMIT Việt Nam" "Thiết kế thẩm duyệt, thi công lắp đặt và xin phép nghiệm thu PCCC" "03/2025"
mk_duan "Đại học RMIT — Căn tin &amp; nhà xe P1, P2" "702 Nguyễn Văn Linh, P. Tân Hưng, Quận 7, TP.HCM" "Công ty TNHH Đại học RMIT Việt Nam" "Thiết kế thẩm duyệt, thi công lắp đặt và xin phép nghiệm thu PCCC" "06/2025"
mk_duan "Tòa nhà MPLAZA — VP Masan tầng 8, 12" "39 Lê Duẩn, P. Sài Gòn, TP.HCM" "Công ty Cổ phần Nội thất Cơ Bản" "Thiết kế thẩm duyệt, thi công lắp đặt và xin phép nghiệm thu PCCC" "09/2025"
mk_duan "Tòa nhà MPLAZA — VP Becamex tầng 10, 20" "39 Lê Duẩn, P. Sài Gòn, TP.HCM" "Công ty Cổ phần Nội thất Cơ Bản" "Thiết kế thẩm duyệt, thi công lắp đặt và xin phép nghiệm thu PCCC" "08/2025"
mk_duan "Tòa nhà Nexus — VP JustCo tầng 19" "3A-3B Tôn Đức Thắng, P. Sài Gòn, TP.HCM" "Công ty Cổ phần Unity Architects" "Thiết kế thẩm duyệt, thi công lắp đặt và xin phép nghiệm thu PCCC" "07/2025"
mk_duan "Tòa nhà OfficeHaus — VP Bosch tầng 3–6" "32 Bờ Bao Tân Thắng, P. Sơn Kỳ, Q. Tân Phú, TP.HCM" "Công ty Cổ phần Unity Architects" "Cải tạo, thiết kế thẩm duyệt, thi công lắp đặt và nghiệm thu PCCC" "08/2024"
mk_duan "Lumiere Riverside — tầng trệt đến tầng 7" "277 Võ Nguyên Giáp, P. An Phú, TP. Thủ Đức, TP.HCM" "Công ty TNHH Kỹ thuật Xây dựng Đồng Phong (Việt Nam)" "Thiết kế thẩm duyệt, thi công lắp đặt và xin phép nghiệm thu PCCC" "05/2024"
mk_duan "Tòa nhà Vietcombank Quận 1" "05 Công Trường Mê Linh, P. Bến Nghé, Quận 1, TP.HCM" "Nhiều nhà thầu nội thất (Cơ Bản, Space.S, Hoàng Phát…)" "Thiết kế thẩm duyệt, thi công lắp đặt hệ thống PCCC nhiều tầng; bảo trì cấp thoát nước" "2018–2023"
mk_duan "Tòa nhà Time Square — tầng 12" "22–36 Nguyễn Huệ, P. Bến Nghé, Quận 1, TP.HCM" "Công ty Cổ phần Nội thất Cơ Bản" "Thiết kế thẩm duyệt, thi công lắp đặt hệ thống PCCC" "2023"
mk_duan "TTTM Estella Quận 2 — tầng 1–4" "88 Song Hành, P. An Phú, TP. Thủ Đức, TP.HCM" "Công ty TNHH Thời trang &amp; Mỹ phẩm Âu Châu (ACFC)" "Thi công lắp đặt hệ thống PCCC, cấp giấy phép hoạt động" "2023"
mk_duan "Tòa nhà LIM — tầng 33" "9–11 Tôn Đức Thắng, Quận 1, TP.HCM" "Công ty TNHH Đầu tư Xây dựng Nội thất Toàn Cầu" "Thiết kế thẩm duyệt, thi công lắp đặt hệ thống PCCC" "2023"
mk_duan "Tòa nhà Saigon Centre" "65 Lê Lợi, P. Bến Nghé, Quận 1, TP.HCM" "FIXX Việt Nam, In Do Trần, Giải trí LT, Takahiro…" "Thiết kế thẩm duyệt, thi công lắp đặt hệ thống PCCC nhiều tầng" "2023"
mk_duan "Tòa nhà CII Bình Thạnh" "152 Điện Biên Phủ, Bình Thạnh, TP.HCM" "UNIK, Space.S, Unity Architects" "Thiết kế thẩm duyệt, thi công lắp đặt hệ thống PCCC nhiều tầng" "2023"
mk_duan "Tòa nhà Sonatus" "15 Lê Thánh Tôn, P. Bến Nghé, Quận 1, TP.HCM" "Công ty Cổ phần Nội thất Cơ Bản" "Thi công và nghiệm thu PCCC nhiều tầng" "2023"
mk_duan "Tòa nhà Opal Tower" "92 Nguyễn Hữu Cảnh, P. 22, Bình Thạnh, TP.HCM" "Duo Bao Xun, TTT, Baris Arch, Touch Studio…" "Thiết kế thẩm duyệt, thi công lắp đặt và nghiệm thu hệ thống PCCC" "2022–2023"

echo "==> Danh mục sản phẩm"
for CAT in "Hệ thống báo cháy" "Đầu báo cháy" "Bình chữa cháy" "Vòi, trụ &amp; cuộn vòi chữa cháy" "Hệ thống chữa cháy tự động" "Máy bơm &amp; tủ điều khiển" "Đèn Exit &amp; thiết bị bảo hộ"; do
  $WP term create danh_muc_sp "$CAT" >/dev/null 2>&1 || true
done

echo "==> Sản phẩm mẫu"
mk_sp () {
  local TITLE="$1"; local CAT="$2"; local DESC="$3"
  local ID=$($WP post create --post_type=sanpham --post_status=publish --post_title="$TITLE" \
    --post_excerpt="$DESC" --post_content="<!-- wp:paragraph --><p>${DESC}</p><!-- /wp:paragraph --><!-- wp:paragraph --><p><em>Liên hệ 079 8285 114 để được báo giá.</em></p><!-- /wp:paragraph -->" --porcelain)
  $WP post term set $ID danh_muc_sp "$CAT" >/dev/null 2>&1 || true
  echo "   + $TITLE"
}
mk_sp "Trung tâm báo cháy địa chỉ" "Hệ thống báo cháy" "Tủ trung tâm báo cháy địa chỉ, giám sát theo từng khu vực (zone) cho công trình lớn."
mk_sp "Trung tâm báo cháy thường" "Hệ thống báo cháy" "Tủ trung tâm báo cháy thường, phù hợp công trình vừa và nhỏ."
mk_sp "Đầu báo khói quang" "Đầu báo cháy" "Đầu báo khói quang điện, phát hiện sớm khói cháy âm ỉ."
mk_sp "Đầu báo nhiệt gia tăng" "Đầu báo cháy" "Đầu báo nhiệt cố định/gia tăng cho khu vực có nhiệt độ thay đổi."
mk_sp "Bình chữa cháy bột ABC" "Bình chữa cháy" "Bình chữa cháy bột ABC đa năng, dập tắt nhiều loại đám cháy."
mk_sp "Bình chữa cháy khí CO2" "Bình chữa cháy" "Bình chữa cháy khí CO2 cho phòng kỹ thuật, thiết bị điện."
mk_sp "Cuộn vòi chữa cháy &amp; lăng phun" "Vòi, trụ &amp; cuộn vòi chữa cháy" "Cuộn vòi vải tráng cao su kèm lăng phun, khớp nối đồng tiêu chuẩn."
mk_sp "Trụ nước chữa cháy" "Vòi, trụ &amp; cuộn vòi chữa cháy" "Trụ nước chữa cháy ngoài nhà, vật liệu gang/thép chịu áp lực cao."
mk_sp "Hệ thống Sprinkler tự động" "Hệ thống chữa cháy tự động" "Hệ thống chữa cháy tự động Sprinkler theo vùng nguy cơ."
mk_sp "Hệ thống chữa cháy khí FM-200 / Novec 1230" "Hệ thống chữa cháy tự động" "Chữa cháy bằng khí sạch cho data center, kho lưu trữ."
mk_sp "Máy bơm chữa cháy &amp; tủ điều khiển" "Máy bơm &amp; tủ điều khiển" "Cụm máy bơm chính – bù – dự phòng và tủ điều khiển báo động van."
mk_sp "Đèn Exit &amp; đèn sự cố" "Đèn Exit &amp; thiết bị bảo hộ" "Đèn chỉ dẫn thoát hiểm Exit và đèn chiếu sáng sự cố."

echo "==> Tin tức"
mk_news () {
  $WP post create --post_type=post --post_status=publish --post_title="$1" \
    --post_excerpt="$2" --post_content="<!-- wp:paragraph --><p>$2</p><!-- /wp:paragraph -->" --porcelain >/dev/null
  echo "   + $1"
}
mk_news "Quy định mới về điều kiện kinh doanh dịch vụ PCCC theo Nghị định 136/2020/NĐ-CP" "Tổng hợp các điều kiện và thủ tục để doanh nghiệp đủ điều kiện kinh doanh dịch vụ phòng cháy chữa cháy."
mk_news "Hướng dẫn bảo trì hệ thống PCCC định kỳ cho tòa nhà văn phòng" "Lịch và hạng mục bảo trì hệ thống báo cháy, chữa cháy, máy bơm giúp đảm bảo an toàn vận hành."
mk_news "PCCC Phước Long hoàn thành dự án hệ thống PCCC tại Đại học RMIT" "Phước Long thực hiện thiết kế thẩm duyệt, thi công lắp đặt và nghiệm thu PCCC cho các hạng mục tại RMIT năm 2025."

echo "==> Lưu ID trang để tạo menu"
echo "$GT_ID $DV_ID $NL_ID $LH_ID $TT_ID $HOME_ID" > $S/.page_ids
echo "DONE."