#!/usr/bin/env python3
"""
Restructure static HTML site for clean URLs on GitHub Pages.
Each xxx.html -> xxx/index.html
Updates all internal links, asset paths, and canonical URLs.
"""
import os
import re

ROOT = os.path.dirname(os.path.abspath(__file__))

PAGES = [
    "cua-hang",
    "dich-vu",
    "du-an",
    "gioi-thieu",
    "khu-vuc",
    "lien-he",
    "tin-tuc",
]


def fix_links_for_subpage(content: str) -> str:
    """Fix links inside a file that lives in a subdirectory."""
    for page in PAGES:
        content = content.replace(f'href="{page}.html"', f'href="../{page}/"')
        content = content.replace(f"href='{page}.html'", f"href='../{page}/'")
    content = content.replace('href="index.html"', 'href="../"')
    content = content.replace("href='index.html'", "href='../'")

    # Fix asset paths: add ../ prefix
    for attr in ['href="css/', "href='css/", 'src="css/']:
        content = content.replace(attr, attr.replace('css/', '../css/'))
    for attr in ['src="js/', "src='js/"]:
        content = content.replace(attr, attr.replace('js/', '../js/'))
    for attr in ['src="images/', "src='images/"]:
        content = content.replace(attr, attr.replace('images/', '../images/'))

    # Fix canonical URLs
    content = re.sub(
        r'href="https://pcccphuoclong\.vn/([^"]+?)\.html"',
        lambda m: f'href="https://pcccphuoclong.vn/{m.group(1)}/"',
        content,
    )
    return content


def fix_links_for_index(content: str) -> str:
    """Fix links inside root index.html."""
    for page in PAGES:
        content = content.replace(f'href="{page}.html"', f'href="{page}/"')
        content = content.replace(f"href='{page}.html'", f"href='{page}/'")
    content = content.replace('href="index.html"', 'href="./"')
    return content


def update_sitemap(content: str) -> str:
    return re.sub(
        r'<loc>(https://[^<]*?)\.html</loc>',
        lambda m: f'<loc>{m.group(1)}/</loc>',
        content,
    )


def main():
    # Fix root index.html
    index_path = os.path.join(ROOT, "index.html")
    with open(index_path, "r", encoding="utf-8") as f:
        content = f.read()
    content = fix_links_for_index(content)
    with open(index_path, "w", encoding="utf-8") as f:
        f.write(content)
    print("✅ Updated index.html")

    # Move each page into its own folder
    for page in PAGES:
        src = os.path.join(ROOT, f"{page}.html")
        dest_dir = os.path.join(ROOT, page)
        dest = os.path.join(dest_dir, "index.html")

        if not os.path.exists(src):
            print(f"⚠️  Skipping {page}.html (not found)")
            continue

        os.makedirs(dest_dir, exist_ok=True)

        with open(src, "r", encoding="utf-8") as f:
            content = f.read()
        content = fix_links_for_subpage(content)
        with open(dest, "w", encoding="utf-8") as f:
            f.write(content)

        os.remove(src)
        print(f"✅ {page}.html  →  {page}/index.html")

    # Update sitemap.xml
    sitemap_path = os.path.join(ROOT, "sitemap.xml")
    if os.path.exists(sitemap_path):
        with open(sitemap_path, "r", encoding="utf-8") as f:
            content = f.read()
        content = update_sitemap(content)
        with open(sitemap_path, "w", encoding="utf-8") as f:
            f.write(content)
        print("✅ Updated sitemap.xml")

    print("\n🎉 Done! Clean URLs ready for GitHub Pages.")
    print("Example: https://dinhtai98.github.io/phuoclong/du-an/")


if __name__ == "__main__":
    main()
