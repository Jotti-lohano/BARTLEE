
const $  = require( 'jquery' );
const dt = require( 'datatables.net' );

class Datatable{

		constructor(selector,config){
			this.selector = selector;
			this.config = {
				serverSide: true,
				paging: true,
				columns : [],
				searchable : true,
				...config,
			};

			this.initialize();
		}
		on(event , callback){
			this.table.on(event,callback);
		}
		removeRow(rowIndex){
			setTimeout(function(){

			let row = $(this.selector).children('tr').eq(rowIndex);
			console.log(row);
				this.table
	        .rows([ 0] )
	        .remove()
	        .draw();
			},1000);
			// console.log(this.table.row(row).remove());
			// this.table.rows(row).remove().draw();
		}
		initialize(){
			this.table = $(this.selector).DataTable(this.config);
		}
}

export default Datatable;