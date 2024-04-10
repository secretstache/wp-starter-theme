document.addEventListener('DOMContentLoaded', function () {
	let acf = window.acf;

	if (typeof acf == 'undefined') {
		return;
	}

	// template spacing
	acf.addAction('ready_field/name=background_color', function (field) {
		toggleSectionPaddings(field.$el[0]);
	});

	acf.addAction('new_field/name=background_color', function (field) {
		toggleSectionPaddings(field.$el[0]);
	});

	const PADDINGS_FIELDS_SELECTOR = '.acf-field[data-name="option_top_padding"] [type="range"], .acf-field[data-name="option_top_padding"] [type="number"], .acf-field[data-name="option_bottom_padding"] [type="range"], .acf-field[data-name="option_bottom_padding"] [type="number"]';
	const FIELDS_CLASS = '.acf-fields';

	function toggleSectionPaddings(bg_field) {
		const inputs = bg_field.querySelectorAll('input[type="radio"]');

		inputs.forEach(function (input) {
			input.addEventListener('change', function () {
				let color = this.value;
				const paddingsFields = bg_field.closest(FIELDS_CLASS).querySelectorAll(PADDINGS_FIELDS_SELECTOR);

				if (color === 'white') {
					paddingsFields.forEach(function (field) {
						field.value = 0;
					});
				} else {
					paddingsFields.forEach(function (field) {
						field.value = 2;
					});
				}
			});
		});
	}

	// columns mobile order
	(function ($) {
		acf.add_action('append_field/type=flexible_content', function ($el) {
			changeOptions($el, 'append');
		});

		acf.add_action('remove_field/type=flexible_content', function ($el) {
			changeOptions($el, 'remove');
		});

		acf.add_action('load', function ($el) {
			populate($el);
		});

		function populate(el) {
			const column_rows = getColumnRowsCount();

			if ($('#columns_count').length === 0) {
				$('<input>')
					.attr({
						type: 'hidden',
						id: 'columns_count',
						name: 'columns_count',
						value: column_rows,
					})
					.appendTo($('#post'));
			}

			populateColumnsLayoutMobileOrder(el);
		}

		/* Populate options for columns order configuration */
		function populateColumnsLayoutMobileOrder(el) {
			let column_rows = [];

			if (typeof el !== 'undefined') {
				column_rows = el.find('div[data-name="columns"]');
			} else {
				column_rows = $('div[data-name="columns"]').slice(1);
			}

			let node_length = 0;

			$.each(column_rows, function () {
				node_length = $(this).find('> .acf-input > .acf-repeater > .acf-table > tbody > tr:not(.acf-clone)').length;

				const mobile_order_option = $(this).parents('div.acf-fields').children('div[data-name="option_columns_mobile_order"]');

				const order_input = mobile_order_option.find('input[name*="option_columns_mobile_order"]');
				let order_input_value = order_input.val();
				let order = order_input_value ? order_input_value.split('_') : [];

				// prevent situation when columns exist but order input is empty
				// prevent situation when the order input value is not valid, e.g. there are 2 columns but the order input value is [1, 2, 3, 2, 2, ...]
				if ((!order.length && node_length) || order.length > node_length) {
					order = [];

					for (let i = 1; i <= node_length; i++) {
						order.push(i);
					}

					order_input_value = order.join('_');
					order_input.val(order_input_value);
				}

				const ul = $('<ul class="acf-radio-list acf-hl"></ul>');

				order.forEach((item) => {
					ul.append("<li id='sort_" + item + "'>" + item + '</li>');
				});

				mobile_order_option.append(ul);

				/* Init sortable functionality */
				ul.sortable({
					placeholder: 'sortable-placeholder',
					update: function () {
						const order = $(this)
							.sortable('toArray')
							.map((item) => {
								return item.split('_')[1];
							});

						order_input.val(order.join('_'));
					},
				});

				if (node_length > 1) {
					mobile_order_option.show();
				} else {
					mobile_order_option.hide();
				}
			});
		}

		function changeOptions(el, action) {
			$('input#columns_count').val(getColumnRowsCount());

			columnLayoutMobileOrderOptionsChange(el, action);
		}

		function columnLayoutMobileOrderOptionsChange(el, action) {
			let node_length = el.closest('[data-name="columns"]').find('> .acf-input > .acf-repeater > .acf-table > tbody > tr:not(.acf-clone)').length;

			const mobile_order_option = el.closest('div.acf-fields').find('div[data-name="option_columns_mobile_order"]');

			const order_input = mobile_order_option.find('input[name*="option_columns_mobile_order"]');
			const order_input_value = order_input.val();

			let order = order_input_value ? order_input_value.split('_') : [];

			let ul = mobile_order_option.find('ul.acf-radio-list');

			if (ul.length) {
				if (!ul.hasClass('ui-sortable')) {
					ul.sortable({
						placeholder: 'sortable-placeholder',
						update: function () {
							const order = $(this)
								.sortable('toArray')
								.map((item) => {
									return item.split('_')[1];
								});

							order_input.val(order.join('_'));
						},
					});
				}

				if (action === 'remove') {
					ul.empty();

					const new_order = order.filter((item) => {
						return item < node_length;
					});

					if (new_order.length) {
						const li = [];

						new_order.forEach((order) => {
							li.push($('<li id="sort_' + order + '">' + order + '</li>'));
						});

						ul.append(li);

						order_input.val(new_order.join('_'));
					} else {
						order_input.val('');
					}

					node_length -= 1;
				} else {
					// if already up to date when return
					if (order.includes(node_length.toString())) {
						return;
					}

					order.push(node_length);
					order_input.val(order.join('_'));

					const li = '<li id="sort_' + node_length + '">' + node_length + '</li>';
					ul.append(li);
				}

				if (node_length > 1) {
					mobile_order_option.show();
				} else {
					mobile_order_option.hide();
				}
			} else {
				populateColumnsLayoutMobileOrder(mobile_order_option.closest('.acf-fields'));
			}
		}

		function getColumnRowsCount() {
			return $('div[data-name="columns"]').slice(1).length;
		}
	})(window.jQuery);
});