var PW = {
    venue_id: null,
    venue_name: null,
    widget_code: null,
    
    findCallback: function(data) {
        $('pw-loading').setStyle('display', 'none');
        if(!data['status'] == 0) {
            error_div.set('text', data['errmsg']).setStyle('display', 'block');
            return;
        }
        
        num_venues = data['venues'].length;
        markup = '<h3>Select a place:</h3>';
        for(var i = 0; i < num_venues; i++) {
            markup +='<label for="venue_'+i+'"><input type="radio" name="venues" id="venue_'+i+'" value="'+data['venues'][i]['id']+'" /><span>'+data['venues'][i]['name']+'</span> at '+data['venues'][i]['address']+'</label>';
        }
        $('venue_results').set('html', markup);
    },
    
    findVenue: function() {
        error_div = $('find-venue-error');
        error_div.empty().setStyle('display', 'none');
        $('venue_results').empty();
        venue_name = $('venue_name').value;
        venue_location = $('venue_location').value;
        if(!venue_name || !venue_location) {
            error_div.set("text", "Please enter a name and location for your place.").setStyle('display', 'block');
            return;
        }
        
        $('pw-loading').setStyle('display', 'block');
        new Request.JSONP({
            'url': 'http://www.placewidget.com/venue.jsonp',
            'method': 'get',
            'data': {
                'name': venue_name,
                'location': venue_location
            },
            'onComplete': PW.findCallback
        }).send();
    },
    
    codeComplete: function(data) {
        $('pw-loading').setStyle('display', 'none');
        if(!data['status'] == 0) {
            $('widget-embed-error').set('text', data['errmsg']).setStyle('display', 'block');
            return;
        }
        
        $('save-venue-name').value = PW.venue_name;
        $('save-embed-code').value = data['code'];
        $('save-settings').submit();
    },
    
    getCode: function() {
        venue_id = $('venue_results').getElements('input[name=venues]:checked');
        if (venue_id.length) {
            venue_name = venue_id[0].getNext().get('text');
            venue_id = venue_id[0].value;
        } else {
            venue_id = false;
        }
        
        input_interval = $('interval').get('value');
        input_size = $('size').get('value');
        
        if(!venue_id || !input_interval || !input_size) {
            $('widget-embed-error').set('text', 'Please enter all the details above.').setStyle('display', 'block');
            return;
        }
        
        this.venue_name = venue_name;
        
        $('pw-loading').setStyle('display', 'block');
        
        new Request.JSONP({
            'url': 'http://www.placewidget.com/create.jsonp',
            'data': {
                'venue_id': venue_id,
                'venue_name': venue_name,
                'interval': input_interval,
                'size': input_size
            },
            'onComplete': PW.codeComplete
        }).send();
    },
    
    init: function() {
        $('venue-find').addEvent('submit', function() {
            PW.findVenue();
            return false;
        });
        
        $('venue_location').addEvent('focus', function() {
            if(!$('venue_location').get('has_focus')) {
                $('venue_location').value = "";
                $('venue_location').set('has_focus', true);
            }
        });
        
        $('widget-submit').addEvent('click', function() {
            PW.getCode();
            return false;
        });
    }
}



window.addEvent('domready', function() {
    PW.init();
});