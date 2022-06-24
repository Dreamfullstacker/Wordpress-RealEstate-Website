(function ($) {
    "use strict";

    $(document).ready(function () {

        // Get Canvas tag to use it for Property Views Graph
        const graphDiv = document.getElementById('property-views-graph');

        // Check if Canvas tag and Ajax request data is available before making a request.
        if (graphDiv && typeof property_analytics !== 'undefined' ) {

            $.ajax({
                type: "post",
                dataType: "json",
                url: property_analytics.ajax_url,
                data: {
                    action: 'inspiry_property_views',
                    property_id: property_analytics.property_id,
                    nonce: property_analytics.ajax_nonce
                },
                success: function (response) {

                    try{
                        var ctx = graphDiv.getContext('2d');
                        var chart = new Chart(ctx, {
                            type: property_analytics.chart_type,
                            data: {
                                labels: response.dates,
                                datasets: [
                                    {
                                        label: property_analytics.data_label,
                                        borderColor: property_analytics.border_color,
                                        data: response.views
                                    }]
							},
							options: {
								scales: {
									yAxes: [{
										ticks: {
											stepSize: 1,
											beginAtZero: true
										}
									}]
								}
							}
                        });
                    } catch(error) {
                        throw 'Property Analytics chart couldn\'t be drawn. ' + error;
                    }

                },
                error: function () {
                    console.log('Couldn\'t retrieve property views.');
                }
            });
        }
    });
})(jQuery);