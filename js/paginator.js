//sciezka do skryptow pobrana z konfiguracji
var scriptsPath = '';

$(function(){
   
   scriptsPath = $('#scripts-path').val();
   
   //****************************<paginator>***************************************************//
    $('#paginator-wrapper li a').live("click", (function(e){
        
        e.preventDefault();
        
        if(!$(this).parent('li').hasClass('static') && !$(this).parent('li').hasClass('active'))
        {
            $('#paginator-wrapper li.active').removeClass('active');
            $(this).parent('li').hide();
            $(this).parent('li').addClass('active');
            $(this).parent('li').fadeIn('fast');
        }
        else //for non static elements
        {
            if($(this).parent('li')[0] == $('#paginator-wrapper li:first-child')[0] && !$(this).parent('li').hasClass('active'))
            {
                $('#paginator-wrapper li.active').removeClass('active');
                $('#paginator-wrapper li:eq(1)').hide();
                $('#paginator-wrapper li:eq(1)').addClass('active');
                $('#paginator-wrapper li:eq(1)').fadeIn('fast');
            }
            else if($(this).parent('li')[0] == $('#paginator-wrapper li:last-child')[0]  && !$(this).parent('li').hasClass('active'))
            {
                $('#paginator-wrapper li.active').removeClass('active');
                $('#paginator-wrapper li:last-child').prev().hide();
                $('#paginator-wrapper li:last-child').prev().addClass('active');
                $('#paginator-wrapper li:last-child').prev().fadeIn('fast');
            }
        }
        
    }));
    //****************************</paginator>*************************************************//
    
});

function loadPage(clicked, view_name, params)
{
    if(params['init'] === undefined)
        params['init'] = 0;
    console.log(($(clicked).parent('li')[0] == $('#paginator-wrapper li:last-child')[0]) && !$(clicked).parent('li').prev().hasClass('active'));
    
    if($($(clicked).attr('href')).find('#error').size() === 0 &&
        (
            (($(clicked).parent('li')[0] == $('#paginator-wrapper li:first-child')[0]) && !$(clicked).parent('li').next().hasClass('active')) ||
            (($(clicked).parent('li')[0] == $('#paginator-wrapper li:last-child')[0]) && !$(clicked).parent('li').prev().hasClass('active')) ||
            (($(clicked).parent('li')[0] != $('#paginator-wrapper li:first-child')[0]) && ($(clicked).parent('li')[0] != $('#paginator-wrapper li:last-child')[0]) && !$(clicked).parent('li').hasClass('active')) ||
            params['init']
        ))
    {
        $($(clicked).attr('href')).html('<div class="loader-big"><img src="styles/img/loader_big.gif" /></div>');
        
        $.post(scriptsPath + "paginatorPageLoad.php", { 
            v: view_name,
            p: params['p']
        }, function(resp){
            
            //obsluga bledow
            switch(resp)
            {
                case '0':
                    $($(clicked).attr('href')).html("<div id=\"error\" class=\"errorWrapper\"><span class=\"errorText\">Strona nie istnieje!</span></div>");
                    break;
                case '':
                    $($(clicked).attr('href')).html("<div id=\"error\" class=\"errorWrapper\"><span class=\"errorText\">Błąd ładowania zawartości!</span></div>");
                    break;
                default:
                    $($(clicked).attr('href')).html(resp);
                    break;
            }

        });
    }
}