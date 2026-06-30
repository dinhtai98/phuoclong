#!/bin/zsh
# Gán ảnh THẬT từ PDF hồ sơ năng lực cho Dự án & Tin tức
export PATH="/opt/homebrew/bin:/usr/bin:/bin:$PATH"
WP="$HOME/bin/wp83"
cd /Volumes/ExtremeSSD/pccc_phuoc_long/wp
IMG=/Volumes/ExtremeSSD/pccc_phuoc_long/scripts/pdfimg

imp () { # $1=file $2=title
  $WP media import "$1" --title="$2" --alt="$2" --porcelain 2>/dev/null | tail -1
}

echo "==> Import ảnh dự án (mỗi toà nhà 1 lần)"
typeset -A P
P[18]=$(imp "$IMG/proj-18.jpg" "Dự án PCCC Đại học RMIT")
P[19]=$(imp "$IMG/proj-19.jpg" "Dự án PCCC Tòa nhà MPlaza")
P[20]=$(imp "$IMG/proj-20.jpg" "Dự án PCCC Tòa nhà Nexus")
P[21]=$(imp "$IMG/proj-21.jpg" "Dự án PCCC Tòa nhà OfficeHaus")
P[22]=$(imp "$IMG/proj-22.jpg" "Dự án PCCC Lumiere Riverside")
P[23]=$(imp "$IMG/proj-23.jpg" "Dự án PCCC Tòa nhà Vietcombank Quận 1")
P[25]=$(imp "$IMG/proj-25.jpg" "Dự án PCCC Tòa nhà Time Square")
P[26]=$(imp "$IMG/proj-26.jpg" "Dự án PCCC TTTM Estella Quận 2")
P[27]=$(imp "$IMG/proj-27.jpg" "Dự án PCCC Tòa nhà LIM")
P[28]=$(imp "$IMG/proj-28.jpg" "Dự án PCCC Tòa nhà Saigon Centre")
P[29]=$(imp "$IMG/proj-29.jpg" "Dự án PCCC Tòa nhà CII Bình Thạnh")
P[30]=$(imp "$IMG/proj-30.jpg" "Dự án PCCC Tòa nhà Sonatus")
P[31]=$(imp "$IMG/proj-31.jpg" "Dự án PCCC Tòa nhà Opal Tower")
echo "   IDs: 18=${P[18]} 19=${P[19]} 20=${P[20]} 21=${P[21]} 22=${P[22]} 23=${P[23]} 25=${P[25]} 26=${P[26]} 27=${P[27]} 28=${P[28]} 29=${P[29]} 30=${P[30]} 31=${P[31]}"

echo "==> Import ảnh hiện trường (tin tức)"
W1=$(imp "$IMG/work-1.jpg" "Kỹ thuật viên PCCC Phước Long")
W33=$(imp "$IMG/work-33.jpg" "Thi công hệ thống máy bơm chữa cháy")
echo "   work: $W1 $W33"

page_for () { # echo page number theo tiêu đề dự án
  case "$1" in
    *RMIT*) echo 18;; *MPLAZA*|*MPlaza*) echo 19;; *Nexus*) echo 20;;
    *OfficeHaus*) echo 21;; *Lumiere*) echo 22;; *Vietcombank*) echo 23;;
    *"Time Square"*) echo 25;; *Estella*) echo 26;; *LIM*) echo 27;;
    *"Saigon Centre"*) echo 28;; *CII*) echo 29;; *Sonatus*) echo 30;; *Opal*) echo 31;;
    *) echo "";;
  esac
}

echo "==> Gán ảnh cho từng Dự án"
for pid in $($WP post list --post_type=duan --field=ID --posts_per_page=-1 2>/dev/null); do
  title=$($WP post get "$pid" --field=post_title 2>/dev/null)
  pg=$(page_for "$title")
  if [ -n "$pg" ] && [ -n "${P[$pg]}" ]; then
    $WP post meta update "$pid" _thumbnail_id "${P[$pg]}" >/dev/null
    echo "   ✓ [$title] -> ảnh trang $pg (att ${P[$pg]})"
  else
    echo "   ⚠ [$title] không khớp ảnh"
  fi
done

echo "==> Gán ảnh cho Tin tức"
for pid in $($WP post list --post_type=post --field=ID --posts_per_page=-1 2>/dev/null); do
  title=$($WP post get "$pid" --field=post_title 2>/dev/null)
  case "$title" in
    *RMIT*)        att=${P[18]};;
    *trì*|*bảo*)   att=$W33;;
    *)             att=$W1;;
  esac
  $WP post meta update "$pid" _thumbnail_id "$att" >/dev/null
  echo "   ✓ [$title] -> att $att"
done
echo "DONE."