(function($){

	/**
	 * Виджет выбора координат на яндекс карте
	 * @param options
	 * @returns {*}
	 */

	$.fn.yamapInput = function(options){

		return this.each(function() {

			var wrap = $(this);

			var dialog = wrap.find('.yamap-dialog');

			var yamap = dialog.find('.yamap-area');

			var search = wrap.find('.yamap-search');

			var input = wrap.find('input[type="text"]:first');

			var coords = input.val();

			dialog.dialog(options.dialog);

			input.on('click', function () {

				dialog.dialog('open');

			});

			var getDefaultPointCoords = function() {

				var val = input.val();

				if(val)
					coords = val.split(',');
				else
					coords = options.map.center;

				return coords;

			}

			ymaps.ready(function () {

				var start = getDefaultPointCoords();

				var map = new ymaps.Map(options.mapId, {
					center: start,
					zoom: options.map.zoom
				});

				var placemark = new ymaps.Placemark(start);

				map.geoObjects.add(placemark);


				map.events.add('click', function (e) {

						var coords = e.get('coords');

						placemark.geometry.setCoordinates(coords);

						input.val(coords.join(','));

				});


				search.on('keyup', function(e){

					if(e.keyCode == 13) {

						ymaps.geocode(search.val(), {
							results: 1
						}).then(function (res) {

							var firstGeoObject = res.geoObjects.get(0);

							var coords = firstGeoObject.geometry.getCoordinates();

							placemark.geometry.setCoordinates(coords);

							input.val(coords.join(','));

							map.panTo(coords);

						});

					}

				});

			});

		});
	}

})(jQuery);