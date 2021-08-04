$(document).ready(function(){


    $('.content').on('click', 'a.confirmAction',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        if(confirm("Are you sure?")){
            window.location = url;
        }
        /*$( "#dialog" ).dialog({
            resizable: false,
            height: "auto",
            width: 300,
            modal: true,
            buttons: {
                "Yes": function() {
                    window.location = url;
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            }
        });*/
    })
});