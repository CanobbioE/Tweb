var DIR = "/progetto/"; // @@@@@@ WARNING: site's directory, change accordingly
var MAX_CHAR = 128;

document.observe("dom:loaded", function() {
	switch(location.pathname) {
/*------------------------------PAGE IS INDEX------------------------------*/
		case DIR + "index.php":
			// highlight current
			$$('#navigation li')[0].addClassName('c1');
			// slideshow
			slideshow();
			// article
			new Ajax.Request( 
				"content/xml/article.xml",
				{
					method: 'GET',
					onSuccess: printArticle,
					onFailure: ajaxFailure,
					onException: ajaxFailure
				}
			);
			break;
/*------------------------------PAGE IS EVENTS------------------------------*/
		case DIR + "events.php":
			// highlight current
			$$('#navigation li')[1].addClassName('c1');
			// event creation count chars
			textareaCount();
			break;
/*------------------------------PAGE IS WEATHER------------------------------*/
		case DIR + "weather.php":
			// highlight current
			$$('#navigation li')[2].addClassName('c1');
			// forecast
			new Ajax.Request( 
				"content/xml/forecast.xml",
				{
					method: 'GET',
					onSuccess: printForecast,
					onFailure: ajaxFailure,
					onException: ajaxFailure
				}
			);
			break;
/*------------------------------PAGE IS MARKET------------------------------*/
		case DIR + "market.php":
			// highlight current
			$$('#navigation li')[3].addClassName('c1');
			// show div on cc select
			$(box).observe("change", hideField);
			$(unbox).observe("change", showField);
			// drag and drop
			$$('.item img').each(function(item) {
				new Draggable ( item, { ghosting: true });
			});
			Droppables.add(
				'drop-area',
				{
					hoverclass: "bold-div",
					onDrop: itemDropped
				}
			);
			break;
/*------------------------------PAGE IS PROFILE------------------------------*/
		case DIR + "profile.php":
			// highlight current
			$$('#navigation li')[4].addClassName('c1');
			break;
/*------------------------------PAGE IS LOGIN------------------------------*/
		case DIR + "login.php":
			// highlight current
			$$('#navigation li')[5].addClassName('c1');
			break;

		default:
			break;

	} 	// end switch
	
}); 	// end onload ---------------------------------------------------------------------------------------------------------


/*--------------SLIDESHOW--------------*/
var index = 0;
var time = 4000; // change img every 4s
function slideshow() {
	var imgs = $$('#slideshow img');
	for (var i = 0; i < imgs.length; i++) {
		imgs[i].style.display = "none";
	}
	index++;
	if(index > imgs.length) { 
		index = 1;
	}
	imgs[index - 1].style.display = "block";
	setTimeout(slideshow, time);
}

/*------------AJAX ARTICLE-------------*/
function printArticle(ajax) {
	var text = ajax.responseXML.getElementsByTagName('p');
	var title = ajax.responseXML.getElementsByTagName('title');
	var h = document.createElement('h1');
	h.innerHTML = title[0].firstChild.nodeValue;
	h.addClassName('cntr');
	$('article').appendChild(h);

	for (var i = 0; i < text.length; i++) {
		var p = document.createElement('p');
		p.innerHTML = text[i].firstChild.nodeValue;
		$('article').appendChild(p);
	}

}

/*-------------CHARS COUNTER-------------*/
function textareaCount() {
	$('counter').innerHTML = MAX_CHAR;

	$('desc').observe('keyup', function() {
		var text_len = $('desc').value.length;
		var text_left = MAX_CHAR - text_len;

		$('counter').innerHTML = text_left;
	});
}

/*------------AJAX FORECAST-------------*/
function printForecast(ajax) {
	var days = ajax.responseXML.getElementsByTagName('day');
	for (var i = 0 ;i < days.length ; i++) {
		day = days[i].getAttribute("value");
		
		var div = document.createElement('div');
		div.innerHTML = day;
		div.addClassName('day c5');
		$('days').appendChild(div).observe('click',changeForecast);

		var min = days[i].getElementsByTagName('tmin')[0].firstChild.nodeValue;
		var max = days[i].getElementsByTagName('tmax')[0].firstChild.nodeValue;
		var perc = days[i].getElementsByTagName('precipitation')[0].firstChild.nodeValue;

		// create and add values to dd's
		var mindd = document.createElement('dd');
		var maxdd = document.createElement('dd');
		var percdd = document.createElement('dd');

		mindd.innerHTML = min + "°C"; 
		maxdd.innerHTML = max + "°C";
		percdd.innerHTML = perc + " %";
		
		// add class =
		mindd.addClassName(day);
		maxdd.addClassName(day);
		percdd.addClassName(day);

		// append dd's and dt's to #forecast	
		$('min').appendChild(mindd).style.display = "none";
		$('max').appendChild(maxdd).style.display = "none";
		$('perc').appendChild(percdd).style.display = "none";
	}
}

/*-------------CHANGE FORECAST-------------*/
function changeForecast() {
	var tmp = $$('#days .day');
	for (var i = 0; i < tmp.length; i++) {
		tmp[i].id = '';
	}
	this.id = 'forecast_curr';
	var all = $$('#forecast dd')
	for (var i = 0; i < all.length; i++) {
		if (all[i].hasClassName(this.innerHTML)) {
			all[i].style.display = "inline";
		} else {
			all[i].style.display = "none";
		}
	}
}

/*-----------SHOW/HIDE FIELD-----------*/
function showField() {
	var field = $('name-search');
	field.style.display = "block";
}
function hideField() {
	var field = $('name-search');
	field.style.display = "none";
}

/*-------------DRAG & DROP-------------*/
function itemDropped(element) { 
 	$$('#market-request label.hidden input').each(function(input) {
 		input.value = element.id;
 	});
 	$$('#drop-area img').each(function(img) {
 		img.src = "content/img/products/" + element.id + ".png";
 	});
}

/*-------------Ajax debug--------------*/
function ajaxFailure(ajax, exception) {
	alert("Error making Ajax request: " + "\n\nServer status:\n" +
		ajax.status + " " + ajax.statusText + 
		"\n\nServer response text: \n " + ajax.responseText);
	if (exception) {
		throw exception;
	}
}