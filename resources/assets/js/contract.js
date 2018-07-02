$(function(){
	var tbody_f = document.querySelectorAll('.table-fixed tbody');
	for(var i = 0; i < tbody_f.length; i++){
		console.log(tbody_f[i]);
		const ps2 = new PerfectScrollbar(tbody_f[i], {
	   		wheelSpeed: 0.1,
	       	minScrollbarLength: 90
	   });
	}
         
});
