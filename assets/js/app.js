import $ from 'jquery';
import 'bootstrap-sass';


import '../css/app.scss';

import 'jquery-templates';


var hotel_tmpl = $('#hotel_tmpl').html();
$( document ).ready(function() {
  $('#filter').click(function(){
    getHotels(buildFilter());
  });

  getAllHotels();
});

function getAllHotels(){
  $('#results').html('Cargando...');
  $.ajax("api/hotels/", {
    type : "GET",
    contentType : "application/json",
    success : function(data) {
        buildResults(data);
    }
  });
}

function getHotels(filter){
  $('#results').html('Cargando...');
  $.ajax("api/hotels/"+filter, {
    type : "GET",
    contentType : "application/json",
    success : function(data) {
        buildResults(data);
    }
  });

  if(data.length == 0){
    $('#results').html('<div class="alert alert-warning" role="alert">No se encontraron hoteles</div>');
  }
}

function buildResults(data){
  $('#results').html('');

  for(var i=0; i<data.length; i++){
    var row = data[i];
    $.tmpl( hotel_tmpl, row).appendTo( "#results" );
    buildStars(row.id,row.stars);
  }

  if(data.length == 0){
    $('#results').html('<div class="alert alert-warning" role="alert">No se encontraron hoteles</div>');
  }
}

function buildStars(id,stars){
  for(var i=1;i<=stars;i++){
    $('#hotel_'+id+' div.stars .star_' + i).css('color','#ffa600');
  }
}

function buildFilter(){
  var data = {
    'country':encodeURI($('#country').val()),
    'city':encodeURI($('#city').val()),
    'stars':$('#stars').val(),
    'price':$('#price').val(),
  };
  return btoa(JSON.stringify(data));
}
