$(function(){
    
    correctMenuStyle();
    
});

function correctMenuStyle()
{
    if($('#header ul li').size() > 1)
    {
        var diff = $('#header ul li').size() - 1;
        
        var oldWidth = parseInt($('#header ul').css("width").replace('px', ''));
        $('#header ul').css("width", (oldWidth + diff*120) + 'px')
    }
}