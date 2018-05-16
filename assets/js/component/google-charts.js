
import {GoogleCharts} from 'google-charts';

$( document ).ready(function () {
    //Load the 'corecharts'. You do not need to provide that as a type.
    let url =  Routing.generate('statistic-json');

    let jsonData = $.ajax({
        method: 'post',
        url: url,
        dataType: "json",
        async: false
    }).responseText;
    GoogleCharts.load(drawCharts);
    console.log(jsonData);
    function drawCharts() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Gouvernement');
        data.addColumn('number', 'Nombre d\'artisan ');
        let result = JSON.parse(jsonData);
        console.log(result);
        $.each(result.artisan_by_gov, function(i,result)
        {
                var value=result.value;
                var name=result.name;
                data.addRows([ [name, Number.parseInt(value)]]);
        });


        let options = {
            'region': 'TN',
            'resolution':'provinces',
            'displayMode': 'markers',
            'forceIFrame':true,
            'domain': 'TN',
            'title':'Nombre d\'activité par artisan',
            'width':600,
            'height':300,
            'legend':  {
                'textStyle': {
                    'color': 'blue',
                    'fontSize': 16
                }
                },
            'colorAxis': {'colors': ['#2b3e4c', '#8cc448']},
            'datalessRegionColor': '#dedede',
            'defaultColor': '#dedede'
        };

        let chart = new google.visualization.GeoChart(document.getElementById('chart1'));

        chart.draw(data, options);
    }
    GoogleCharts.load(drawChart2);
    function drawChart2() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        let result = JSON.parse(jsonData);
        console.log(result);
        $.each(result.artisan_by_activity, function(i,result)
        {
            var value=result.value;
            var activity=result.activity;
            data.addRows([ [activity, Number.parseInt(value)]]);
        });

        // Set chart options
        var options = {'title':'Nombre de groupe d\'activité par artisan',
            'width':600,
            'height':300};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart2'));
        chart.draw(data, options);
    }
    GoogleCharts.load(drawChart3);
    function drawChart3() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        let result = JSON.parse(jsonData);
        console.log(result);
        $.each(result.artisan_by_trades, function(i,result)
        {
            var value=result.value;
            var trades=result.trades;
            data.addRows([ [trades, Number.parseInt(value)]]);
        });

        // Set chart options
        var options = {'title':'Nombre d\'activité par artisan',
            'width':600,
            'height':300};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart3'));
        chart.draw(data, options);
    }

    GoogleCharts.load(drawChart4);
    function drawChart4() {
        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Activity');
        data.addColumn('string', 'trades');
        data.addColumn('number', 'Nombre d\'artisan ');
        let result = JSON.parse(jsonData);
        console.log(result);
        $.each(result.artisan_by_activity_by_trades, function(i,result)
        {
            var value=result.value;
            var activity=result.activity;
            var trades=result.trades;
            data.addRows([ [activity, trades,  Number.parseInt(value)]]);
        });

        var chart = new google.visualization.AnnotationChart(document.getElementById('chart4'));

        var options = {
            displayAnnotations: true
        };

        chart.draw(data, options);
    }

});
