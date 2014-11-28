(function( $ ){

  var methods = {
    init : function(options) 
    { 
    	$(this).on( "change", function() 
		{
    		$(this).libToggle('leafOver');
		});
    	data = [];
    },
    leafOver : function() 
    {
    	//data['bookList'][0]//this.val()
    	var items = '';
    	$.each(data['bookList'][this.val()], function( index, value ) 
		{
    		items += value;
		});
    	$(data['ElementToAttach']).html(items);
    },
    setBooksList : function(elementsArr) 
    {
		data['bookList'] = elementsArr;
    },
    setElementToAttach : function(element) 
    {
		data['ElementToAttach'] = element;
    },
    /*update : function( content ) 
    {
    	
    }*/
};

  	$.fn.libToggle = function( method ) 
  	{
    if ( methods[method] ) 
    {
    	return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
    } 
    else if ( typeof method === 'object' || !method ) 
    {
    	return methods.init.apply( this, arguments );
    } 
    else 
    {
    	$.error( 'Метода с именем ' +  method + ' не существует' );
    } 
};

})( jQuery );

/*$( "#dataTable tbody tr" ).on( "click", function() {
alert( $( this ).text() );
});*/