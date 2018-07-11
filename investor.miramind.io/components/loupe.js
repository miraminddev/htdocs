define(['Vue', 'jQuery'], function(Vue) {
	Vue.directive('loupe', {
		bind: function(el) {
			var el = $(el);

			el.on('mouseenter', function(e) {
				if(!el.data('loupe')) {
					var src = el.attr('src');

					var img = new Image();
					img.src = src.replace(/"/g, '').replace(/url\(|\)$/ig, '');

					el.data('width', img.width);
					el.data('height', img.height);
					el.data('loupe', $('<div/>').css({
						position: 'absolute',
						left: 0,
						top: 0,
						zIndex: 1000,
						width: el.width(),
						height: el.height(),
						background: '#777 url(' + src + ') no-repeat'
					}).appendTo('body'));
				}
			})
			.on('mousemove', function(e) {
				if(el.data('loupe')) {
					var lp = el.data('loupe');
					lp.css({
						left: el.offset().left - el.width() - 10,
						top: el.offset().top,
						backgroundPositionX: -(e.offsetX / el.width() * el.data('width') - lp.width() / 2),
						backgroundPositionY: -(e.offsetY / el.height() * el.data('height') - lp.height() / 2) 
					});
				}
			})
			.on('mouseout', function(e) {
				if(el.data('loupe')) {
					el.data('loupe').remove();
					el.data('loupe', null);
				}
			});
		},
		unbind: function(el) {
			$(el).off('mouseenter').off('mousemove').trigger('mouseout').off('mouseout');
		}
	});
});