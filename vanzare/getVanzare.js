$().ready(function (){
    $("#comboTip").change(function (){
        let type = $("#comboTip").val();
        $.ajax({
            url: '../vanzare/getVanzare.php',
            method: 'post',
            data: {type: type},
            dataType: 'json'
        }).done(function (out){
            let len = out.length;
            $("#combocodp").empty();
            for( let i = 0; i<len; i++){
                $("#combocodp").append("<option value='" + out[i][0] + "'>" + out[i][0] + "</option>");
            }
        })
    })

    $("#combocodp").change(function (){
        let typeS = $("#comboTip").val();
        let codpS = $("#combocodp").val();
        if (typeS == null)
            typeS = "Piese";
        $.ajax({
            url: '../vanzare/getVanzare.php',
            method: 'post',
            data: {typeS: typeS, codpS: codpS},
            dataType: 'json'
        }).done(function (out){
            console.log(out);
            $("#produs").val(out[0][0]);
            $("#pret").val(out[0][1]);
            $("#prettva").val(out[0][2]);
        })
    })

    $("#combonumec").change(function (){
        let numec = $("#combonumec").val();
        $.ajax({
            url: '../vanzare/getVanzare.php',
            method: 'post',
            data: {numec: numec},
            dataType: 'json'
        }).done(function (out){
            let len = out.length;
            $("#comboprenumec").empty();
            for( let i = 0; i<len; i++){
                $("#comboprenumec").append("<option value='" + out[i][0] + "'>" + out[i][0] + "</option>");
            }
        })
    })
})