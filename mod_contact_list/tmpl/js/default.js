function getFormatItemHtml(item, params){
	output = '';	
	
	output += '<div class="contact-item">';
		// должность
		if (params.item_position) {
			output += 
			'<div class="contact-position">'+
				item.con_position +
			'</div>';
		}
		
		// Имя
		if (params.item_title){
			output += '<div class="contact-fio">' +			
				'<' + params.item_heading + ' class="contact-title' + params.moduleclass_sfx + '">';
				
				if (params.link_titles) {
					output += 
					'<a href="#">'+
						item.name +
					'</a>';
				}
				else {
					output += item.name;
				}					
				output += '</' + params.item_heading + '>' +			
			'</div>';
		}	
		
		output +=
		'<div class="contact-number">' +
			'<span>' + item.telephone + '</span>' +
		'</div>' +
	'</div>';
	return output;	
}

// show active group
function showGroup(el, page){
	var result = false;
	var contactlist = jQuery(el).siblings('.contact-list');	
	var form = jQuery(el).siblings('form');	
	var group = jQuery(contactlist).find('.group-items.group'+page);
	
	// hidden contactlist and all group
	jQuery(contactlist).fadeOut( "fast" );
	jQuery(contactlist).find('.group-items').hide();
	
	if(group.length){		
		jQuery(group).show();		
		jQuery(form).find('input[name=page]').val(page);
		result = true;
	}	
	// show contactlist
	jQuery(contactlist).fadeIn( "slow" );
	// show buttons arrow
	showHideArrows(el, page);
	return result;
}

function showPrevGroup(el){	
	var form = jQuery(el).siblings('form');
	var page  = jQuery(form).find('input[name=page]').val();	
	page--;	
	
	// show group prev
	showGroup(el, page);	
}

function showNextGroup(el){
	var contactlist = jQuery(el).siblings('.contact-list');
	var form = jQuery(el).siblings('form');	
	var page = jQuery(form).find('input[name=page]').val();
	page++;
	
	var group = jQuery(contactlist).find('.group-items.group'+page);
	
	// if isset group show group. else getGroup	
	if(!group.length)
		getDataAjaxNext(el, page)
	else {
		showGroup(el, page);
	}
}

// show or hide arrows button
function showHideArrows(el, curPage){
	var contactlist = jQuery(el).siblings('.contact-list');	
	var btnNext = jQuery(contactlist).siblings('button.arrow-next');
	var btnprev = jQuery(contactlist).siblings('button.arrow-prev');

	jQuery(btnprev).hide();
	jQuery(btnNext).hide();
	
	if(curPage > 0) {
		jQuery(btnprev).show();
	
		// find first group
		first_group = jQuery(contactlist).children('.group-items').first();
		// find last group
		last_group = jQuery(contactlist).children('.group-items').last();
		
		// count items from last group
		countItemsFirst = jQuery(first_group).find('.contact-item').length;
		countItemsLast = jQuery(last_group).find('.contact-item').length;
		
		// this group active is last item and count items full
		if(!(jQuery(last_group).hasClass('group'+curPage) && countItemsFirst > countItemsLast))
			jQuery(btnNext).show();
	}
	else 
		jQuery(btnNext).show();
}

// get next page data
function getDataAjaxNext(el, nextPage){
	var contactlist = jQuery(el).siblings('.contact-list');
	var form = jQuery(el).siblings('form');	
	var title  = jQuery(form).find('input[name=title]').val();
	
	var format = 'json'; // debug
	request = {
		'option': 'com_ajax',
		'module': 'contact_list',
		'title'	: title,
		'page'	: nextPage,
		'format' : format
	};
	
	jQuery.ajax({
		type   : 'POST',
		data   : request,
		success: function (response) {
			//console.log(response);
			if(response.data){
				var result = '';				
				jQuery.each(response.data.items, function (index, value) {
					result += getFormatItemHtml(value, response.data.params);
				});				
				
				if(result != '')				
					jQuery(contactlist).append('<div class="group-items group'+ nextPage +'">' + result + '</div>');				
				showGroup(el, nextPage);
			} else {
				//jQuery('.status').html(response);
				console.log(response);
			}
		},
		error: function(response) {
			var data = '',
				obj = jQuery.parseJSON(response.responseText);
			for(key in obj){
				data = data + ' ' + obj[key] + '<br/>';
			}
			console.error(data);
		}
	});
	return false;	
}