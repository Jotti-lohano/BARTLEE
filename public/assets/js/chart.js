	$( window ).on( "load", function () {

		// Set paths
		// ------------------------------

		require.config( {
			paths: {
				echarts: 'app-assets/vendors/js/charts/echarts'
			}
		} );


		// Configuration
		// ------------------------------

		require(
			[
				'echarts',
				'echarts/chart/bar',
				'echarts/chart/line'
			],


			// Charts setup
			function ( ec ) {

				// Initialize chart
				// ------------------------------
				var myChart = ec.init( document.getElementById( 'column-chart' ) );

				// Chart Options
				// ------------------------------
				chartOptions = {

					// Setup grid
					grid: {
						x: 40,
						x2: 40,
						y: 35,
						y2: 25
					},

					// Add tooltip
					tooltip: {
						trigger: 'axis'
					},

					// Add legend
					legend: {
						data: [ 'Sessions', 'Products' ]
					},

					// Add custom colors
					color: [ '#333333', '#032443' ],

					// Enable drag recalculate
					calculable: true,

					// Horizontal axis
					xAxis: [ {
						type: 'category',
						data: [ 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' ]
					} ],

					// Vertical axis
					yAxis: [ {
						type: 'value'
					} ],

					// Add series
					series: [ {
						name: 'Sessions',
						type: 'bar',
						data: [ 2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3 ],
						itemStyle: {
							normal: {
								label: {
									show: false,
									textStyle: {
										fontWeight: 500
									}
								}
							}
						},

					}, {
						name: 'Products',
						type: 'bar',
						data: [ 2.6, 5.9, 9.0, 26.4, 58.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3 ],
						itemStyle: {
							normal: {
								label: {
									show: false,
									textStyle: {
										fontWeight: 500
									}
								}
							}
						},

					} ]
				};

				// Apply options
				// ------------------------------

				myChart.setOption( chartOptions );


				// Resize chart
				// ------------------------------

				$( function () {

					// Resize chart on menu width change and window resize
					$( window ).on( 'resize', resize );
					$( ".menu-toggle" ).on( 'click', resize );

					// Resize function
					function resize() {
						setTimeout( function () {

							// Resize chart
							myChart.resize();
						}, 200 );
					}
				} );
			}
		);
	} );
	
	
	
	


	$( window ).on( "load", function () {

		// Set paths
		// ------------------------------

		require.config( {
			paths: {
				echarts: 'app-assets/vendors/js/charts/echarts'
			}
		} );


		// Configuration
		// ------------------------------

		require(
			[
				'echarts',
				'echarts/chart/bar',
				'echarts/chart/line'
			],


			// Charts setup
			function ( ec ) {

				// Initialize chart
				// ------------------------------
				var myChart = ec.init( document.getElementById( 'column-chart-2' ) );

				// Chart Options
				// ------------------------------
				chartOptions = {

					// Setup grid
					grid: {
						x: 40,
						x2: 40,
						y: 35,
						y2: 25
					},

					// Add tooltip
					tooltip: {
						trigger: 'axis'
					},

					// Add legend
					legend: {
						data: [ 'Sessions', 'Products' ]
					},

					// Add custom colors
					color: [ '#333333', '#032443' ],

					// Enable drag recalculate
					calculable: true,

					// Horizontal axis
					xAxis: [ {
						type: 'category',
						data: [ 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' ]
					} ],

					// Vertical axis
					yAxis: [ {
						type: 'value'
					} ],

					// Add series
					series: [ {
						name: 'Sessions',
						type: 'bar',
						data: [ 2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3 ],
						itemStyle: {
							normal: {
								label: {
									show: false,
									textStyle: {
										fontWeight: 500
									}
								}
							}
						},

					}, {
						name: 'Products',
						type: 'bar',
						data: [ 2.6, 5.9, 9.0, 26.4, 58.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3 ],
						itemStyle: {
							normal: {
								label: {
									show: false,
									textStyle: {
										fontWeight: 500
									}
								}
							}
						},

					} ]
				};

				// Apply options
				// ------------------------------

				myChart.setOption( chartOptions );


				// Resize chart
				// ------------------------------

				$( function () {

					// Resize chart on menu width change and window resize
					$( window ).on( 'resize', resize );
					$( ".menu-toggle" ).on( 'click', resize );

					// Resize function
					function resize() {
						setTimeout( function () {

							// Resize chart
							myChart.resize();
						}, 200 );
					}
				} );
			}
		);
	} );	
	
	
	




	