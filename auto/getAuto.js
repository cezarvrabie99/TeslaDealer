$().ready(function (){
    const versionS = ["Long Range", "Plaid", "Plaid +"];
    const version3 = ["Standard Range Plus", "Long Range", "Performance"];
    const versionX = ["Long Range", "Plaid"];
    const versionY = ["Long Range", "Performance"];
    const wheelsS = ["19'' Silver", "21'' Carbon"];
    const wheels3 = ["18'' Aero", "19'' Sport"];
    const wheelsX = ["20'' Silver", "22'' Black"];
    const wheelsY = ["19'' Silver", "20'' Black"];
    const interiorSX = ["Negru", "Alb", "Crem"];
    const interior3Y = ["Negru", "Alb"];
    $("#model").change(function (){
        $("#versiune").empty();
        $("#interior").empty();
        $("#jante").empty();
        switch ($("#model").val()) {
            case "Model S":
                versionS.forEach(myFunction("#versiune"));
                interiorSX.forEach(myFunction("#interior"));
                wheelsS.forEach(myFunction("#jante"));
                $("#nr_usi").val(5);
                $("#tractiune").val("Integrala");
                break;
            case "Model 3":
                version3.forEach(myFunction("#versiune"));
                interior3Y.forEach(myFunction("#interior"));
                wheels3.forEach(myFunction("#jante"));
                $("#nr_usi").val(4);
                $("#tractiune").val("Spate");
                $("#baterie").val(54);
                break;
            case "Model X":
                versionX.forEach(myFunction("#versiune"));
                interiorSX.forEach(myFunction("#interior"));
                wheelsX.forEach(myFunction("#jante"));
                $("#nr_usi").val(5);
                $("#tractiune").val("Integrala");
                $("#baterie").val(100);
                break;
            case "Model Y":
                versionY.forEach(myFunction("#versiune"));
                interior3Y.forEach(myFunction("#interior"));
                wheelsY.forEach(myFunction("#jante"));
                $("#nr_usi").val(5);
                $("#tractiune").val("Integrala");
                $("#baterie").val(82);
                break;
        }
    })

    $("#versiune").change(function (){
        switch ($("#model").val()){
            case "Model S":
            case "Model X":
                if ($("#versiune").val() === "Long Range")
                    $("#baterie").val(100);
                else
                    $("#baterie").val(130);
                break;
            case "Model 3":
                $("#jante").empty();
                if ($("#versiune").val() === "Performance")
                    ["20'' Black"].forEach(myFunction("#jante"));
                else
                    wheels3.forEach(myFunction("#jante"));

                if ($("#versiune").val() === "Standard Range Plus") {
                    $("#tractiune").val("Spate");
                    $("#baterie").val(54);
                } else {
                    $("#tractiune").val("Integrala");
                    $("#baterie").val(82);
                }
                break;
            case "Model Y":
                $("#jante").empty();
                if ($("#versiune").val() === "Performance")
                    ["21'' Black"].forEach(myFunction("#jante"));
                else
                    wheelsY.forEach(myFunction("#jante"));
                break;
        }
    })

    function myFunction(combo) {
        return function (item) {
            $(combo).append("<option value='" + item + "'>" + item + "</option>");
        }
    }
})