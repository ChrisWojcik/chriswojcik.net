$(document).ready(function() {
    var currentPanel = 0;
    var panelWidth = 940;
    var panels = $('.panel');
    var numberOfPanels = panels.length;
                
    panels.wrapAll('<div id="panel-container"></div>');
                
    $('#panel-container').css('width', panelWidth * numberOfPanels);
                
    manageControls(currentPanel);
                
    $('.control').click(function() {
        if($(this).attr('id')=='prev-control') {
            currentPanel--;
        }
        else if($(this).attr('id')=='next-control') {
            currentPanel++;
        }
                   
        manageControls(currentPanel);
                   
        $('#panel-container').animate( {
            left : panelWidth * (-currentPanel)
        });
                   
        manageLinks(currentPanel);
                   
        return false;
    });
                
    $('#panel-links a').click(function() {
        currentPanel = $('#panel-links li a').index(this);
                    
        manageControls(currentPanel);
                   
        $('#panel-container').animate( {
           left : panelWidth * (-currentPanel)
        });
                   
        manageLinks(currentPanel);
                   
        return false;
    });
                
    function manageControls(position) {
        if(position==0) {
            $('#prev-control').hide()
        }
        else {
            $('#prev-control').show()
        }
        if(position==numberOfPanels-1) {
            $('#next-control').hide()
        }
        else {
            $('#next-control').show();
        }
    }
                
    function manageLinks(position) {
        $('#panel-links li a').removeClass('current');
        $('#panel-links li a').eq(position).addClass('current');
    }
                
});