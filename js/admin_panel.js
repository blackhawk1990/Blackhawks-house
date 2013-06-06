$(function(){
    
    $('#body .content .admin-option-content').not('.admin-option-content:eq(0)').hide();
    
    $('#admin-menu li a').click(function(e){
        
        e.preventDefault();
        
        $('#body .content .admin-option-content').hide();
        
        $($(this).attr('href')).fadeIn('fast');
        
    });
    
    //kalendarz
    $.datepicker.regional['pl'];
    $('#date').datepicker({ 
        dateFormat : 'yy-mm-dd'
    });
    
    //tooltip
    $('#used-technologies').attr('title', 'Tagi przedzielone przecinkami lub zatwierdzone klawiszem ENTER');
    $('#used-technologies[title]').tooltip({
        position: {
          my: "center bottom-20",
          at: "center top",
          using: function( position, feedback ) {
            $( this ).css( position );
            $( "<div>" )
              .addClass( "tooltip" )
              .appendTo( this );
          }
        }
    });
    
    //tagi
    $('#used-technologies').tagsManager({
        //tagClass : "tm-tag-small",
        tagsContainer : $('#tags')
    });
    
});