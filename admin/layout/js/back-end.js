$(function () {
       // Hide Placeholder On Form Focus
$('[placeholder]').focus(function() {
       $(this).attr('data-text', $(this).attr('placeholder'));
       $(this).attr('placeholder', '');
});

$(".confirm").click(function(){

     return confirm(" Are You Sure You Want To Delete This ?")
              
})      

});

// Category view option
$('.cat h3').click(function(){
       $(this).next('.full-view').fadeToggle(200);
});
