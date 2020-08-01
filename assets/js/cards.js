$(document).ready(function(){
    $(".thrash-card").click(function(e){
        let thisTag = $(this).closest(".card-container")[0];
        let idCard = thisTag.getAttribute('data-card-id');
        let dataString = 'idCard='+idCard;
        $.ajax({
            type:"POST",
            url: "http://localhost/montoya/core/ajax/card.php",
            data: dataString,
            cache: false,
            success: function (data){
                thisTag.remove();
                swal("Deleted", "Your card has been deleted", "success");
            },
            error: function(err){
                swal("Error", "Try again later", "error");
            }
        });
    });

    $("#deposit-money").click(function(e){
        if($("#quantity-deposit").val() == ""){
            swal("Error", "Add the quantity you want to danate", "error"); 
        }
        if($("#option-card-id").val()==""){
            swal("Error", "Select a card", "error"); 
        }
        if($("#quantity-deposit").val() != "" && $("#option-card-id").val() != ""){
            let idCard = $("#option-card-id").val();
            let quantity = $("#quantity-deposit").val();
            let dataString = 'id_card='+idCard+'&quantity='+quantity;
            $.ajax({
                type:"POST",
                url: "http://localhost/montoya/core/ajax/card.php",
                data: dataString,
                cache: false,
                success: function (data){
                    let finalmoney = parseFloat($("#current-money").text()) + parseFloat(quantity);
                    $("#current-money").text(finalmoney);
                    $("#quantity-deposit").val("");

                    swal("Money", "Now you have more money in your account", "success");
                   
                },
                error: function(err){
                    swal("Error", "Try again later", "error");
                }
            });
        }
    });

    
});