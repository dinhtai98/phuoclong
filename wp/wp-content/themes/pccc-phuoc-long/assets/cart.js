/* ============================================================
   PCCC Phước Long — Giỏ hàng / Yêu cầu báo giá (client-side)
   Lưu localStorage, không cần WooCommerce. Kết đơn qua Zalo.
   ============================================================ */
( function () {
	'use strict';

	var CFG = window.PCCC_CART || {};
	var PHONE = CFG.phone || '0798285114';
	var ZALO = CFG.zalo || ( 'https://zalo.me/' + PHONE );
	var CART_URL = CFG.cartUrl || '/gio-hang/';
	var SITE = CFG.site || 'PCCC Phước Long';
	var DOMAIN = CFG.domain || '';
	var KEY = 'pccc_cart_v1';

	/* ---------- Lưu trữ ---------- */
	function read() {
		try {
			var raw = localStorage.getItem( KEY );
			var arr = raw ? JSON.parse( raw ) : [];
			return Array.isArray( arr ) ? arr : [];
		} catch ( e ) { return []; }
	}
	function write( cart ) {
		try { localStorage.setItem( KEY, JSON.stringify( cart ) ); } catch ( e ) {}
		paintBadge();
		document.dispatchEvent( new CustomEvent( 'pccc:cart-changed' ) );
	}
	function count() {
		return read().reduce( function ( n, i ) { return n + ( i.qty || 1 ); }, 0 );
	}
	function add( item ) {
		var cart = read();
		var found = cart.filter( function ( i ) { return String( i.id ) === String( item.id ); } )[ 0 ];
		if ( found ) { found.qty = ( found.qty || 1 ) + 1; }
		else { cart.push( { id: item.id, name: item.name, url: item.url, qty: 1 } ); }
		write( cart );
	}
	function setQty( id, qty ) {
		var cart = read();
		qty = Math.max( 1, parseInt( qty, 10 ) || 1 );
		cart.forEach( function ( i ) { if ( String( i.id ) === String( id ) ) { i.qty = qty; } } );
		write( cart );
	}
	function remove( id ) {
		write( read().filter( function ( i ) { return String( i.id ) !== String( id ); } ) );
	}
	function clear() { write( [] ); }

	/* ---------- Toast ---------- */
	var toastTimer;
	function toast( msg ) {
		var t = document.getElementById( 'pccc-toast' );
		if ( ! t ) {
			t = document.createElement( 'div' );
			t.id = 'pccc-toast';
			document.body.appendChild( t );
		}
		t.innerHTML = msg;
		t.classList.add( 'is-show' );
		clearTimeout( toastTimer );
		toastTimer = setTimeout( function () { t.classList.remove( 'is-show' ); }, 3200 );
	}

	/* ---------- Nút giỏ nổi (badge) ---------- */
	function paintBadge() {
		var n = count();
		document.querySelectorAll( '.pccc-cart-fab .pccc-cart-badge' ).forEach( function ( b ) {
			b.textContent = n;
			b.style.display = n > 0 ? 'flex' : 'none';
		} );
	}

	/* ---------- Nút "Thêm vào giỏ" ---------- */
	function bindAddButtons() {
		document.addEventListener( 'click', function ( e ) {
			var btn = e.target.closest ? e.target.closest( '.pccc-add-cart' ) : null;
			if ( ! btn ) { return; }
			e.preventDefault();
			var item = {
				id: btn.getAttribute( 'data-id' ),
				name: btn.getAttribute( 'data-name' ),
				url: btn.getAttribute( 'data-url' )
			};
			if ( ! item.id ) { return; }
			add( item );
			btn.classList.add( 'is-added' );
			var old = btn.getAttribute( 'data-label' ) || btn.innerHTML;
			if ( ! btn.getAttribute( 'data-label' ) ) { btn.setAttribute( 'data-label', old ); }
			btn.innerHTML = '✓ Đã thêm';
			setTimeout( function () {
				btn.classList.remove( 'is-added' );
				btn.innerHTML = btn.getAttribute( 'data-label' );
			}, 1400 );
			toast( '<b>Đã thêm:</b> ' + item.name + ' &nbsp;·&nbsp; <a href="' + CART_URL + '">Xem giỏ hàng (' + count() + ') →</a>' );
		} );
	}

	/* ---------- Nội dung đơn hàng (text gửi Zalo) ---------- */
	function buildOrderText( info ) {
		var cart = read();
		var lines = [];
		lines.push( '🔥 YÊU CẦU BÁO GIÁ — ' + SITE );
		lines.push( '——————————————' );
		cart.forEach( function ( i, idx ) {
			lines.push( ( idx + 1 ) + '. ' + i.name + '  —  SL: ' + ( i.qty || 1 ) );
		} );
		lines.push( '——————————————' );
		lines.push( 'Tổng số mặt hàng: ' + cart.length + ' (SL: ' + count() + ')' );
		if ( info && info.name ) { lines.push( 'Họ tên: ' + info.name ); }
		if ( info && info.phone ) { lines.push( 'SĐT: ' + info.phone ); }
		if ( info && info.note ) { lines.push( 'Ghi chú: ' + info.note ); }
		if ( DOMAIN ) { lines.push( '(Gửi từ website ' + DOMAIN + ')' ); }
		return lines.join( '\n' );
	}

	/* ---------- Trang giỏ hàng ---------- */
	function renderCart() {
		var root = document.getElementById( 'pccc-cart-root' );
		if ( ! root ) { return; }
		var cart = read();

		if ( ! cart.length ) {
			root.innerHTML =
				'<div class="pccc-cart-empty">' +
					'<div class="pccc-cart-empty-ic">🛒</div>' +
					'<h3>Giỏ hàng đang trống</h3>' +
					'<p>Hãy chọn các sản phẩm/thiết bị PCCC bạn quan tâm để gửi yêu cầu báo giá.</p>' +
					'<a class="pccc-btn pccc-btn-primary" href="/san-pham/">Xem sản phẩm</a>' +
				'</div>';
			return;
		}

		var rows = cart.map( function ( i ) {
			return '' +
				'<tr data-id="' + i.id + '">' +
					'<td class="pccc-ci-name"><a href="' + i.url + '">' + escapeHtml( i.name ) + '</a></td>' +
					'<td class="pccc-ci-qty">' +
						'<div class="pccc-qty">' +
							'<button type="button" class="pccc-qty-dec" aria-label="Giảm">−</button>' +
							'<input type="number" class="pccc-qty-inp" min="1" value="' + ( i.qty || 1 ) + '">' +
							'<button type="button" class="pccc-qty-inc" aria-label="Tăng">+</button>' +
						'</div>' +
					'</td>' +
					'<td class="pccc-ci-rm"><button type="button" class="pccc-ci-remove" aria-label="Xóa">✕</button></td>' +
				'</tr>';
		} ).join( '' );

		root.innerHTML = '' +
			'<div class="pccc-cart-grid">' +
				'<div class="pccc-cart-list">' +
					'<table class="pccc-cart-table">' +
						'<thead><tr><th>Sản phẩm</th><th>Số lượng</th><th></th></tr></thead>' +
						'<tbody>' + rows + '</tbody>' +
					'</table>' +
					'<div class="pccc-cart-actions">' +
						'<a class="pccc-link" href="/san-pham/">← Tiếp tục chọn sản phẩm</a>' +
						'<button type="button" class="pccc-link pccc-link-danger" id="pccc-clear">Xóa toàn bộ giỏ</button>' +
					'</div>' +
				'</div>' +
				'<aside class="pccc-cart-side">' +
					'<h3>Thông tin liên hệ</h3>' +
					'<label>Họ tên<input type="text" id="pccc-name" placeholder="Nguyễn Văn A"></label>' +
					'<label>Số điện thoại<input type="tel" id="pccc-phone" placeholder="09xx xxx xxx"></label>' +
					'<label>Ghi chú<textarea id="pccc-note" rows="3" placeholder="Địa điểm công trình, yêu cầu thêm…"></textarea></label>' +
					'<label>Nội dung đơn (xem trước)<textarea id="pccc-preview" rows="7" readonly></textarea></label>' +
					'<button type="button" class="pccc-btn pccc-btn-zalo" id="pccc-send-zalo">' +
						zaloIcon() + ' Gửi đơn hàng qua Zalo' +
					'</button>' +
					'<button type="button" class="pccc-btn pccc-btn-ghost" id="pccc-copy">Sao chép nội dung đơn</button>' +
					'<a class="pccc-btn pccc-btn-ghost" href="tel:' + PHONE + '">📞 Gọi ngay ' + PHONE + '</a>' +
					'<p class="pccc-cart-hint">Bấm <b>Gửi qua Zalo</b>: nội dung đơn sẽ được sao chép tự động — bạn chỉ cần <b>dán (Ctrl/Cmd+V)</b> vào khung chat Zalo rồi gửi.</p>' +
				'</aside>' +
			'</div>';

		refreshPreview();
	}

	function refreshPreview() {
		var p = document.getElementById( 'pccc-preview' );
		if ( p ) { p.value = buildOrderText( gatherInfo() ); }
	}
	function gatherInfo() {
		return {
			name: val( 'pccc-name' ),
			phone: val( 'pccc-phone' ),
			note: val( 'pccc-note' )
		};
	}
	function val( id ) { var el = document.getElementById( id ); return el ? el.value.trim() : ''; }

	function copyText( text ) {
		if ( navigator.clipboard && navigator.clipboard.writeText ) {
			return navigator.clipboard.writeText( text );
		}
		return new Promise( function ( resolve, reject ) {
			try {
				var ta = document.createElement( 'textarea' );
				ta.value = text; ta.style.position = 'fixed'; ta.style.opacity = '0';
				document.body.appendChild( ta ); ta.select();
				document.execCommand( 'copy' );
				document.body.removeChild( ta );
				resolve();
			} catch ( e ) { reject( e ); }
		} );
	}

	function bindCartPage() {
		var root = document.getElementById( 'pccc-cart-root' );
		if ( ! root ) { return; }

		root.addEventListener( 'click', function ( e ) {
			var tr = e.target.closest( 'tr[data-id]' );
			var id = tr ? tr.getAttribute( 'data-id' ) : null;
			if ( e.target.closest( '.pccc-qty-inc' ) ) {
				var inc = tr.querySelector( '.pccc-qty-inp' );
				inc.value = ( parseInt( inc.value, 10 ) || 1 ) + 1; setQty( id, inc.value );
			} else if ( e.target.closest( '.pccc-qty-dec' ) ) {
				var dec = tr.querySelector( '.pccc-qty-inp' );
				dec.value = Math.max( 1, ( parseInt( dec.value, 10 ) || 1 ) - 1 ); setQty( id, dec.value );
			} else if ( e.target.closest( '.pccc-ci-remove' ) ) {
				remove( id );
			} else if ( e.target.id === 'pccc-clear' ) {
				if ( confirm( 'Xóa toàn bộ sản phẩm trong giỏ?' ) ) { clear(); }
			}
		} );

		root.addEventListener( 'input', function ( e ) {
			if ( e.target.classList.contains( 'pccc-qty-inp' ) ) {
				var tr = e.target.closest( 'tr[data-id]' );
				setQty( tr.getAttribute( 'data-id' ), e.target.value );
			}
			if ( [ 'pccc-name', 'pccc-phone', 'pccc-note' ].indexOf( e.target.id ) > -1 ) {
				refreshPreview();
			}
		} );

		root.addEventListener( 'click', function ( e ) {
			if ( e.target.closest( '#pccc-copy' ) ) {
				copyText( buildOrderText( gatherInfo() ) ).then( function () {
					toast( '✓ Đã sao chép nội dung đơn hàng.' );
				} );
			}
			if ( e.target.closest( '#pccc-send-zalo' ) ) {
				if ( ! read().length ) { toast( 'Giỏ hàng đang trống.' ); return; }
				var text = buildOrderText( gatherInfo() );
				copyText( text ).then( function () {
					toast( '✓ Đã sao chép đơn hàng. Dán (Ctrl/Cmd+V) vào Zalo & gửi nhé!' );
				} ).catch( function () {} );
				window.open( ZALO, '_blank', 'noopener' );
			}
		} );

		// Cập nhật lại bảng khi giỏ đổi (thêm/xóa/số lượng từ nút).
		document.addEventListener( 'pccc:cart-changed', function () {
			var info = gatherInfo();
			renderCart();
			// khôi phục thông tin đã nhập
			setVal( 'pccc-name', info.name ); setVal( 'pccc-phone', info.phone ); setVal( 'pccc-note', info.note );
			refreshPreview();
		} );
	}
	function setVal( id, v ) { var el = document.getElementById( id ); if ( el ) { el.value = v; } }

	/* ---------- Helpers ---------- */
	function escapeHtml( s ) {
		return ( s || '' ).replace( /[&<>"']/g, function ( c ) {
			return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[ c ];
		} );
	}
	function zaloIcon() {
		return '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C6.48 2 2 5.94 2 10.8c0 2.7 1.4 5.1 3.6 6.7-.16 1.16-.6 2.2-1.3 3.06-.2.24-.02.6.3.54 1.7-.34 3.1-.96 4.1-1.66.97.26 2 .4 3.06.4 5.52 0 10-3.94 10-8.8S17.52 2 12 2z"/></svg>';
	}

	/* ---------- Init ---------- */
	function init() {
		bindAddButtons();
		bindCartPage();
		renderCart();
		paintBadge();
	}
	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else { init(); }

	// expose tối thiểu (debug)
	window.PCCCCart = { read: read, clear: clear, count: count };
} )();
