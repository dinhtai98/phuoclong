/**
 * Mega menu danh mục sản phẩm — hành vi mobile:
 * trong drawer, chạm "Sản phẩm" mở drawer danh mục (cấp 2) trước,
 * chọn danh mục mới điều hướng tới trang sản phẩm.
 */
(function () {
	'use strict';

	function init() {
		var megaItems = document.querySelectorAll('li.pccc-has-mega');
		if (!megaItems.length) {
			return;
		}

		megaItems.forEach(function (li) {
			var link = li.querySelector('a.wp-block-navigation-item__content');
			var back = li.querySelector('.pccc-mega__back');

			if (link) {
				link.addEventListener('click', function (e) {
					// Chỉ chặn điều hướng khi đang ở trong drawer mobile.
					if (li.closest('.wp-block-navigation__responsive-container.is-menu-open')) {
						e.preventDefault();
						li.classList.add('is-sub-open');
					}
				});
			}

			if (back) {
				back.addEventListener('click', function () {
					li.classList.remove('is-sub-open');
				});
			}
		});

		// Đóng / mở lại drawer chính -> reset drawer danh mục.
		document.addEventListener('click', function (e) {
			if (e.target.closest('.wp-block-navigation__responsive-container-close, .wp-block-navigation__responsive-container-open')) {
				megaItems.forEach(function (li) {
					li.classList.remove('is-sub-open');
				});
			}

			// Chạm vùng tối bên ngoài drawer -> đóng menu.
			if (
				e.target.classList &&
				e.target.classList.contains('wp-block-navigation__responsive-container') &&
				e.target.classList.contains('is-menu-open')
			) {
				var closeBtn = e.target.querySelector('.wp-block-navigation__responsive-container-close');
				if (closeBtn) {
					closeBtn.click();
				}
			}
		});
	}

	if (document.readyState !== 'loading') {
		init();
	} else {
		document.addEventListener('DOMContentLoaded', init);
	}
})();
