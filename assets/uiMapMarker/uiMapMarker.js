/*
**  Project required    : jQuery-3.2.1, bootstrap-4.3.1, jBox-0.6.4, Google Map Api
**  Auther              : Srikee Eatrong
**  Datetime            : 8/5/2019 10.39
**  Company             : Computer Center PSU Pattani Campus.
***********************************
    Example Usage
    
    uiMapMarker({
        title: "Map marker",
        //marker: [6.901397, 101.242161],
        onClose: function(marker) {
            console.log(marker);
        }
    });
*/
function uiMapMarker(opt) {
    var option = {};
    option.title = opt.title || "Map Marker";
    option.center = opt.center || [6.877186, 101.235034];
    option.marker = opt.marker || [];
    option.zoom = opt.zoom || 15;
    option.onClose = opt.onClose || function() {};
    option.popup = null;
    option.map = null;
    option.map_marker = null;
    option.selected = false;
    var $title = $('\
        <div>\
            '+option.title+'\
        </div>\
    ');
    var $contents = $('\
        <div>\
            AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>\
        </div>\
    ');
    var $footer = $('\
        <div class="text-right">\
            <!--\
            <button class="btn btn-primary btn-upload" disabled><i class="fas fa-ok"></i> ตกลง</button>\
            <button class="btn btn-light btn-cancel border"><i class="fas fa-times"></i> ยกเลิก</button>-->\
            <div class="row m-0">\
                <div class="col p-0 pr-2">\
                    <input type="input" class="form-control">\
                </div>\
                <div class="col-md-auto p-0">\
                    <button class="btn btn-primary btn-ok" disabled><i class="fas fa-check"></i> ตกลง</button>\
                    <button class="btn btn-light btn-cancel border"><i class="fas fa-times"></i> ยกเลิก</button>\
                </div>\
            </div>\
        </div>\
    ');
    $footer.find('.btn-ok').click(function(event) {
        option.selected = true;
        option.popup.close();
    });
    $footer.find('.btn-cancel').click(function(event) {
        option.popup.close();
    });
    $footer.find('input').keyup(function(event) {
        var val = $(this).val();
        var marker = val.split(",");
        if( marker.length!=2 ) return;
        if( marker[0].trim()=='' || marker[1].trim()=='' ) return;
        if( marker[0]*1<-90 || marker[0]*1>90 ) return;
        makeMarker(marker[0]*1, marker[1]*1);
        option.map.setCenter(new google.maps.LatLng(marker[0]*1, marker[1]*1));
    });
    $footer.find('input').blur(function(event) {
        if( option.marker.length==2 ) {
            $(this).val(option.marker[0] + ", " + option.marker[1]);
        } else {
            $(this).val("");
        }
    });
    option.map = new google.maps.Map( $contents[0] );
    option.map_marker = null;
    option.map.setCenter(new google.maps.LatLng(option.center[0], option.center[1]));
    option.map.setZoom(option.zoom);
    if( Array.isArray(option.marker) && option.marker.length==2 ) {
        makeMarker(option.marker[0], option.marker[1]);
        option.map.setCenter(new google.maps.LatLng(option.marker[0], option.marker[1]));
    }
    option.map.addListener('click', function(e) {
        makeMarker(e.latLng.lat(), e.latLng.lng());
    });
    function makeMarker(lat, lng){
        if(option.map_marker!=null) option.map_marker.setMap(null);
        option.map_marker = new google.maps.Marker({
            position: new google.maps.LatLng(lat, lng),
            draggable: true,
        });
        option.map_marker.setMap(option.map);
        option.map_marker.addListener('drag', function(event) {
            $footer.find("input[type='input']").val(event.latLng.lat()+", "+event.latLng.lng());
            option.marker[0] = event.latLng.lat();
            option.marker[1] = event.latLng.lng();
        });
        $footer.find("input[type='input']").val(lat+", "+lng);
        $footer.find('.btn-ok').removeAttr('disabled');
        option.marker[0] = lat;
        option.marker[1] = lng;
    }
    option.popup = new jBox('Modal', {
        title: $title,
        content: $contents,
        footer: $footer,
        width: "100%",
        height: "100%",
        draggable: 'title',
        overlay: true,
        addClass: 'uiMapMarker',
        onClose: function() {
            if( !option.selected ) option.marker = [];
            option.onClose(option.marker);
        }
    }); 
    option.popup.open();
}