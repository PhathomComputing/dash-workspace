function getData() {
    console.log("call made");
    var url = 'https://query.yahooapis.com/v1/public/yql';
    var symbol = $("#symbol").val();
    var data = encodeURIComponent("select * from yahoo.finance.quotes where symbol in ('" + symbol + "')");

    $.getJSON(url, 'q=' + data + "&format=json&diagnostics=true&env=http://datatables.org/alltables.env")
        .done(function (data) {
            console.log("call 2 made");
            $('#result').text("Price: " + data.query.results.quote.LastTradePriceOnly);
        })
        .fail(function (jqxhr, textStatus, error) {
            var err = textStatus + ", " + error;
            console.log('Request failed: ' + err);
        });
}

