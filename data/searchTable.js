$(document).ready(function(){
    $('#searchTable').keyup(function(){
        let search = $(this).val();
        $('table tbody tr').hide();
        let len = $('table tbody tr:not(.notFound) td:contains("'+search+'")').length;

        if(len > 0){
            $('table tbody tr:not(.notFound) td:contains("'+search+'")').each(function(){
                $(this).closest('tr').show();
            });
        }else{
            $('.notfound').show();
        }
    });
});

$.expr[":"].contains = $.expr.createPseudo(function(arg) {
    return function( elem ) {
        return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
    };
});