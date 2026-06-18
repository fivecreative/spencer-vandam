(function ($) {
	'use strict';

	var cfg = window.acfIconTaxonomy;

	/**
	 * Reload the icon_terms select with terms from the given taxonomy.
	 *
	 * $taxField  — .acf-field wrapper of the icon_taxonomy select
	 * taxonomy   — taxonomy slug
	 * keepValues — re-select any term IDs that were selected before the reload
	 */
	function loadTerms($taxField, taxonomy, keepValues, termsKeys) {
		// Flexible content layout rows have class "layout" (not "acf-layout").
		// Repeater rows use "acf-row". Fall back to ".acf-fields" if neither matches.
		var $row = $taxField.closest('.acf-row, .layout');
		if (!$row.length) $row = $taxField.closest('.acf-fields');

		if(!Array.isArray(termsKeys)) {
			termsKeys = [termsKeys];
		}

		$.each(termsKeys, function(i, termsKey) {

			var $termsField = $row.find('.acf-field[data-key="' + termsKey + '"]');
			if (!$termsField.length || !taxonomy) return;

			var $select = $termsField.find('select');
			if (!$select.length) return;

			// Read current selection BEFORE destroying Select2 — the underlying
			// <select> element always reflects the real value even when Select2 is active.
			var saved = keepValues ? [].concat($select.val() || []) : [];

			// Tear down the existing Select2 instance via ACF's field object so its
			// internal reference is cleared cleanly alongside the DOM cleanup.
			var acfField = acf.getField($termsField);
			if (acfField && acfField.select2) {
				acfField.select2.destroy();
				acfField.select2 = false;
			} else if ($select.hasClass('select2-hidden-accessible')) {
				$select.select2('destroy');
			}
			$termsField.find('.select2-container').remove();
			$select.removeClass('select2-hidden-accessible').prop('disabled', true).empty();

			$.post(cfg.ajaxurl, {
				action:   'acf_icon_terms_choices',
				taxonomy: taxonomy,
				nonce:    cfg.nonce,
			}, function (res) {
				if (res.success && res.data) {
					$.each(res.data, function (i, option) {
						$select.append(
							$('<option>', {
								value:    option.value,
								text:     option.label,
								selected: saved.indexOf(String(option.value)) !== -1,
							})
						);
					});
				}
			}).always(function () {
				$select.prop('disabled', false);

				// Reinitialise Select2 using ACF's own factory with the field's stored
				// settings — mirrors exactly what ACF does in the select field's initialize().
				if (acfField) {
					acfField.select2 = acf.newSelect2($select, {
						field:       acfField,
						ajax:        acfField.get('ajax')           || false,
						multiple:    !!acfField.get('multiple'),
						allowNull:   !!acfField.get('allow_null'),
						placeholder: acfField.get('placeholder')   || '',
						tags:        acfField.get('create_options') || false,
					});
				}
			});

		})
	}

	$.each(cfg.taxKeys, function(i, taxKey) {

		var termsKey = cfg.termsKeys[i];

		// Taxonomy changed: reload terms for the new taxonomy, clear old selection.
		$(document).on(
			'change',
			'.acf-field[data-key="' + taxKey + '"] select',
			function () {
				loadTerms($(this).closest('.acf-field'), $(this).val(), false, termsKey);
			}
		);

		// On page load / new row appended: populate terms for any row that already has
		// a taxonomy selected, preserving any previously saved term selections.
		function syncScope($scope) {
			if (!$scope || typeof $scope.find !== 'function') return;
			$scope.find('.acf-field[data-key="' + taxKey + '"] select').each(function () {
				var taxonomy = $(this).val();
				if (taxonomy) {
					loadTerms($(this).closest('.acf-field'), taxonomy, true, termsKey);
				}
			});
		}

		$(document).ready(function () { syncScope($(document)); });
		acf.addAction('ready',  function ($el) { syncScope($el || $(document)); });
		acf.addAction('append', function ($el) { syncScope($el || $(document)); });

	});

}(jQuery));
