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

////////// Buy  ////////

$('#btn-mail, #btn-mail-rent').click(function(){  //Affichage du mail
  $(".fa-envelope").remove(); //Affichage de l icone de chargement
  $('#btn-mail, #btn-mail-rent').attr('disabled', 'disabled');
  $('#btn-mail, #btn-mail-rent').text('');
  $('#btn-mail, #btn-mail-rent').append($('<span class="load fas fa-spinner"></span>'));

  let id = $("#nbAdvert").val();
  $.ajax({ //Appel pour les données
    url:"http://localhost/mango/web/app_dev.php/mango/achat/annonce/" + id + "/mail",
    data: { id : $("#user-id").val() },
    type:'POST',
    success: function(mail){
      $('#btn-mail, #btn-mail-rent').text(mail);    
    }
  });
});

$('#btn-tel, #btn-tel-rent').click(function(){  //Affichage du téléphone
  $(".fa-phone").remove(); //Affichage de l icone de chargement
  $('#btn-tel, #btn-tel-rent').attr('disabled', 'disabled');
  $('#btn-tel, #btn-tel-rent').text('');
  $('#btn-tel, #btn-tel-rent').append($('<span class="load fas fa-spinner"></span>'));

  let id = $("#nbAdvert").val();
  $.ajax({
    url:"http://localhost/mango/web/app_dev.php/mango/achat/annonce/" + id + "/phone",
    data: { id : $("#user-id").val() },
    type:'POST',
    success: function(phone){
      $('#btn-tel, #btn-tel-rent').text(phone);    
    }
  });
});
