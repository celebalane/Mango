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
