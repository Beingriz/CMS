function myamt() {
    var x = document.getElementById("amount");
    particular = document.forms[0].perticular.value;
    if (particular == "A4 Lamination") {
        x.value = 25;
    }
    if (particular == "Color Xerox") {
        x.value = 10;
    }
    if (particular == "Print Out") {
        x.value = 10;
    }
    if (particular == "Aadhar Download") {
        x.value = 100;
    }
    if (particular == "Card Lamination") {
        x.value = 40;
    }
    if (particular == "Aadhar Lamination") {
        x.value = 20;
    }
    if (particular == "Ration Card Update") {
        x.value = 700;
    }
    if (particular == "Ration Card Lamination") {
        x.value = 25;
    }
    if (particular == "Color Print Out") {
        x.value = 15;
    }
    if (particular == "New Pan Card") {
        x.value = 350;
    }
    if (particular == "Pan Card Correction") {
        x.value = 350;
    }
    if (particular == "Aadhar Update") {
        x.value = 150;
    }
    if (particular == "New Election ID Card") {
        x.value = 100;
    }
    if (particular == "ID Card Deletion") {
        x.value = 50;
    }
    if (particular == "ID Card Correction") {
        x.value = 50;
    }
    if (particular == "New Ration Card") {
        x.value = 300;
    }
    if (particular == "New Passport") {
        x.value = 3000;
    }
    if (particular == "Passport Renewal") {
        x.value = 3000;
    }
}




function Balance() {
    var total_amount = document.getElementById('Total_Amount');
    var amount_paid = document.getElementById('Amount_Paid');
    var balanace = document.getElementById('Balance');

    var Bal
    Bal = (total_amount.value - amount_paid.value);
    balanace.value = Bal;
}

function mobile(a) {
    if (a.value.length = 9) {
        a.value = a.value.slice(0, 10);
    }
}

function aadhar(a) {
    if (a.value.length = 12) {
        a.value = a.value.slice(0, 12);
    }
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#blah')
                .attr('src', e.target.result)
                .width(200)
                .height(200);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function alphaOnly(event) {
    var key = event.keyCode;
    `enter code here`
    return ((key >= 65 && key <= 91) || key == 8 || key == 32);
};