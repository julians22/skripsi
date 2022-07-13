export var rupiah = (angka) => {
    var rupiah = '';
    // let clean_text = cleanText(angka);
    var angkarev = angka.toString().split('').reverse().join('');
    for (var i = 0; i < angkarev.length; i++) if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
    return 'Rp. ' + rupiah.split('', rupiah.length - 1).reverse().join('');
}

// clean text from .00 and ,00 and etc
const cleanText = (text) => {

    //  check if text is number
    if (isNaN(text)) {
        return text;
    }

    // check text has .00 or ,00 or etc
    if (text.indexOf('.00') > -1) {
        // remove .00
        text = text.replace('.00', '');
    }
    if (text.indexOf(',00') > -1) {
        // remove ,00
        text = text.replace(',00', '');
    }
    if (text.indexOf(',') > -1) {
        // remove ,
        text = text.replace(',', '');
    }
    return text;
}

