//////////////////////////////////////////// AFFICHAGE DYNAMIQUE DES CHAMPS //////////////////////////////////////////

$(document).on('change', '#mango_platformbundle_rent_region, #mango_platformbundle_rent_departement', function () {
  let $field = $(this) //Cible de l'événement
  let $regionField = $('#mango_platformbundle_rent_region')

  let $form = $field.closest('form')
  let target = '#' + $field.attr('id').replace('departement', 'city').replace('region', 'departement')
  // Les données à envoyer en Ajax
  let data = {}
  data[$regionField.attr('name')] = $regionField.val()
  data[$field.attr('name')] = $field.val()
  // On soumet les données
  $.post($form.attr('action'), data).then(function (data) {
    // On récupère le nouveau <select>
    let $input = $(data).find(target)
    // On remplace notre <select> actuel
    $(target).replaceWith($input)
    $(target).parent().removeClass('d-none')  //Apparition des champs
  });
});

$(document).on('change', '#mango_platformbundle_buy_region, #mango_platformbundle_buy_departement', function () {
  let $field = $(this) 
  let $regionField = $('#mango_platformbundle_buy_region')
  let $form = $field.closest('form')
  let target = '#' + $field.attr('id').replace('departement', 'city').replace('region', 'departement')

  let data = {}
  data[$regionField.attr('name')] = $regionField.val()
  data[$field.attr('name')] = $field.val()

  $.post($form.attr('action'), data).then(function (data) {
    let $input = $(data).find(target)
    $(target).replaceWith($input)
    $(target).parent().removeClass('d-none')  
  });
});


//////////////////////////// Icone de chargement ///////////////////////

$.ajaxSetup({
    beforeSend: function() {
        $(".load").show();
    },
    complete: function() {
        $(".load").hide();
    }
});


/////////////////////////// Contact //////////////////////////////////


$('.contact').click(function(){  //Affichage de la demande de connexion
  $('body').append(
    '<div id="show-message" class="d-flex justify-content-center align-items-center">' +
      '<div class="col-10 col-lg-4 d-flex flex-column justify-content-center align-items-center">' +
        '<div id="close-message" class="ml-auto">' +
          '<span class="far fa-times-circle"></span>' +
        '</div>' +
        '<p>Pour rentrer en contact avec l\'auteur de cette annonce merci de bien vouloir vous connecter. Si vous ne disposez pas encore de compte sur Mango ann-immo, nous serions ravis de vous compter parmis nos utilisateurs. L\'inscription est simple et gratuite</p>' +
        '<a href="/login" class="btn col-12 col-md-6 col-lg-6">Se connecter</a>' +
        '<a href="/register/" class="btn col-12 col-md-6 col-lg-6">S\'inscrire</a>' +
      '</div>' +
    '</div>'
  );

  $('#close-message').click(function(){  //Fermeture du message
    $('#show-message').remove();
  });
});

$('#btn-mail').click(function(){
  let data = {};
  $.get($(this).attr('action'), data).then(function(data){
    $('#mail-user').remove();
    $('#btn-mail').text(data);
  })
});