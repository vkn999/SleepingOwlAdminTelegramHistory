jQuery(function ($) {

    function iterateColumnFilters(datatableId, callback) {
        $(`[data-datatables-id="${datatableId}"] .column-filter[data-type]`).each((i, subitem) => {
            let $element = $(subitem)

            callback(
                $element,
                $element.closest('[data-index]').data('index'),
                $element.data('type')
            )
        });
    }


// Set empty filter and order.
$('#export_button').data('query_order', '');
$('#export_button').data('query_filter', '');

// Generate filter.
$("#filters-exec").on('click', function () {

  var query_filter = [];	 	

  $('.datatables').each((i, item) => {
       
      let $this = $(item),
          id = $this.data('id');

       iterateColumnFilters(id, function ($element, index, type) {
	  if (type != 'control') {
	    if (type == 'range') {
              value = $element[0].firstChild.value + '::' + $element[0].lastChild.value; 
            }
            else {		
              value = $element[0].value;
            }

            if (value != '' && value != '::') {	
              query_filter.push({
                key: index-1,
                value: value
              })
            }	
	  }
       });    	

  });

  query_filter_data = query_filter.length > 0 ?
  	JSON.stringify(query_filter) : '';
  $('#export_button').data('query_filter', query_filter_data);

});
$("#filters-cancel").on('click', function () {
  $('#export_button').data('query_filter', '');
});


// Generate query order.
$(".datatables .row-header").on('click', function () {
   var index = $(".datatables .row-header").index($(this));
   var query_order = '';

   if ($(this).hasClass('sorting_asc')) {
       query_order = {key: index, value: 'desc'};
   }
   else {
       query_order = {key: index, value: 'asc'};
   }

   query_order_data = '';
   if (query_order != '') {
     query_order_data = JSON.stringify(query_order);
   }
   $('#export_button').data('query_order', query_order_data);
});

 
}); 