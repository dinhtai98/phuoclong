#!/bin/zsh
set -e
WP="$HOME/bin/wp83"
cd /Volumes/ExtremeSSD/pccc_phuoc_long/wp
C=/Volumes/ExtremeSSD/pccc_phuoc_long/scripts/covers

echo "==> Sửa tên danh mục có &amp; -> &"
$WP term list danh_muc_sp --fields=term_id,name --format=csv 2>/dev/null | grep -i "amp;" | while IFS=, read -r tid name; do
  fixed=$(echo "$name" | sed 's/&amp;/\&/g' | tr -d '"')
  $WP term update danh_muc_sp "$tid" --name="$fixed" >/dev/null 2>&1 || true
done

echo "==> Import ảnh bìa (1 lần mỗi ảnh)"
imp () { $WP media import "$1" --porcelain 2>/dev/null | tail -1; }
P1=$(imp "$C/proj-1.svg"); P2=$(imp "$C/proj-2.svg"); P3=$(imp "$C/proj-3.svg"); P4=$(imp "$C/proj-4.svg")
A_BAOCHAY=$(imp "$C/sp-baochay.svg"); A_DAUBAO=$(imp "$C/sp-daubao.svg"); A_BINH=$(imp "$C/sp-binh.svg")
A_VOI=$(imp "$C/sp-voi.svg"); A_SPR=$(imp "$C/sp-sprinkler.svg"); A_BOM=$(imp "$C/sp-maybom.svg"); A_EXIT=$(imp "$C/sp-exit.svg")
echo "   proj: $P1 $P2 $P3 $P4 | sp: $A_BAOCHAY $A_DAUBAO $A_BINH $A_VOI $A_SPR $A_BOM $A_EXIT"

PROJ=($P1 $P2 $P3 $P4)

echo "==> Gán ảnh bìa cho Dự án (luân phiên 4 mẫu)"
i=0
for pid in $($WP post list --post_type=duan --field=ID --posts_per_page=-1 2>/dev/null); do
  att=${PROJ[$(( i % 4 + 1 ))]}
  $WP post meta update "$pid" _thumbnail_id "$att" >/dev/null
  i=$((i+1))
done
echo "   đã gán $i dự án"

echo "==> Gán ảnh bìa cho Sản phẩm (theo loại)"
for pid in $($WP post list --post_type=sanpham --field=ID --posts_per_page=-1 2>/dev/null); do
  title=$(echo "$($WP post get "$pid" --field=post_title 2>/dev/null)" | tr '[:upper:]' '[:lower:]')
  case "$title" in
    *"đầu báo"*)        att=$A_DAUBAO ;;
    *"báo cháy"*)       att=$A_BAOCHAY ;;
    *"bình chữa"*)      att=$A_BINH ;;
    *vòi*|*trụ*)        att=$A_VOI ;;
    *sprinkler*|*"fm-200"*|*novec*|*"tự động"*) att=$A_SPR ;;
    *bơm*)              att=$A_BOM ;;
    *exit*|*"sự cố"*)   att=$A_EXIT ;;
    *)                  att=$A_BAOCHAY ;;
  esac
  $WP post meta update "$pid" _thumbnail_id "$att" >/dev/null
done
echo "   xong sản phẩm"

echo "==> Gán ảnh bìa cho Tin tức"
j=0
for pid in $($WP post list --post_type=post --field=ID --posts_per_page=-1 2>/dev/null); do
  att=${PROJ[$(( j % 4 + 1 ))]}
  $WP post meta update "$pid" _thumbnail_id "$att" >/dev/null
  j=$((j+1))
done
echo "   đã gán $j tin"

echo "==> Cập nhật nội dung Trang chủ mới vào CSDL"
HOME_ID=$($WP option get page_on_front 2>/dev/null)
$WP post update "$HOME_ID" --post_content="$(cat /Volumes/ExtremeSSD/pccc_phuoc_long/scripts/homepage.html)" >/dev/null
echo "   Trang chủ ID=$HOME_ID đã cập nhật"
echo "DONE."