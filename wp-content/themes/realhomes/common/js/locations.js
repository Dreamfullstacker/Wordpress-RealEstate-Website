(function ($) {
	"use strict";

	/* ----------- START OF LOCATIONS SELECT BOXES CODE ----------- */
	if (typeof realhomesLocationsData !== 'undefined') {

		const hierarchicalLocations = realhomesLocationsData.all_locations;    /* All locations */

		const selectBoxesIDs = realhomesLocationsData.select_names;               /* Select boxes names that can be used as ids */
		const selectBoxesCount = parseInt(realhomesLocationsData.select_count);   /* Number of select boxes to manage */
		const multiSelect = realhomesLocationsData.multi_select_locations;        /* Location boxes are multiselect or not */

		const anyText = realhomesLocationsData.any_text;      /* "Any" text as it could be translated */
		const anyValue = realhomesLocationsData.any_value;    /* "any" value */

		const slugsInQueryParams = realhomesLocationsData.locations_in_params;    /* parameters related to location boxes */

		const consoleLogEnabled = false; /* A flag to enable disable console logging while development OR troubleshooting */

		/* logging while development OR troubleshooting */
		if (consoleLogEnabled) {
			console.log('realhomesLocationsData.locations_in_params: ');
			console.log(slugsInQueryParams);
		}

		/**
		 * Initialize Locations Select Boxes
		 *
		 * Following function automatically runs to initialize locations boxes
		 */
		(function () {
			/* prepare select boxes */
			prepareSelectBoxes();

			let parentLocations = [];
			for (let selectIndex = 0; selectIndex < selectBoxesCount; selectIndex++) {
				const currentSelect = $('#' + selectBoxesIDs[selectIndex]); /* loop's current select box */
				const currentIsLast = (selectBoxesCount === (selectIndex + 1)); /* check if current select box is last */

				if (selectIndex === 0) { /* First iteration */
					parentLocations = addParentLocations(currentSelect, currentIsLast);
				} else { /* later iterations */
					/* If parents locations array is not empty then there could be children to add in current select box */
					if (parentLocations.length > 0) {
						let currentLocations = [];
						const previousSelect = $('#' + selectBoxesIDs[selectIndex - 1]);

						/* loop through all if value is "any" */
						if (previousSelect.val() === anyValue) {
							for (let i = 0; i < parentLocations.length; i++) {
								let tempLocations = addChildrenLocations(currentSelect, parentLocations[i].children, '', currentIsLast);
								if (tempLocations.length > 0) {
									currentLocations = $.merge(currentLocations, tempLocations);
								}
							}
						} else {
							/* Otherwise add only children of previous selected location, It there are any. */
							let previousLocation = searchLocation(previousSelect.val(), hierarchicalLocations);
							if (previousLocation && previousLocation.children.length > 0) {
								currentLocations = addChildrenLocations(currentSelect, previousLocation.children, '', currentIsLast);
							}
						}

						/* hook up updateChildSelect function with previous select change event */
						previousSelect.change(updateChildSelect);
						/* currentLocations variable is passed to parentLocations for code below and for next iteration */
						parentLocations = currentLocations;
					}
				}

				/* If parentLocations is empty */
				if (parentLocations.length === 0) {
					/* disable current select and children selects if any */
					disableSelect(currentSelect);
					/* No need for further iterations */
					break;
				} else {
					/* Select the right option within current select based on query parameters */
					selectParamOption(currentSelect);
				}
			}   /* end of loop */
		})(); /* Run the function immediately after declaration */

		/**
		 * Adds top level locations to given select box, If addAllChildren is true then it adds all children locations as well
		 * @param targetSelect
		 * @param addAllChildren
		 * @returns {*[]}
		 */
		function addParentLocations(targetSelect, addAllChildren) {
			let addedLocations = [];
			let insertionCounter = 0;

			/* loop through top level locations */
			hierarchicalLocations.forEach(function (currentLocation, index, locationsArray) {
				targetSelect.append('<option value="' + currentLocation.slug + '">' + currentLocation.name + '</option>');
				addedLocations[insertionCounter++] = currentLocation;
				/* logging while development OR troubleshooting */
				if (consoleLogEnabled) {
					console.log('addParentLocations: ' + currentLocation.slug + ' in ' + targetSelect.attr('id'));
				}
				if (addAllChildren && currentLocation.children.length) {
					addChildrenLocations(targetSelect, currentLocation.children, '- ', addAllChildren);
				}
			});

			return addedLocations;
		}

		/**
		 * Adds top level locations form given childrenLocations array to targetSelect box, If addAllChildren is true then it adds all children locations as well
		 * @param targetSelect
		 * @param childrenLocations
		 * @param prefix
		 * @param addAllChildren
		 * @returns {*[]}
		 */
		function addChildrenLocations(targetSelect, childrenLocations, prefix, addAllChildren) {
			let addedChildrenLocations = [];
			let insertionCounter = 0;

			/* loop through all children locations */
			childrenLocations.forEach(function (currentLocation, index, locationsArray) {
				targetSelect.append('<option value="' + currentLocation.slug + '">' + prefix + currentLocation.name + '</option>');
				addedChildrenLocations[insertionCounter++] = currentLocation;
				/* logging while development OR troubleshooting */
				if (consoleLogEnabled) {
					console.log(prefix + 'addChildrenLocations: ' + currentLocation.slug + ' in ' + targetSelect.attr('id'));
				}
				/* If a current location has children then add those as well */
				if (addAllChildren && currentLocation.children.length) {
					let tempLocations = addChildrenLocations(targetSelect, currentLocation.children, prefix + '- ', addAllChildren);
					if (tempLocations.length > 0) {
						/* merge newly added children locations with existing children locations array */
						addedChildrenLocations = $.merge(addedChildrenLocations, tempLocations);
					}
				}
			});

			return addedChildrenLocations;
		}

		/**
		 * Search a location from given locations array for given slug
		 * @param slug
		 * @param locations
		 * @returns {boolean}   location OR false if no location is found
		 */
		function searchLocation(slug, locations) {
			let targetLocation = false;

			for (let index = 0; index < locations.length; index++) {
				let currentLocation = locations[index];
				if (currentLocation.slug === slug) {
					/* logging while development OR troubleshooting */
					if (consoleLogEnabled) {
						console.log('searchLocation: Found');
						console.log(currentLocation);
					}
					targetLocation = currentLocation;
					break;
				}
				if (currentLocation.children.length > 0) {
					targetLocation = searchLocation(slug, currentLocation.children);
					if (targetLocation) {
						break;
					}
				}
			}

			return targetLocation;
		}

		/**
		 * Update child select box based on change in selected value of parent select box
		 * @param event
		 */
		function updateChildSelect(event) {
			let selectedSlug = $(this).val();
			let currentSelectIndex = selectBoxesIDs.indexOf($(this).attr('id'));

			/* logging while development OR troubleshooting */
			if (consoleLogEnabled) {
				console.log('updateChildSelect: ' + $(this).attr('id') + ' select box is changed to ' + selectedSlug + ' slug ');
			}

			/*  When "any" is selected, Also no need to run this on last select box */
			if (selectedSlug === anyValue && (currentSelectIndex > -1) && (currentSelectIndex < (selectBoxesCount - 1))) {
				for (let s = currentSelectIndex; s < (selectBoxesCount - 1); s++) {
					/* check if child select is Last */
					let childSelectIsLast = (selectBoxesCount === (s + 2));

					/* find child select box, empty it and add any options to it */
					let childSelect = $('#' + selectBoxesIDs[s + 1]);
					childSelect.empty();
					addAnyOption(childSelect);

					/* loop through select options to find and add children locations into next select */
					let anyChildLocations = [];
					$('#' + selectBoxesIDs[s] + ' > option').each(function () {
						if (this.value !== anyValue) {
							let relatedLocation = searchLocation(this.value, hierarchicalLocations);
							if (relatedLocation && relatedLocation.children.length > 0 ) {
								let tempChildrenLocations = addChildrenLocations(childSelect, relatedLocation.children, '', childSelectIsLast);
								if (tempChildrenLocations.length > 0) {
									anyChildLocations = $.merge(anyChildLocations, tempChildrenLocations);
								}
							}
						}
					});

					/* enable next select if options are added otherwise disable it */
					if (anyChildLocations.length > 0) {
						enableSelect(childSelect);
					} else {
						disableSelect(childSelect);
						break;
					}

				}   /* end of for loop */

			} else {
				/* In case of valid location selection */
				let selectedParentLocation = searchLocation(selectedSlug, hierarchicalLocations);
				if (selectedParentLocation) {
					let childLocations = [];
					for (let childSelectIndex = currentSelectIndex + 1; childSelectIndex < selectBoxesCount; childSelectIndex++) {
						/* check if child select is Last */
						let childSelectIsLast = (selectBoxesCount === (childSelectIndex + 1));

						/* find and empty child select box */
						let childSelect = $('#' + selectBoxesIDs[childSelectIndex]);
						childSelect.empty();

						/* First iteration */
						if (childLocations.length === 0 ) {
							if (selectedParentLocation.children.length > 0) {
								addAnyOption(childSelect);
								let tempLocations = addChildrenLocations(childSelect, selectedParentLocation.children, '', childSelectIsLast);
								if (tempLocations.length > 0) {
									childLocations = tempLocations;
								}
							}
						} else if (childLocations.length > 0) { /* 2nd and later iterations */
							let currentLocations = [];
							for (let i = 0; i < childLocations.length; i++) {
								let tempChildLocation = childLocations[i];
								if (tempChildLocation.children.length > 0) {
									addAnyOption(childSelect);
									let tempLocations = addChildrenLocations(childSelect, tempChildLocation.children, '', childSelectIsLast);
									if (tempLocations.length > 0) {
										currentLocations = $.merge(currentLocations, tempLocations);
									}
								}
							}
							/* If there are current locations OR none, assign current locations array to child locations*/
							childLocations = currentLocations;
						}

						if (childLocations.length > 0) {
							enableSelect(childSelect);
						} else {
							disableSelect(childSelect);
							break;
						}

					} /* end of for loop */
				} else {
					/* logging while development OR troubleshooting */
					if (consoleLogEnabled) {
						console.log('updateChildSelect: Not Found ' + selectedSlug + ' slug in hierarchicalLocations!');
						console.log(hierarchicalLocations);
					}
				}
			}
		}

		/**
		 * Adds Any value and select index based place holder text to given select box.
		 * @param targetSelect
		 */
		function addAnyOption(targetSelect) {
			if (targetSelect.has('option').length > 0){
				return;
			}

			let targetSelectIndex = selectBoxesIDs.indexOf(targetSelect.attr('id'));    /* current select box index */

			/* For location fields in search form */
			if (targetSelect.parents('.rh_prop_search__select').hasClass('rh_location_prop_search_' + targetSelectIndex)) {
				let targetSelectPlaceholder = targetSelect.parents('.rh_prop_search__select').data('get-location-placeholder');
				targetSelect.append('<option value="' + anyValue + '" selected="selected">' + targetSelectPlaceholder + '</option>');
				/* logging while development OR troubleshooting */
				if (consoleLogEnabled) {
					console.log('addAnyOption: to select box: ' + targetSelect.attr('id'));
				}

				/* For location fields in dashboard property form */
			} else if (targetSelect.parents('.rh_prop_loc__select').hasClass('rh_location_prop_loc_' + targetSelectIndex)) {
				targetSelect.append('<option value="' + anyValue + '" selected="selected">' + anyText + '</option>');
				/* logging while development OR troubleshooting */
				if (consoleLogEnabled) {
					console.log('addAnyOption: to select box: ' + targetSelect.attr('id'));
				}
			}
		}

		/**
		 * Disable a select box and next select boxes if exists
		 * @param targetSelect
		 */
		function disableSelect(targetSelect) {
			let targetSelectID = targetSelect.attr('id');

			/* logging while development OR troubleshooting */
			if (consoleLogEnabled) {
				console.log('disableSelect: ' + targetSelectID);
			}
			targetSelect.empty();

			targetSelect.closest('.option-bar').addClass('disabled');
			if (targetSelect.is(':enabled')) {
				targetSelect.prop('disabled', true);
				targetSelect.parents('.rh_prop_search__select').addClass('rh_disable_parent');
			}

			let targetSelectIndex = selectBoxesIDs.indexOf(targetSelectID);      // target select box index
			let nextSelectBoxesCount = selectBoxesCount - (targetSelectIndex + 1);

			/* Disable next select box as well */
			if (nextSelectBoxesCount > 0) {
				let nextSelect = $('#' + selectBoxesIDs[targetSelectIndex + 1]);
				disableSelect(nextSelect);
			}
		}

		/**
		 * Enable a select box
		 * @param targetSelect
		 */
		function enableSelect(targetSelect) {
			let targetSelectID = targetSelect.attr('id');

			/* logging while development OR troubleshooting */
			if (consoleLogEnabled) {
				console.log('enableSelect: ' + targetSelectID);
			}

			if (targetSelect.is(':disabled')) {
				targetSelect.prop('disabled', false);
			}

			// remove class from parents
			targetSelect.parents('.rh_prop_search__select').map(function (){
				if( $(this).hasClass('rh_disable_parent')){
					$(this).removeClass('rh_disable_parent');
				}
			});

			/* Remove .option-bar's disabled class */
			let optionWrapper = targetSelect.closest('.option-bar');
			if (optionWrapper.hasClass('disabled')) {
				optionWrapper.removeClass('disabled');
				// todo: remove the following line after testing
				//optionWrapper.parents('.rh_prop_search__select').removeClass('rh_disable_parent');
			}

			// for classic property submit/edit form's locations fields
			// targetSelect.siblings('.btn').removeClass('disabled');

			/* Remove .bootstrap-select disabled class - especially for classic */
			// let bootstrapSelect = targetSelect.closest('.bootstrap-select');
			// if (bootstrapSelect.hasClass('disabled')) {
			// 	bootstrapSelect.removeClass('disabled');
			// }

		}

		/**
		 * Mark the current value in query params as selected in related select box
		 * @param currentSelect
		 */
		function selectParamOption(currentSelect) {
			if (Object.keys(slugsInQueryParams).length > 0) {
				let selectName = currentSelect.attr('name');
				selectName = selectName.replace(/[\[\]]+/g,''); /* remove box brackets as for multi select location brackets comes with name */
				if (typeof slugsInQueryParams[selectName] !== 'undefined') {
					let tempValue = slugsInQueryParams[selectName];
					if (Array.isArray(tempValue)){
						for (let i = 0; i < tempValue.length; i++) {
							currentSelect.find('option[value="' + tempValue[i] + '"]').prop('selected', true);
						}
					} else {
						currentSelect.find('option[value="' + tempValue + '"]').prop('selected', true);
					}
				}
			}
		}

		/**
		 * Append options with Any value or None value depending on conditions
		 */
		function prepareSelectBoxes(){
			/* Loop through select boxes and prepare them with basic option */
			for (let selectIndex = 0; selectIndex < selectBoxesCount; selectIndex++) {
				let currentSelectId = selectBoxesIDs[selectIndex];
				let currentSelect = $('#' + currentSelectId);

				/* For location fields in search form */
				if ((multiSelect === 'no') &&
					(currentSelect.has('option').length === 0) &&
					(currentSelect.parents('.rh_prop_search__select').hasClass('rh_location_prop_search_' + selectIndex))) {
					if(consoleLogEnabled){
						console.log('prepareSelectBoxes 1st if: ' + currentSelectId);
					}
					addAnyOption(currentSelect);
				}

				/* For location fields in dashboard property form */
				if ((currentSelect.has('option').length === 0) &&
					(currentSelect.parents('.rh_prop_loc__select').hasClass('rh_location_prop_loc_' + selectIndex))) {
					if(consoleLogEnabled){
						console.log('prepareSelectBoxes 2nd if: ' + currentSelectId);
					}
					addAnyOption(currentSelect);
				}
			}
		}

	}
	/* ----------- END OF LOCATIONS SELECT BOXES CODE ----------- */

})(jQuery);