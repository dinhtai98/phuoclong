#!/bin/zsh
# Sinh ảnh bìa SVG thương hiệu cho dự án & sản phẩm
set -e
OUT=/Volumes/ExtremeSSD/pccc_phuoc_long/scripts/covers
mkdir -p "$OUT"

# ---- Defs dùng chung (gradient + lưới) ----
read -r -d '' DEFS <<'SVG' || true
<defs>
  <linearGradient id="g" x1="0" y1="0" x2="1" y2="1">
    <stop offset="0" stop-color="#16306b"/><stop offset="0.55" stop-color="#1E4FA3"/><stop offset="1" stop-color="#214f9e"/>
  </linearGradient>
  <linearGradient id="gr" x1="0" y1="0" x2="1" y2="1">
    <stop offset="0" stop-color="#b81f19"/><stop offset="1" stop-color="#E8312A"/>
  </linearGradient>
  <pattern id="grid" width="42" height="42" patternUnits="userSpaceOnUse">
    <path d="M42 0H0V42" fill="none" stroke="#ffffff" stroke-opacity="0.07" stroke-width="1"/>
  </pattern>
</defs>
SVG

# ====== PROJECT COVERS (skyline) ======
proj_cover () {
  local FILE="$1"; local ACCENT="$2"; local SKY="$3"
  cat > "$OUT/$FILE" <<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 750" width="1200" height="750">
$DEFS
<rect width="1200" height="750" fill="url(#g)"/>
<rect width="1200" height="750" fill="url(#grid)"/>
<circle cx="1040" cy="150" r="220" fill="$ACCENT" opacity="0.16"/>
<g fill="#ffffff" opacity="0.92">$SKY</g>
<g transform="translate(70,70)">
  <circle cx="34" cy="34" r="34" fill="#ffffff"/>
  <text x="34" y="46" font-family="Arial, sans-serif" font-size="30" font-weight="800" fill="#1E4FA3" text-anchor="middle">PL</text>
  <text x="86" y="28" font-family="Arial, sans-serif" font-size="20" font-weight="800" fill="#ffffff">PCCC PHƯỚC LONG</text>
  <text x="86" y="54" font-family="Arial, sans-serif" font-size="15" fill="#F7C600">Hệ thống phòng cháy chữa cháy</text>
</g>
</svg>
SVG
}
# skyline variants (bộ toà nhà khác nhau)
proj_cover "proj-1.svg" "#F7C600" '<rect x="120" y="470" width="90" height="230" rx="4"/><rect x="230" y="380" width="110" height="320" rx="4"/><rect x="360" y="300" width="80" height="400" rx="4"/><rect x="460" y="440" width="120" height="260" rx="4"/><rect x="600" y="350" width="90" height="350" rx="4"/><rect x="710" y="420" width="130" height="280" rx="4"/><rect x="860" y="320" width="95" height="380" rx="4"/><rect x="975" y="460" width="110" height="240" rx="4"/>'
proj_cover "proj-2.svg" "#E8312A" '<rect x="120" y="520" width="120" height="180" rx="4"/><rect x="260" y="360" width="95" height="340" rx="4"/><rect x="375" y="280" width="120" height="420" rx="4"/><rect x="515" y="430" width="90" height="270" rx="4"/><rect x="625" y="330" width="120" height="370" rx="4"/><rect x="765" y="400" width="95" height="300" rx="4"/><rect x="880" y="300" width="120" height="400" rx="4"/><rect x="1020" y="500" width="80" height="200" rx="4"/>'
proj_cover "proj-3.svg" "#F7C600" '<rect x="130" y="400" width="100" height="300" rx="4"/><rect x="250" y="500" width="110" height="200" rx="4"/><rect x="380" y="330" width="95" height="370" rx="4"/><rect x="495" y="420" width="120" height="280" rx="4"/><rect x="635" y="290" width="90" height="410" rx="4"/><rect x="745" y="440" width="120" height="260" rx="4"/><rect x="885" y="360" width="95" height="340" rx="4"/><rect x="1000" y="470" width="100" height="230" rx="4"/>'
proj_cover "proj-4.svg" "#E8312A" '<rect x="120" y="460" width="110" height="240" rx="4"/><rect x="250" y="320" width="90" height="380" rx="4"/><rect x="360" y="420" width="120" height="280" rx="4"/><rect x="500" y="280" width="95" height="420" rx="4"/><rect x="615" y="440" width="120" height="260" rx="4"/><rect x="755" y="340" width="90" height="360" rx="4"/><rect x="865" y="430" width="120" height="270" rx="4"/><rect x="1005" y="380" width="90" height="320" rx="4"/>'

# ====== PRODUCT COVERS (icon trung tâm) ======
prod_cover () {
  local FILE="$1"; local LABEL="$2"; local ICON="$3"
  cat > "$OUT/$FILE" <<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 750" width="1200" height="750">
$DEFS
<rect width="1200" height="750" fill="url(#g)"/>
<rect width="1200" height="750" fill="url(#grid)"/>
<circle cx="600" cy="330" r="170" fill="#ffffff" opacity="0.10"/>
<g transform="translate(600,330)" stroke="#ffffff" stroke-width="9" fill="none" stroke-linecap="round" stroke-linejoin="round">$ICON</g>
<text x="600" y="600" font-family="Arial, sans-serif" font-size="40" font-weight="800" fill="#ffffff" text-anchor="middle">$LABEL</text>
<text x="600" y="650" font-family="Arial, sans-serif" font-size="22" fill="#F7C600" text-anchor="middle">PCCC PHƯỚC LONG</text>
</svg>
SVG
}
# icon path đặt trong hệ toạ độ tâm (scale ~ -70..70)
prod_cover "sp-baochay.svg"  "Hệ thống báo cháy"        '<path d="M-45 30a45 45 0 0 1 90 0z" transform="scale(1.1)"/><path d="M0 -55v8" transform="scale(1.1)"/><path d="M-58 -15l-6-4M58 -15l6-4" transform="scale(1.1)"/>'
prod_cover "sp-daubao.svg"   "Đầu báo cháy"             '<circle r="55"/><circle r="20"/><path d="M0 -70v10M0 60v10M-70 0h10M60 0h10"/>'
prod_cover "sp-binh.svg"     "Bình chữa cháy"           '<rect x="-30" y="-30" width="60" height="95" rx="22"/><path d="M-12 -30v-22h24v22M0 -52v-14h26"/>'
prod_cover "sp-voi.svg"      "Vòi &amp; trụ chữa cháy"      '<path d="M0 70c34 0 50-26 50-52 0-30-34-46-50-78-16 32-50 48-50 78 0 26 16 52 50 52z"/>'
prod_cover "sp-sprinkler.svg" "Chữa cháy tự động"       '<path d="M-70 -40h140"/><path d="M0 -40v18"/><path d="M-30 10c0 16 14 30 30 30s30-14 30-30M-30 10a30 30 0 0 1 60 0z"/>'
prod_cover "sp-maybom.svg"   "Máy bơm &amp; tủ điều khiển"  '<circle r="55"/><path d="M0 -34v34l24 14"/>'
prod_cover "sp-exit.svg"     "Đèn Exit &amp; bảo hộ"        '<rect x="-65" y="-45" width="130" height="90" rx="10"/><circle cx="-22" cy="0" r="10"/><path d="M-22 12v22M-22 18l16 10M-22 20l-14 8"/><path d="M20 -18h26v36h-26M46 0h18m-10-10l10 10-10 10"/>'

echo "Đã sinh $(ls "$OUT" | wc -l | tr -d ' ') ảnh SVG vào $OUT"
ls "$OUT"