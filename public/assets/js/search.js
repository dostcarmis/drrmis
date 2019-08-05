$(document).ready(function(){
	$searchval = 'Recent';
    $('.search-panel .dropdown-menu').find('a').click(function(e) {
		e.preventDefault();
		$searchval = $(this).text();
		$('.search-panel span#search_concept').text($searchval);
		console.log($searchval);
	});
	$('#searchroadnetwork').on('keyup',function(){
		$value = $(this).val();
		$.ajax({
			type : 'get',
			url: 'searchroadnetwork',
			data: {
				'searchroadnetwork' : $value,
				'searchval' : $searchval
			},
			success:function(data){
				$('.allwrap').html(data);
				
			}
		});

	});

});
