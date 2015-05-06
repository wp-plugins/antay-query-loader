
if( AqlObject.switch == 'true' ) {
	window.addEventListener('DOMContentLoaded', function() {
	    new QueryLoader2(document.querySelector("body"), {
	        barColor: AqlObject.barColor,
	        backgroundColor: AqlObject.backgroundColor,
	        percentage: (AqlObject.percentage === 'true'),
	        barHeight: AqlObject.barHeight,
	        minimumTime: AqlObject.minimumTime,
	        fadeOutTime: AqlObject.fadeOutTime
	    });
	});
}