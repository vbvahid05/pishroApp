

$(document).ready(function()
{

	$('.ui.checkbox')
	  .checkbox()
	;

	$('#custommer_organization_list').dropdown();
	$('#custommer_post_title_list').dropdown();

  $('.step').click(function(){
		$(".step").removeClass("active");
	  $(this).addClass("active");
		var stepName=$(this).attr('id');
			if (stepName=="customerPerson")
			{
				$(".stepForm ").removeClass("active");
				$('#StepNo1').addClass("active");
			}
			if (stepName=="CustommerOrganization")
			{
				$(".stepForm ").removeClass("active");
				$('#StepNo2').addClass("active");
			}
			if (stepName=="PersonInOrganization")
			{
				$(".stepForm ").removeClass("active");
				$('#StepNo3').addClass("active");
			}
	});

/* Add new Type*/
	$("#add_new_productType").click(function()
  {
    $('#addNewType').dimmer('show');
  });

	$("#new_productType_Cancel").click(function()
	{
		$('#addNewType').dimmer('hide');
	});

	/* allProducts.blade.php */
	$('#BrandList').dropdown();


/* custommer.blade.php*/
$("#add_new_Org").click(function()
{
	$('#newORGform').dimmer('show');
});

$("#add_new_productType").click(function()
{
	$('#AddNewOrEditProduct_Types').dimmer('show');
});

$('#org-list').dropdown();
$('#custommerList').dropdown();


/* Lab.blade.php*/
  $("#morez").click(function()
  {
    $('#dimmer').dimmer('show');
  });



  $('#search-select').dropdown();
  $('.search-select').dropdown();
$('.tabular.menu .item').tab();

$('#TabBarLevel2').tab();

	/*
	$('.ui.dropdown').dropdown();

	$('#search-select').dropdown();

    $("#morez").click(function()
	{
		$('#dimmer').dimmer('show');
	});

	 $("#close").click(function()
	{
		$('#dimmer').dimmer('hide');
	});
	*/


   $('.ui.normal.dropdown')
    .dropdown({
    });



});
